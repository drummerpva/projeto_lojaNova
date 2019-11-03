<?php

class mpController extends Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $store = new Store();
        $dados = $store->getTemplateData();
        $dados['error'] = "";
        $user = new Users();
        $cart = new Cart();
        $purchases = new Purchases();
        if (!empty($_POST['name'])) {
            $name = addslashes($_POST['name']);
            $cpf = addslashes($_POST['cpf']);
            $telefone = addslashes($_POST['telefone']);
            $email = addslashes($_POST['email']);
            $pass = md5($_POST['password']);
            $cep = addslashes($_POST['cep']);
            $rua = addslashes($_POST['rua']);
            $numero = addslashes($_POST['numero']);
            $complemento = addslashes($_POST['complemento']);
            $bairro = addslashes($_POST['bairro']);
            $cidade = addslashes($_POST['cidade']);
            $estado = addslashes($_POST['estado']);

            if ($user->emailExists($email)) {
                $uId = $user->validade($email, $pass);
                if (empty($uId)) {
                    $dados['error'] = "Email e/ou senha não conferem";
                }
            } else {
                $uId = $user->createUser($email, $pass);
            }
            if (!empty($uId)) {
                $list = $cart->getList();
                $total = 0;
                $frete = 0;
                foreach ($list as $i) {
                    $total += ($i['price'] * $i['qt']);
                }
                if (!empty($_SESSION['shipping'])) {
                    $shipping = $_SESSION['shipping'];
                    if (isset($shipping['price'])) {
                        $frete = str_replace(",", ".", $shipping['price']);
                    } else {
                        $frete = 0;
                    }
                    $total += $frete;
                }
                //Adicionar venda ao BD
                $idPurchase = $purchases->createPurchase($uId, $total, "mp");

                //Adicionar Produtos a venda
                foreach ($list as $i) {
                    $purchases->addProductPurchase($idPurchase, $i['id'], $i['qt'], str_replace(",", ".", $i['price']));
                }
                global $config;
                $mp = new MP($config['mpAppId'], $config['mpKey']);
                $data = [
                    "items" => [],
                    "shipments" => [
                        "mode" => "custom",
                        "cost" => (Double) $frete,
                        "receiver_address" => [
                            "zip_code" => $cep
                        ]
                    ],
                    "back_urls" => [
                        "success" => BASE_URL . "mp/obrigadoAprovado",
                        "pending" => BASE_URL . "mp/obrigadoAnalise",
                        "failure" => BASE_URL . "mp/obrigadoCancelado"
                    ],
                    "notification_url" => BASE_URL . "mp/notification",
                    "auto_return" => "all",
                    "external_reference" => $idPurchase
                ];
                foreach ($list as $i) {
                    $data["items"][] = [
                        "title" => $i['name'],
                        'quantity' => $i['qt'],
                        "currency_id" => "BRL",
                        "unit_price" => (Double) $i['price']
                    ];
                }
                $link = $mp->create_preference($data);
                if ($link['status'] == "201") {
                    //$link = $link['response']['init_point'];
                    $link = $link['response']['sandbox_init_point'];
                    header("Location: " . $link);
                    exit;
                } else {
                    $dados['error'] = "Tente novamente mais tarde";
                }
            }
        }


        $this->loadTemplate("cartMp", $dados);
    }

    public function notification() {
        $purchase = new Purchases();
        global $config;
        $mp = new MP($config['mpAppId'], $config['mpKey']);
        $mp->sandbox_mode(true);
        $info = $mp->get_payment_info($_GET['id']);
        if($info['status'] == "200"){
            $array = $info['response'];
            $ref = $array['collection']['external_reference'];
            $status = $array['collection']['status'];
            /*
             * pending - Em análise
             * approved - Aprovado
             * in_process - em revisão
             * in_mediation - Em processo de disputa
             * rejected - Rejeitado
             * cancelled - Cancelado
             * refunded - Reembolsado
             * charged_back - Chargeback
             */
            if($status == "approved"){
                $purchase->setPaid($ref);
            }elseif($status == "cancelled"){
                $purchase->setCancelled($ref);
            }
        }
    }

}
