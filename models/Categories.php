<?php

class Categories extends Model {

    public function getList($pai = 0) {
        $array = [];
        $sql = $this->db->query("SELECT * FROM categories ORDER BY sub DESC");
        if ($sql->rowCount() > 0) {
            foreach ($sql->fetchAll() as $item) {
                $item['subs'] = [];
                $array[$item['Id']] = $item;
            }
            while ($this->stillNeed($array)) {
                $this->organizeCategory($array);
            }
        }
        return $array;
    }

    public function getCategoryTree($id) {
        $dados = [];
        $haveChild = true;
        while ($haveChild) {
            $sql = $this->db->prepare("SELECT * FROM categories WHERE id = ?");
            $sql->execute([$id]);
            if ($sql->rowCount() > 0) {
                $sql = $sql->fetch(PDO::FETCH_ASSOC);
                $dados[] = $sql;
                if (!empty($sql['sub'])) {
                    $id = $sql['sub'];
                } else {
                    $haveChild = false;
                }
            } else {
                $haveChild = false;
            }
        }
        $dados = array_reverse($dados);
        return $dados;
    }
    public function getCategoryName($id){
        $ret = "";
        $sql = $this->db->prepare("SELECT name FROM categories WHERE id = ?");
        $sql->execute([$id]);
        if($sql->rowCount()> 0){
            $sql = $sql->fetch(PDO::FETCH_ASSOC);
            $ret = $sql['name'];
        }
        return $ret;
    }
    

    private function organizeCategory(&$array) {
        foreach ($array as $id => $v) {
            if (isset($array[$v['sub']])) {
                $array[$v['sub']]['subs'][$v['Id']] = $v;
                unset($array[$id]);
                break;
            }
        }
    }

    private function stillNeed($array) {
        foreach ($array as $a) {
            if (!empty($a['sub'])) {
                return true;
            }
        }
        return false;
    }

}
