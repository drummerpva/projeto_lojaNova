<?php

class paypalController extends Controller {

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
                //Começar integração ao PayPal
                $apiContext = new \PayPal\Rest\ApiContext(
                        new \PayPal\Auth\OAuthTokenCredential(
                        $config['paypalClienteId'], $config['paypalSecret']
                        )
                );
                $payer = new \PayPal\Api\Payer();
                $payer->setPaymentMethod("paypal");
                $amount = new \PayPal\Api\Amount();
                $amount->setCurrency("BRL")->setTotal($total);
                $transaction = new \PayPal\Api\Transaction();
                $transaction->setAmount($amount);
                $transaction->setInvoiceNumber($idPurchase);

                $redirectUrls = new \PayPal\Api\RedirectUrls();
                $redirectUrls->setReturnUrl(BASE_URL . "paypal/obrigado");
                $redirectUrls->setCancelUrl(BASE_URL . "paypal/calcelou");

                $payment = new \PayPal\Api\Payment();
                $payment->setIntent("sale");
                $payment->setIntent($payer);
                $payment->setTransactions([$transaction]);
                $payment->setRedirectUrls($redirectUrls);

                try {
                    $payment->create($apiContext);
                    header("Location: " . $payment->getApprovalLink());
                    exit;
                } catch (\PayPal\Exception\PayPalConnectionException $ex) {
                    echo "Erro: " . $ex->getData();
                    exit;
                }
            }
        }
        $this->loadTemplate("cartPayPal", $dados);
    }

    public function obrigado() {
        $purchases = new Purchases();
        global $config;
        $apiContext = new \PayPal\Rest\ApiContext(
                new \PayPal\Auth\OAuthTokenCredential(
                $config['paypalClienteId'], $config['paypalSecret']
                )
        );
        $paymentId = $_GET['paymentId'];
        $payment = \PayPal\Api\Payment::get($paymentId, $apiContext);

        $execution = new \PayPal\Api\PaymentExecution();
        $execution->setPayerId($_GET['PayerID']);

        try {
            $result = $payment->execute($execution, $apiContext);
            try {
                $payment = \PayPal\Api\Payment::get($paymentId, $apiContext);
                $status = $payment->getState();
                $t = current($payment->getTransactions());
                $t = $t->toArray();
                $ref = $t['invoice_number'];
                if ($status == "approved") {
                    $purchases->setPaid($ref);
                    unset($_SESSION['cart']);
                    $store = new Store();
                    $dados = $store->getTemplateData();
                    $this->loadTemplate("paypalObrigado", $dados);
                } else {
                    $purchases->setCancelled($ref);
                    header("Location: " . BASE_URL . "paypal/cancelou");
                    exit;
                }
            } catch (Exception $ex) {
                header("Location: " . BASE_URL . "paypal/cancelou");
                exit;
            }
        } catch (Exception $ex) {
            header("Location: " . BASE_URL . "paypal/cancelou");
            exit;
        }
    }

    public function cancelou() {
        unset($_SESSION['cart']);
        $store = new Store();
        $dados = $store->getTemplateData();

        $this->loadTemplate("paypalCancelar", $dados);
    }

}
