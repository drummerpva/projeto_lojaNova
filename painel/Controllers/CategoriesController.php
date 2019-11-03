<?php

namespace Controllers;

use \Core\Controller;
use \Models\Users;
use \Models\Categories;

class CategoriesController extends Controller {
    private $user;
    private $arrayInfo;
    public function __construct() {
        $this->user = new Users();
        if(!$this->user->isLogged()){
            header("Location: ".BASE_URL."login");
            exit;
        }
        $this->arrayInfo = [
            'user' => $this->user,
            'menuActive' => 'categories'
        ];
    }

    public function index() {
        $c = new Categories();
        $this->arrayInfo['list'] = $c->getAll();

        $this->loadTemplate('categories', $this->arrayInfo);
    }

}
