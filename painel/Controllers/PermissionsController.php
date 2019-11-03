<?php

namespace Controllers;

use \Core\Controller;
use \Models\Users;
use \Models\Permissions;

class PermissionsController extends Controller {

    private $user;
    private $arrayInfo;

    public function __construct() {
        $this->user = new Users();
        if (!$this->user->isLogged()) {
            header("Location: " . BASE_URL . "login");
            exit;
        }
        if (!$this->user->hasPermission('permissions_view')) {
            header("Location: " . BASE_URL);
            exit;
        }
        $this->arrayInfo = [
            'user' => $this->user,
            'menuActive' => 'permissions'
        ];
    }

    public function index() {
        $p = new Permissions();
        $this->arrayInfo['list'] = $p->getAllGroups();


        $this->loadTemplate('permissions', $this->arrayInfo);
    }

    public function items() {
        $p = new Permissions();
        $this->arrayInfo['list'] = $p->getAllItems();


        $this->loadTemplate('permissionsItems', $this->arrayInfo);
    }

    public function del($id) {
        $p = new Permissions();
        $p->deleteGroup($id);
        header("Location: " . BASE_URL . "permissions");
        exit;
    }

    public function add() {
        $this->arrayInfo['error'] = "";
        if (!empty($_SESSION['erroPerm'])) {
            $this->arrayInfo['error'] = $_SESSION['erroPerm'];
            unset($_SESSION['erroPerm']);
        }
        $p = new Permissions();
        $array['permissionItems'] = $p->getAllItems();

        $this->loadTemplate("permissionsAdd", $this->arrayInfo);
    }

    public function addAction() {
        if (!empty($_POST['name'])) {
            $name = addslashes($_POST['name']);
            $p = new Permissions();
            $id = $p->addGroup($name);
            if (!empty($_POST['items'])) {
                foreach ($_POST['items'] as $i) {
                    $p->linkItemToGroup($i, $id);
                }
            }
            header("Location: " . BASE_URL . "permissions");
        } else {
            $_SESSION['erroPerm'] = 1;
            header("Location: " . BASE_URL . "permissions/add");
        }
    }

    public function edit($id) {
        if (!empty($id)) {
            $this->arrayInfo['error'] = "";
            if (!empty($_SESSION['erroPerm'])) {
                $this->arrayInfo['error'] = $_SESSION['erroPerm'];
                unset($_SESSION['erroPerm']);
            }
            $p = new Permissions();
            $this->arrayInfo['permissionId'] = $id;
            $this->arrayInfo['permissionItems'] = $p->getAllItems();
            $this->arrayInfo['permissionGroupName'] = $p->getPermissionGroupName($id);
            $this->arrayInfo['permissionGroupLinks'] = $p->getPermissions($id);

            $this->loadTemplate("permissionsEdit", $this->arrayInfo);
        } else {
            header("Location: " . BASE_URL . "permissions");
            exit;
        }
    }

    public function editAction($id) {
        if (!empty($id)) {
            if (!empty($_POST['name'])) {
                $name = addslashes($_POST['name']);
                $p = new Permissions();
                $p->editGroup($id, $name);
                $p->clearLinks($id);
                if (!empty($_POST['items'])) {
                    foreach ($_POST['items'] as $i) {

                        $p->linkItemToGroup($i, $id);
                    }
                }
                header("Location: " . BASE_URL . "permissions");
            } else {
                $_SESSION['erroPerm'] = 1;
                header("Location: " . BASE_URL . "permissions/edit/$id");
            }
        } else {
            header("Location: " . BASE_URL . "permissions");
        }
    }

}
