<?php

namespace Models;

use \Core\Model;

class Categories extends Model {

    public function getAll() {
        $array = [];
        $sql = $this->db->prepare("SELECT * FROM categories ORDER BY sub DESC");
        $sql->execute();
        if ($sql->rowCount() > 0) {
            $data = $sql->fetchAll(\PDO::FETCH_ASSOC);
            foreach ($data as $i) {
                $i['subs'] = [];
                $array[$i['Id']] = $i;
            }
            while ($this->stillNeed($array)) {
                $this->organizeCategory($array);
            }
        }
        return $array;
    }

    private function organizeCategory(&$array) {
        foreach ($array as $id => $val) {
            if (!empty($val['sub'])) {
                $array[$val['sub']]['subs'][$val['Id']] = $val;
                unset($array[$id]);
                break;
            }
        }
    }

    private function stillNeed($array) {
        foreach ($array as $i) {
            if (!empty($i['sub'])) {
                return true;
            }
        }
        return false;
    }

}
