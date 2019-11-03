<?php

class buscaController extends controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $store = new Store();
        $dados = $store->getTemplateData();
        $products = new Products();
        $categories = new Categories();
        $f = new Filters();
        if (!empty($_GET['s'])) {
            $searchTerm = addslashes($_GET['s']);
            $category = addslashes($_GET['category']);

            $filters = [];
            if (!empty($_GET['filter']) && is_array($_GET['filter'])) {
                $filters = $_GET['filter'];
            }
            $filters['searchTerm'] = $searchTerm;
            $filters['category'] = $category;
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
            $dados['categories'] = $categories->getList();
            
            $dados['filters'] = $f->getFilters($filters);
            $dados['filterSelected'] = $filters;
            $dados['searchTerm'] = $searchTerm;
            $dados['category'] = $category;

            $dados['sideBar'] = true;

            $this->loadTemplate('busca', $dados);
        } else {
            header("Location:" . BASE_URL);
        }
    }

}
