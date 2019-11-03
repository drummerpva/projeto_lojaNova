<?php

class Purchases extends Model {

    public function createPurchase($uId, $total, $paymentType) {
        $id = "";
        $sql = $this->db->prepare("INSERT INTO purchases(id_user, total_amount, payment_type, payment_status) VALUES(:uId, :total, :type, 1)");
        $sql->bindValue(":uId", $uId);
        $sql->bindValue(":total", $total);
        $sql->bindValue(":type", $paymentType);
        $sql->execute();
        $id = $this->db->lastInsertId();
        return $id;
    }

    public function addProductPurchase($id, $idProduct, $priceProduct, $qtProduct) {
        $sql = $this->db->prepare("INSERT INTO purchases_products(id_purchase, id_product, product_price, quantity) VALUES(:pId, :idProd, :price, :qt)");
        $sql->bindValue(":pId", $id);
        $sql->bindValue(":idProd", $idProduct);
        $sql->bindValue(":price", $priceProduct);
        $sql->bindValue(":qt", $qtProduct);
        $sql->execute();
    }

    public function setPaid($ref) {
        $sql = $this->db->prepare("UPDATE purchase SET payment_status = :status WHERE Id = :id");
        $sql->bindValue(":status", "2");
        $sql->bindValue(":id", $ref);
        $sql->execute();
    }

    public function setCancelled($ref) {
        $sql = $this->db->prepare("UPDATE purchase SET payment_status = :status WHERE Id = :id");
        $sql->bindValue(":status", "3");
        $sql->bindValue(":id", $ref);
        $sql->execute();
    }

    public function updateBilletUrl($ref, $link) {
        $sql = $this->db->prepare("UPDATE purchases SET billet_link = :link WHERE Id = :id");
        $sql->bindValue(":link", $link);
        $sql->bindValue(":id", $ref);
        $sql->execute();
    }

}
