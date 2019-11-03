<?php

class homeController extends controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $store = new Store();
        $products = new Products();
        $categories = new Categories();
        $f = new Filters();
        $dados = $store->getTemplateData();

        $filters = [];
        if (!empty($_GET['filter']) && is_array($_GET['filter'])) {
            $filters = $_GET['filter'];
        }

        $currentPage = 1;
        $offset = 0;
        $limit = 3;
        if (!empty($_GET['p'])) {
            $currentPage = addslashes($_GET['p']);
        }

        $offset = ($currentPage * $limit) - $limit;

        $dados['list'] = $products->getList($offset, $limit, $filters);
        $dados['totalItens'] = $products->getTotal($filters);
        $dados['numberOfPages'] = ceil($dados['totalItens'] / 3);
        $dados['currentPage'] = $currentPage;



        $dados['sideBar'] = true;
        $dados['filters'] = $f->getFilters($filters);
        $dados['filterSelected'] = $filters;

        $this->loadTemplate('home', $dados);
    }

}
