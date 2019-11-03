<?php

class Filters extends Model {

    public function getFilters($filters) {
        $brands = new Brands();
        $products = new Products();
        $array = [
            "searchTerm" => "",
            "brands" => [],
            "slider0" => 0,
            "slider1" => 0,
            "maxSlider" => 1000,
            "stars" => [
                "0" => 0,
                "1" => 0,
                "2" => 0,
                "3" => 0,
                "4" => 0,
                "5" => 0
            ],
            "sale" => 0,
            "options" => []
        ];

        //Minha Forma = pegar quantidade de produtos por Marca via subquery no Model Brands
        $array["brands"] = $brands->getList();
        //Forma do professor - pegar quantidade de produtos por Marca via Query Products COUNT e GROUP BY
        //Criando filtro de Marcas
        $brandProducts = $products->getListOfBrands($filters);
        foreach ($array['brands'] as $k => $v) {
            $array['brands'][$k]['count'] = 0;
            foreach ($brandProducts as $bProduct) {
                if ($bProduct['id_brand'] == $v['Id']) {
                    $array['brands'][$k]['count'] = $bProduct['c'];
                }
            }
            if ($array['brands'][$k]['count'] == 0) {
                unset($array['brands'][$k]);
            }
        }

        //Criando filtro por busca
        if (!empty($filters['searchTerm'])) {
            $array['searchTerm'] = $filters['searchTerm'];
        }



        //Criando filtro de Preço
        //troquei isssetr
        if (!empty($filters['slider0'])) {
            $array['slider0'] = $filters['slider0'];
        }
        //troquei isset
        if (!empty($filters['slider1'])) {
            $array['slider1'] = $filters['slider1'];
        }
        $array['maxSlider'] = $products->getMaxPrice($filters);
        if ($array['slider1'] == 0) {
            $array['slider1'] = $array['maxSlider'];
        }



        //Criando filtro das Estrelas
        $starProduct = $products->getListOfStars($filters);
        foreach ($array['stars'] as $k => $star) {
            foreach ($starProduct as $st) {
                if ($st['rating'] == $k) {
                    $array['stars'][$k] = $st['c'];
                }
            }
        }

        //Criando filtro das promoções
        $array['sale'] = $products->getSaleCount($filters);

        //Criando filtro das Opções
        $array['options'] = $products->getAvailableOptions($filters);


        return $array;
    }

}
