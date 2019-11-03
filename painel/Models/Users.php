<?php

namespace Models;

use \Core\Model;
use \Models\Permissions;

class Users extends Model {

    private $uId;
    private $permissions;
    private $name;
    private $admin;

    public function isLogged() {
        if (!empty($_SESSION['token'])) {
            $token = $_SESSION['token'];
            $sql = $this->db->prepare("SELECT Id, id_permission, name, admin FROM users WHERE token = ?");
            $sql->execute([$token]);
            if ($sql->rowCount() > 0) {
                $p = new Permissions();
                $sql = $sql->fetch();
                $this->uId = $sql['Id'];
                $this->name = $sql['name'];
                $this->isAdmin = ($sql['admin']) ? true: false;
                $this->permissions = $p->getPermissions($sql['id_permission']);
                
                return true;
            }
        }
        return false;
    }
    
    public function hasPermission($permission_slug){
        if(in_array($permission_slug, $this->permissions)){
            return true;
        }else{
            return false;
        }
    }

    public function validateLogin($email, $senha) {
        $sql = $this->db->prepare("SELECT Id FROM users WHERE email = :email AND password = :pass AND admin = 1");
        $sql->bindValue(":email", $email);
        $sql->bindValue(":pass", $senha);
        $sql->execute();
        if ($sql->rowCount() > 0) {
            $sql = $sql->fetch();
            $this->uId = $sql['Id'];
            $token = md5(time() . rand(0, 999) . $this->uId . time());
            $sql = $this->db->prepare("UPDATE users SET token = :token WHERE Id = :id");
            $sql->bindValue(":token", $token);
            $sql->bindValue(":id", $this->uId);
            $sql->execute();
            $_SESSION['token'] = $token;
            return true;
        }
        return false;
    }
    public function getName(){
        return $this->name;
    }
    public function isAdmin(){
        return $this->admin;
    }
    public function getId() {
        return $this->uId;
    }

}
