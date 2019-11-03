<?php
    class Options extends Model{
        public function getName($id){
            $ret = 0;
            $sql = $this->db->prepare("SELECT name FROM options WHERE id = ?");
            $sql->execute([$id]);
            if($sql->rowCount()>0){
                $sql = $sql->fetch();
                $ret = $sql['name'];
            }
            return $ret;
        }
    }