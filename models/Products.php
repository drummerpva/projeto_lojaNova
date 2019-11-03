<?php

class Products extends Model {

    public function getInfo($id) {
        $array = [];
        $sql = $this->db->prepare("SELECT * FROM products WHERE id = :id");
        $sql->bindValue(":id", $id);
        $sql->execute();
        if ($sql->rowCount() > 0) {
            $array = $sql->fetch(PDO::FETCH_ASSOC);
            $images = $this->getImagesByProductId($id);
            $array['image'] = current($images);
        }

        return $array;
    }

    public function getRates($id, $qt) {
        $array = [];
        $r = new Rates();
        $array = $r->getRates($id, $qt);

        return $array;
    }

    public function getOptionsByProductId($id) {
        $options = [];
        $sql = $this->db->prepare("SELECT options FROM products WHERE Id = :id");
        $sql->bindValue(":id", $id);
        $sql->execute();
        if ($sql->rowCount() > 0) {
            $sql = $sql->fetch();
            $options = $sql['options'];
            if (!empty($options)) {
                $sql = $this->db->query("SELECT * FROM options WHERE id IN (" . $options . ")");
                if ($sql->rowCount() > 0) {
                    $options = $sql->fetchAll(PDO::FETCH_ASSOC);
                }
            }
            $sql = $this->db->prepare("SELECT * FROM products_options WHERE id_product = :id");
            $sql->bindValue(":id", $id);
            $sql->execute();
            $values = [];
            if ($sql->rowCount() > 0) {
                foreach ($sql->fetchAll() as $op) {
                    $values[$op['id_option']] = $op['p_value'];
                }
            }
            foreach ($options as $k => $v) {
                if (isset($values[$v['Id']])) {
                    $options[$k]['value'] = $values[$v['Id']];
                } else {
                    $options[$k]['value'] = "";
                }
            }
        }

        return $options;
    }

    public function getProductInfo($id) {
        $array = [];
        if (!empty($id)) {
            $sql = $this->db->prepare("SELECT *,"
                    . "(SELECT brands.name FROM brands WHERE brands.id = products.id_brand) as brand FROM products WHERE id = :id");
            $sql->bindValue(":id", $id);
            $sql->execute();
            if ($sql->rowCount() > 0) {
                $array = $sql->fetch(PDO::FETCH_ASSOC);
            }
        }
        return $array;
    }

    public function getMaxPrice($filters = []) {
        $ret = 0;
        $where = $this->buildWhere($filters);
        $sql = $this->db->prepare("SELECT price as m FROM products "
                . "ORDER BY price DESC LIMIT 1");
        $this->bindWhere($filters, $sql);
        $sql->execute();
        if ($sql->rowCount() > 0) {
            $sql = $sql->fetch(PDO::FETCH_ASSOC);
            $ret = $sql['m'];
        }
        return $ret;
    }

    public function getSaleCount($filters = []) {
        $ret = 0;
        $where = $this->buildWhere($filters);
        $where[] = "sale = 1";
        $sql = $this->db->prepare("SELECT COUNT(1) as c FROM products WHERE "
                . (implode(" AND ", $where)));
        $this->bindWhere($filters, $sql);
        $sql->execute();
        if ($sql->rowCount() > 0) {
            $sql = $sql->fetch(PDO::FETCH_ASSOC);
            $ret = $sql['c'];
        }
        return $ret;
    }

    public function getAvailableOptions($filters = []) {
        $groups = [];
        $ids = [];

        $where = $this->buildWhere($filters);
        $sql = $this->db->prepare("SELECT id, options FROM products WHERE "
                . (implode(" AND ", $where)));
        $this->bindWhere($filters, $sql);
        $sql->execute();
        if ($sql->rowCount() > 0) {
            foreach ($sql->fetchAll() as $it) {
                $ops = explode(",", $it['options']);
                $ids[] = $it['id'];
                foreach ($ops as $op) {
                    if (!in_array($op, $groups)) {
                        $groups[] = $op;
                    }
                }
            }
        }
        $options = $this->getAvailableValuesFromOptions($groups, $ids);


        return $options;
    }

    public function getAvailableValuesFromOptions($groups, $ids) {
        $array = [];
        $o = new Options();
        foreach ($groups as $g) {
            $array[$g] = [
                "name" => $o->getName($g),
                "options" => []
            ];
        }
        $sql = "SELECT"
                . " p_value, id_option, count(1) as c "
                . "FROM products_options WHERE "
                . "id_option IN('" . implode("','", $groups) . "') AND "
                . "id_product IN('" . implode("','", $ids) . "') "
                . "GROUP BY p_value ORDER BY id_option";
        $sql = $this->db->query($sql);
        if ($sql->rowCount() > 0) {
            foreach ($sql->fetchAll() as $ops) {
                $array[$ops['id_option']]['options'][] = [
                    "id" => $ops['id_option'],
                    "value" => $ops['p_value'],
                    "count" => $ops['c']
                ];
            }
        }


        return $array;
    }

