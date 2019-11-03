<?php

class Users extends Model {

    public function emailExists($email) {
        $sql = $this->db->prepare("SELECT id FROM users WHERE email = :email");
        $sql->bindValue(":email", $email);
        $sql->execute();
        if ($sql->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function validade($email, $pass) {
        $id = "";
        $sql = $this->db->prepare("SELECT Id FROM users WHERE email = :email AND password = :pass");
        $sql->bindValue(":email", $email);
        $sql->bindValue(":pass", $pass);
        $sql->execute();
        if ($sql->rowCount() > 0) {
            $sql = $sql->fetch();
            $id = $sql['Id'];
        }
        return $id;
    }

    public function createUser($email, $pass) {
        $id = "";
        $sql = $this->db->prepare("INSERT INTO users(email, password) VALUES(:email, :pass)");
        $sql->bindValue(":email", $email);
        $sql->bindValue(":pass", $pass);
        $sql->execute();
        $id = $this->db->lastInsertId();
        return $id;
    }

}
