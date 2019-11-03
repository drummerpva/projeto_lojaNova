<?php

class Rates extends Model {

    public function getRates($id, $qt) {
        $array = [];
        $sql = $this->db->prepare("SELECT *,(SELECT users.name FROM users WHERE users.id = rates.id_user) as name_user FROM rates WHERE id_product = :id ORDER BY date_rated DESC LIMIT :qt");
        $sql->bindValue(":id", $id);
        $sql->bindValue(":qt", $qt, PDO::PARAM_INT);
        $sql->execute();
        if ($sql->rowCount() > 0) {
            $array = $sql->fetchAll(PDO::FETCH_ASSOC);
        }
        //print_r($array);
        //exit;
        return $array;
    }

}