    public function getListOfStars($filters = []) {
        $array = [];
        $where = $this->buildWhere($filters);
        $sql = $this->db->prepare("SELECT rating, COUNT(id) as c FROM products WHERE "
                . (implode(" AND ", $where)) . " GROUP BY rating");
        $this->bindWhere($filters, $sql);
        $sql->execute();
        if ($sql->rowCount() > 0) {
            $array = $sql->fetchAll(PDO::FETCH_ASSOC);
        }
        return $array;
    }

    public function getListOfBrands($filters = []) {
        $array = [];
        $where = $this->buildWhere($filters);
        $sql = $this->db->prepare("SELECT id_brand, COUNT(id) as c FROM products WHERE "
                . (implode(" AND ", $where)) . " GROUP BY id_brand");
        $this->bindWhere($filters, $sql);
        $sql->execute();
        if ($sql->rowCount() > 0) {
            $array = $sql->fetchAll(PDO::FETCH_ASSOC);
        }
        return $array;
    }

    public function getList($offset = 0, $limit = 3, $filters = [], $random = false) {
        $dados = [];
        $orderBy = ($random) ? "ORDER BY RAND()" : "";
        if (!empty($filters['toprated'])) {
            $orderBy = "ORDER BY rating DESC";
        }
        $where = $this->buildWhere($filters);
        $sql = $this->db->prepare("SELECT *,(SELECT brands.name FROM brands WHERE brands.id = products.id_brand) as brand_name,"
                . " (SELECT categories.name FROM categories WHERE categories.id = products.id_category) as category_name FROM products "
                . " WHERE " . (implode(" AND ", $where)) . " "
                . " " . $orderBy . " LIMIT :offset, :limit");
        $sql->bindValue(":offset", $offset, PDO::PARAM_INT);
        $sql->bindValue(":limit", $limit, PDO::PARAM_INT);
        $this->bindWhere($filters, $sql);
        $sql->execute();
        if ($sql->rowCount() > 0) {
            $dados = $sql->fetchAll(PDO::FETCH_ASSOC);

            foreach ($dados as $k => $v) {

                $dados[$k]['images'] = $this->getImagesByProductId($v['Id']);
            }
        }
        return $dados;
    }

    public function getTotal($filters = []) {
        $retorno = 0;
        $where = $this->buildWhere($filters);
        $sql = $this->db->prepare("SELECT COUNT(1) as c FROM products"
                . " WHERE " . implode(" AND ", $where));
        $this->bindWhere($filters, $sql);
        $sql->execute();
        if ($sql->rowCount() > 0) {
            $sql = $sql->fetch();
            $retorno = $sql['c'];
        }
        return $retorno;
    }

    public function getImagesByProductId($id) {
        $array = [];
        $sql = $this->db->prepare("SELECT url FROM products_images WHERE id_product = ?");
        $sql->execute([$id]);
        if ($sql->rowCount() > 0) {
            $array = $sql->fetchAll(PDO::FETCH_ASSOC);
        }
        return $array;
    }

    private function buildWhere($filters) {
        $where = [
            "1=1"
        ];
        if (!empty($filters['category'])) {
            $where[] = "id_category = :id_category";
        }
        if (!empty($filters['brand'])) {
            $where[] = "id_brand IN('" . implode("','", $filters['brand']) . "')";
        }
        if (!empty($filters['star'])) {
            $where[] = "rating IN('" . implode("','", $filters['star']) . "')";
        }
        if (!empty($filters['sale'])) {
            $where[] = "sale = 1";
        }
        if (!empty($filters['featured'])) {
            $where[] = "featured = 1";
        }
        if (!empty($filters['sale'])) {
            $where[] = "sale = 1";
        }
        if (!empty($filters['options'])) {
            $where[] = "id IN (select id_product FROM products_options WHERE products_options.p_value "
                    . "IN('" . implode("','", $filters['options']) . "'))";
        }

        if (!empty($filters['slider0'])) {
            $where[] = "price >= :slider0";
        }
        if (!empty($filters['slider1'])) {
            $where[] = "price <= :slider1";
        }
        if (!empty($filters['searchTerm'])) {
            $where[] = "name LIKE :searchTerm";
        }

        return $where;
    }

    private function bindWhere($filters, &$sql) {
        if (!empty($filters['category'])) {
            $sql->bindValue(":id_category", $filters['category']);
        }
        if (!empty($filters['slider0'])) {
            $sql->bindValue(":slider0", $filters['slider0']);
        }
        if (!empty($filters['slider1'])) {
            $sql->bindValue(":slider1", $filters['slider1']);
        }
        if (!empty($filters['searchTerm'])) {
            $sql->bindValue(":searchTerm", "%" . $filters['searchTerm'] . "%");
        }
    }

}
