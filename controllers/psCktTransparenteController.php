<?php

class psCktTransparenteController extends Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $store = new Store();
        $products = new Products();
        $dados = $store->getTemplateData();
        try {
            $sessionCode = \PagSeguro\Services\Session::create(
                            \PagSeguro\Configuration\Configure::getAccountCredentials()
            );
            $dados['sessionCode'] = $sessionCode->getResult();
        } catch (Exception $ex) {
            echo "Erro: " . $ex->getMessage();
            exit;
        }

        $this->loadTemplate("cartPsCktTransparente", $dados);
    }

    public function checkout() {
        if (!empty($_POST['id'])) {
            $user = new Users();
            $cart = new Cart();
            $purchases = new Purchases();

            $id = addslashes($_POST['id']);
            $name = addslashes($_POST['name']);
            $cpf = addslashes($_POST['cpf']);
            $telefone = addslashes($_POST['telefone']);
            $email = addslashes($_POST['email']);
            $pass = md5($_POST['pass']);
            $cep = addslashes($_POST['cep']);
            $rua = addslashes($_POST['rua']);
            $numero = addslashes($_POST['numero']);
            $complemento = addslashes($_POST['complemento']);
            $bairro = addslashes($_POST['bairro']);
            $cidade = addslashes($_POST['cidade']);
            $estado = addslashes($_POST['estado']);
            $cartaoTitular = addslashes($_POST['cartaoTitular']);
            $cartaoCpf = addslashes($_POST['cartaoCpf']);
            $cartaoNumero = addslashes($_POST['cartaoNumero']);
            $cvv = addslashes($_POST['cvv']);
            $vMes = addslashes($_POST['vMes']);
            $vAno = addslashes($_POST['vAno']);
            $cartaoToken = addslashes($_POST['cartaoToken']);
            $parc = explode(";", $_POST['parc']);

            if ($user->emailExists($email)) {
                $uId = $user->validade($email, $pass);
                if (empty($uId)) {
                    $array = ["error" => true, "msg" => "Email e/ou senha não conferem"];
                    echo json_encode($array);
                    exit;
                }
            } else {
                $uId = $user->createUser($email, $pass);
            }

            //Calculo do carrinho edo frete
            $list = $cart->getList();
            $total = 0;
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
            $idPurchase = $purchases->createPurchase($uId, $total, "pcCktTransparente");

            //Adicionar Produtos a venda
            foreach ($list as $i) {
                $purchases->addProductPurchase($idPurchase, $i['id'], $i['qt'], str_replace(",", ".", $i['price']));
            }

            //Inicio do Pagamento via PagSeguro
            $creditCard = new \PagSeguro\Domains\Requests\DirectPayment\CreditCard();
            global $config;
            $creditCard->setReceiverEmail($config['pagseguroSeller']);
            $creditCard->setReference($idPurchase);
            $creditCard->setCurrency("BRL");
            foreach ($list as $i) {
                $creditCard->addItems()->withParameters(
                        $i['id'], $i['name'], (int) $i['qt'], (Double) str_replace(",", ".", $i['price'])
                );
            }
            $creditCard->setSender()->setName($name);
            $creditCard->setSender()->setEmail($email);
            $creditCard->setSender()->setPhone()->withParameters(substr($telefone, 0, 2), substr($telefone, 2));
            $creditCard->setSender()->setDocument()->withParameters("CPF", $cpf);
            $creditCard->setSender()->setHash($id);
            $ip = (strlen($_SERVER['REMOTE_ADDR']) < 9) ? "127.0.0.1" : $_SERVER['REMOTE_ADDR'];
            $creditCard->setSender()->setIp($ip);

            $creditCard->setShipping()->setAddress()->withParameters(
                    $rua, $numero, $bairro, $cep, $cidade, $estado, "BRA", $complemento
            );
            $creditCard->setBilling()->setAddress()->withParameters(
                    $rua, $numero, $bairro, $cep, $cidade, $estado, "BRA", $complemento
            );

            $creditCard->setToken($cartaoToken);
            $creditCard->setInstallment()->withParameters($parc[0], $parc[1]);
            $creditCard->setHolder()->setName($cartaoTitular);
            $creditCard->setHolder()->setDocument()->withParameters("CPF", $cartaoCpf);

            $creditCard->setMode("DEFAULT");

            $creditCard->setNotificationUrl(BASE_URL . "psCktTransparente/notification");

            try {
                $result = $creditCard()->register(\PagSeguro\Configuration\Configure::getAccountCredentials());
                echo json_encode($result);
                exit;
            } catch (Exception $ex) {
                echo json_encode(["error" => true, "msg" => "Erro ao registrar pagamento"]);
                exit;
            }
        } else {
            echo json_encode(["error" => true, "msg" => "Não existem daddos para receber, Verifique!"]);
            exit;
        }
    }

    public function obrigado() {
        $store = new Store();
        $dados = $store->getTemplateData();

        $this->loadTemplate("psCktTransparenteObrigado", $dados);
    }

    public function notification() {
        unset($_SESSION['cart']);
        $purchases = new Purchases();
        try {
            if (\PagSeguro\Helpers\Xhr::hasPost()) {
                $r = \PagSeguro\Services\Transctions\Notification::check(\PagSeguro\Configuration\Configure::getAccountCredentials());
                $ref = $r->getReference();
                $status = $r->getStatus();
                /*
                 * 1 - Aguardando Pagamento
                 * 2 - Em análise
                 * 3 - Paga
                 * 4 - Disponível
                 * 5 - Em disputa
                 * 6 - Devolvido
                 * 7 - Cancelada
                 * 8 - Debitado
                 * 9 - Retenção temporária = Chargeback
                 */
                if ($status == 3) {
                    $purchases->setPaid($ref);
                }elseif($status == 7){
                    $purchases->setCancelled($ref);
                }
            }
        } catch (Exception $ex) {
            
        }
    }

}
