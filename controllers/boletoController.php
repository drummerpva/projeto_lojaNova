<?php

class boletoController extends Controller {

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
                $idPurchase = $purchases->createPurchase($uId, $total, "paypal");

                //Adicionar Produtos a venda
                foreach ($list as $i) {
                    $purchases->addProductPurchase($idPurchase, $i['id'], $i['qt'], str_replace(",", ".", $i['price']));
                }
                global $config;
                //Começar integração com Boleto
                $options = [
                    "client_id" => $config['gerencianetClientId'],
                    "client_secret" => $config['gerencianetSecret'],
                    "sandbox" => $config['gerencianetSandbox']
                ];
                $items = [];
                foreach ($list as $item) {
                    $items[] = [
                        "name" => $item['name'],
                        "amount" => $item['qt'],
                        "value" => ($item['price'] * 100)
                    ];
                }
                $metadata = [
                    "custom_id" => $idPurchase,
                    "notification_url" => BASE_URL . "boleto/notification"
                ];
                $shipping = [
                    [
                        "name" => "FRETE",
                        "value" => ($frete * 100)
                    ]
                ];
                $body = [
                    "metadata" => $metadata,
                    "items" => $items,
                    "shippings" => $shipping
                ];
                try {
                    $api = new \Gerencianet\Gerencianet($options);
                    $charge = $api->createCharge([], $body);
                    if ($charge['code'] == "200") {
                        $chargeId = $charge['data']['charge_id'];

                        $params = [
                            'id' => $chargeId
                        ];
                        $customer = [
                            'name' => $name,
                            'cpf' => $cpf,
                            'phone_number' => $telefone
                        ];
                        $bankingBillet = [
                            'expire_at' => date('Y-m-d', strtotime('+4 days')),
                            'customer' => $customer
                        ];
                        $payment = [
                            'banking_billet' => $bankingBillet,
                        ];
                        $body = [
                            'payment' => $payment
                        ];
                        try {
                            $charge = $api->payCharge($params, $body);
                            if ($charge['code'] == "200") {
                                $link = $charge['data']['link'];
                                $purchases->updateBilletUrl($idPurchase, $link);
                                unset($_SESSION['cart']);
                                header("Location: " . $link);
                                exit;
                            }
                        } catch (Exception $ex) {
                            echo "Erro: " . $ex->getMessage();
                            exit;
                        }
                    }
                } catch (Exception $ex) {
                    echo "Erro: " . $ex->getMessage();
                    exit;
                }
            }
        }
        $this->loadTemplate("cartBoleto", $dados);
    }

    public function notification() {
        global $config;
        $options = [
            "client_id" => $config['gerencianetClientId'],
            "client_secret" => $config['gerencianetSecret'],
            "sandbox" => $config['gerencianetSandbox']
        ];
        $token = $_POST['notification'];
        $params = [
            "token" => $token
        ];
        try{
            $api = new \Gerencianet\Gerencianet($options);
            $c = $api->getNotification($params, []);
            $ultimo = end($c['data']);
            $customId = $ultimo['custom_id'];
            $status = $ultimo['status']['current'];
            if($status == 'paid'){
                $purchases = new Purchases();
                $purchases->setPaid($customId);
            }
            
            
        } catch (Exception $ex) {
            echo "Erro: ".$ex->getMessage();
            exit;
        }
    }

}
