<?php

class categoriesController extends Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        header("Location: " . BASE_URL);
    }

    public function enter($cat) {
        $products = new Products();
        $categories = new Categories();
        $store = new Store();
        $dados = $store->getTemplateData();
        $f = new Filters();
        if (!empty($cat)) {
            $cat = addslashes($cat);

            $dados['categoryFilter'] = $categories->getCategoryTree($cat);
            if (!empty($dados['categoryFilter'])) {
                $dados['categoryName'] = $categories->getCategoryName($cat);
                $dados['categories'] = $categories->getList();
                //$dados['categories'] = $categories->getCategoryTree($cat);
                //Produtos e paginação
                $currentPage = 1;
                $offset = 0;
                $limit = 3;
                if (!empty($_GET['p'])) {
                    $currentPage = addslashes($_GET['p']);
                }

                $searchTerm = (!empty($_GET['s'])) ? addslashes($_GET['s']) : "";
                $category = (!empty($_GET['category'])) ? addslashes($_GET['category']) : "";
                $filters = ["category" => $cat];
                $offset = ($currentPage * $limit) - $limit;
                $dados['totalItens'] = $products->getTotal($filters);
                $dados['numberOfPages'] = ceil($dados['totalItens'] / 3);
                $dados['currentPage'] = $currentPage;
                $dados['idCategory'] = $cat;
                
                if (!empty($_GET['filter']) && is_array($_GET['filter'])) {
                    $filters = $_GET['filter'];
                }
                $dados['filters'] = $f->getFilters($filters);
                $dados['filterSelected'] = $filters;
                $dados['searchTerm'] = $searchTerm;
                $dados['category'] = $category;



                $dados['sideBar'] = true;
                $dados['list'] = $products->getList($offset, $limit, $filters);



                $this->loadTemplate("categories", $dados);
            } else {
                header("Location: " . BASE_URL);
            }
        }
    }

}
