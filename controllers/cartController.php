<?php

class cartController extends controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        if (empty($_SESSION['cart']) || count($_SESSION['cart']) == 0) {
            header("Location: " . BASE_URL);
            exit;
        }
        $store = new Store();
        $products = new Products();
        $cart = new Cart();
        $cep = "";
        if (!empty($_POST['cep'])) {
            $cep = intval($_POST['cep']);
            $shipping = $cart->shippingCalculate($cep);
            $_SESSION['shipping'] = $shipping;
            header("Location: " . BASE_URL . "cart");
        }
        if (!empty($_SESSION['shipping'])) {
            $shipping = $_SESSION['shipping'];
        }
        $dados = $store->getTemplateData();
        $dados['list'] = $cart->getList();
        $dados['shipping'] = $shipping ?? [];



        $this->loadTemplate('cart', $dados);
    }

    public function del($id) {
        if (!empty($id)) {
            unset($_SESSION['cart'][$id]);
        }
        header("Location: " . BASE_URL . "cart");
        exit;
    }

    public function add() {
        if (!empty($_POST['idProduct'])) {
            $id = (int) $_POST['idProduct'];
            $qt = (int) $_POST['qtProduct'];

            if (empty($_SESSION['cart'])) {
                $_SESSION['cart'] = [];
            }
            if (!empty($_SESSION['cart'][$id])) {
                $_SESSION['cart'][$id] += $qt;
            } else {
                $_SESSION['cart'][$id] = $qt;
            }
        }
        header("Location: " . BASE_URL . "cart");
        exit;
    }

    public function paymentRedirect() {
        if (!empty($_POST["paymentType"])) {
            
            $paymentType = addslashes($_POST['paymentType']);
            switch ($paymentType) {
                
                case "checkoutTransparente":
                    header("Location: " . BASE_URL . "psCktTransparente");
                    exit;
                    break;
                case "mp":
                    header("Location: " . BASE_URL . "mp");
                    exit;
                    break;
                case "paypal":
                    header("Location: " . BASE_URL . "paypal");
                    exit;
                    break;
                case "boleto":
                    header("Location: " . BASE_URL . "boleto");
                    exit;
                    break;
            }
        }
        header("Location: " . BASE_URL . "cart");
        exit;
    }

}
