<?php
    class Brands extends Model{
        public function getNameById($id){
            $array = "";
            $sql = $this->db->prepare("SELECT name FROM brands WHERE id = ?");
            $sql->execute([$id]);
            if($sql->rowCount()>0){
                $sql = $sql->fetch(PDO::FETCH_ASSOC);
                $array = $sql['name'];
            }
            return $array;
        }
        public function getList(){
            $array = [];
            $sql = $this->db->query("SELECT *, (SELECT COUNT(1) FROM products WHERE products.id_brand = brands.Id) as qtItem FROM brands ORDER BY name");
            if($sql->rowCount()>0){
                $array = $sql->fetchAll(PDO::FETCH_ASSOC);
            }
            return $array;
        }
    }