<?php

namespace Models;

use \Core\Model;

class Permissions extends Model {

    public function clearLinks($id){
        $sql = $this->db->prepare("DELETE FROM permission_links WHERE id_permission_group = ?");
        $sql->execute([$id]);
    }
    public function editGroup($id, $name){
        $sql = $this->db->prepare("UPDATE permission_groups SET name = :name WHERE Id = :id");
        $sql->bindValue(":name",$name);
        $sql->bindValue(":id",$id);
        $sql->execute();
    }
    public function addGroup($name) {
        $sql = $this->db->prepare("INSERT INTO permission_groups(name) VALUES(:name)");
        $sql->bindValue(":name", $name);
        $sql->execute();
        return $this->db->lastInsertId();
    }

    public function linkItemToGroup($item, $group) {
        $sql = $this->db->prepare("INSERT INTO permission_links(id_permission_group, id_permission_item) VALUES(:g, :i)");
        $sql->bindValue(":g", $group);
        $sql->bindValue(":i", $item);
        $sql->execute();
    }

    public function getAllGroups() {
        $array = [];
        $sql = $this->db->query("SELECT *,(SELECT COUNT(1) FROM users WHERE users.id_permission = permission_groups.Id) as totalUsers FROM permission_groups");
        if ($sql->rowCount() > 0) {
            $array = $sql->fetchAll(\PDO::FETCH_ASSOC);
        }

        return $array;
    }
    public function getPermissionGroupName($id){
        $sql = $this->db->prepare("SELECT name FROM permission_groups WHERE Id = ?");
        $sql->execute([$id]);
        if($sql->rowCount()>0){
            $sql = $sql->fetch();
            return $sql['name'];
        }else{
            return "";
        }
    }

    public function getAllItems() {
        $array = [];
        $sql = $this->db->query("SELECT * FROM permission_items");
        if ($sql->rowCount() > 0) {
            $array = $sql->fetchAll(\PDO::FETCH_ASSOC);
        }

        return $array;
    }

    public function deleteGroup($id) {
        $sql = $this->db->prepare("SELECT id FROM users WHERE id_permission = ?");
        $sql->execute([$id]);
        if ($sql->rowCount() === 0) {
            $sql = $this->db->prepare("DELETE FROM permission_links WHERE id_permission_group = ?");
            $sql->execute([$id]);
            $sql = $this->db->prepare("DELETE FROM permission_groups WHERE Id = ?");
            $sql->execute([$id]);
        }
    }

    public function getPermissions($pId) {
        $array = [];
        $token = $_SESSION['token'];
        $sql = $this->db->prepare("SELECT (SELECT permission_items.slug FROM permission_items WHERE permission_items.Id = permission_links.id_permission_item) as slug FROM permission_links WHERE id_permission_group = ?");
        $sql->execute([$pId]);
        if ($sql->rowCount() > 0) {
            $sql = $sql->fetchAll(\PDO::FETCH_ASSOC);
            foreach ($sql as $i) {
                $array[] = $i['slug'];
            }
        }
        return $array;
    }

}
