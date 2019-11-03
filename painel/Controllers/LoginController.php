<?php

namespace Controllers;

use \Core\Controller;
use \Models\Users;

class LoginController extends Controller {

    private $user;

    public function __construct() {
        $this->user = new Users();
    }

    public function index() {
        if ($this->user->isLogged()) {
            header("Location: " . BASE_URL);
            exit;
        }
        $array = [
            'error' => ""
        ];
        if (!empty($_SESSION['errorMsg'])) {
            $array['error'] = $_SESSION['errorMsg'];
            unset($_SESSION['errorMsg']);
        }

        $this->loadView('login', $array);
    }

    public function indexAction() {
        if (!empty($_POST['email']) && !empty($_POST['pass'])) {
            $email = addslashes($_POST['email']);
            $pass = md5($_POST['pass']);
            if ($this->user->validateLogin($email, $pass)) {
                header("Location: " . BASE_URL);
                exit;
            } else {
                $_SESSION['errorMsg'] = "Usuário e/ou senha inválido(s)";
            }
        } else {
            $_SESSION['errorMsg'] = "Preencha o(s) campo(s)!";
        }
        header("Location: " . BASE_URL . "login");
    }

    public function logout() {
        unset($_SESSION['token']);
        header("Location: " . BASE_URL);
        exit;
    }

}
