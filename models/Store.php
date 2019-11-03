<?php

class Store extends Model {

    public function getTemplateData() {
        $dados = [];
        $categories = new Categories();
        $products = new Products();
        $cart = new Cart();
        


        $dados['categories'] = $categories->getList();
        $dados['widget_featured1'] = $products->getList(0, 5, ['featured' => '1'], true);
        $dados['widget_featured2'] = $products->getList(0, 3, ['featured' => '1'], true);
        $dados['widget_sale'] = $products->getList(0, 3, ['sale' => '1'], true);
        $dados['widget_topRated'] = $products->getList(0, 3, ['toprated' => '1']);
        if (!empty($_SESSION['cart'])) {
            $qt = 0;
            foreach ($_SESSION['cart'] as $qtd) {
                $qt += intval($qtd);
            }
            $dados['cartQt'] = $qt;
            //$dados['cartQt'] = count($_SESSION['cart']) ?? 0;
        } else {
            $dados['cartQt'] = 0;
        }
        $dados['cartSubtotal'] = $cart->getSubTotal();
        
        return $dados;
    }

}
