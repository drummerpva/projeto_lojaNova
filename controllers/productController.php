<?php

class productController extends controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        header("Location:" . BASE_URL);
    }

    public function open($id) {
        $products = new Products();
        $categories = new Categories();
        $store = new Store();
        $dados = $store->getTemplateData();

        $info = $products->getProductInfo($id);
        if (count($info) > 0) {
            $dados['productInfo'] = $info;
            $dados['productImages'] = $products->getImagesByProductId($id);
            $dados['productOptions'] = $products->getOptionsByProductId($id);
            $dados['productRates'] = $products->getRates($id, 5);
            
            $dados['categories'] = $categories->getList();


            $this->loadTemplate('product', $dados);
        } else {
            header("Location: ".BASE_URL);
        }
    }

}
