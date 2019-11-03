<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Loja 2.0</title>
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <link href="//fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/bootstrap.min.css" type="text/css" />
        <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/jquery-ui.min.css" type="text/css" />
        <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/jquery-ui.structure.min.css" type="text/css" />
        <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/jquery-ui.theme.min.css" type="text/css" />
        <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/style.css" type="text/css" />
        <script type="text/javascript" src="<?php echo BASE_URL; ?>assets/js/jquery.min.js"></script>
    </head>
    <body>
        <nav class="navbar topnav">
            <div class="container">
                <ul class="nav navbar-nav">
                    <li class="active"><a href="<?php echo BASE_URL; ?>"><?php $this->lang->get('HOME'); ?></a></li>
                    <li><a href="<?php echo BASE_URL; ?>contact"><?php $this->lang->get('CONTACT'); ?></a></li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#"><?php $this->lang->get('LANGUAGE'); ?>
                            <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="<?php echo BASE_URL . "lang/set/en"; ?>">English</a></li>
                            <li><a href="<?php echo BASE_URL . "lang/set/pt-br"; ?>">Português</a></li>
                        </ul>
                    </li>
                    <li><a href="<?php echo BASE_URL; ?>login"><?php $this->lang->get('LOGIN'); ?></a></li>
                </ul>
            </div>
        </nav>
        <header>
            <div class="container">
                <div class="row">
                    <div class="col-sm-2 logo">
                        <a href="<?php echo BASE_URL; ?>"><img src="<?php echo BASE_URL; ?>assets/images/logo.png" /></a>
                    </div>
                    <div class="col-sm-7">
                        <div class="head_help">(11) 9999-9999</div>
                        <div class="head_email">contato@<span>loja2.com.br</span></div>

                        <div class="search_area">
                            <form method="GET" action="<?php echo BASE_URL . "busca"; ?>">
                                <input type="text" name="s" required placeholder="<?php $this->lang->get('SEARCHFORANITEM'); ?>" value="<?php echo $viewData['searchTerm'] ?? ""; ?>"/>
                                <select name="category">
                                    <option value=""><?php $this->lang->get('ALLCATEGORIES'); ?></option>
                                    <?php foreach ($viewData['categories'] as $cat) {
                                        ?>
                                        <option <?php echo ($viewData['category'] == $cat['Id']) ? "selected" : ""; ?> value="<?php echo $cat['Id'] ?>"><?php echo $cat['name']; ?></option>
                                        <?php
                                        if (count($cat['subs'])) {
                                            $this->loadView("menuSubcategorySelect", [
                                                "subs" => $cat['subs'],
                                                "level" => 1,
                                                "category" => $viewData['category']
                                            ]);
                                        }
                                    }
                                    ?>
                                    </ul>
                                    </li>
                                    <?php
                                    if (!empty($viewData['categoryFilter'])) {
                                        foreach ($viewData['categoryFilter'] as $cf) {
                                            ?>
                                            <li><a href="<?php echo BASE_URL . "categories/enter/" . $cf['Id']; ?>"><?php echo $cf['name']; ?></a></li>
                                            <?php
                                        }
                                    }
                                    ?>
                                </select>
                                <input type="submit" value="" />
                            </form>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <a href="<?php echo BASE_URL; ?>cart">
                            <div class="cartarea">
                                <div class="carticon">
                                    <div class="cartqt"><?php echo $viewData['cartQt']; ?></div>
                                </div>
                                <div class="carttotal">
                                    <?php $this->lang->get('CART'); ?>:<br/>
                                    <span>R$ <?php echo number_format($viewData['cartSubtotal'], 2, ",", "."); ?></span>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </header>
        <div class="categoryarea">
            <nav class="navbar">
                <div class="container">
                    <ul class="nav navbar-nav">
                        <li class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#"><?php $this->lang->get('SELECTCATEGORY'); ?>
                                <span class="caret"></span></a>
                            <ul class="dropdown-menu slide">
                                <?php foreach ($viewData['categories'] as $cat) {
                                    ?>
                                    <li>
                                        <a href="<?php echo BASE_URL . "categories/enter/" . $cat['Id']; ?>">
                                            <?php echo $cat['name']; ?>
                                        </a>
                                    </li>
                                    <?php
                                    if (count($cat['subs'])) {
                                        $this->loadView("menuSubcategory", [
                                            "subs" => $cat['subs'],
                                            "level" => 1
                                        ]);
                                    }
                                }
                                ?>
                            </ul>
                        </li>
                        <?php
                        if (!empty($viewData['categoryFilter'])) {
                            foreach ($viewData['categoryFilter'] as $cf) {
                                ?>
                                <li><a href="<?php echo BASE_URL . "categories/enter/" . $cf['Id']; ?>"><?php echo $cf['name']; ?></a></li>
                                <?php
                            }
                        }
                        ?>
                    </ul>
                </div>
            </nav>
        </div>
        <section>
            <div class="container">
                <div class="row">
                    <?php if (!empty($viewData['sideBar'])) { ?>
                        <div class="col-sm-3">
                            <?php $this->loadView('sidebar', ["viewData" => $viewData]); ?>
                        </div>
                        <div class="col-sm-9"><?php $this->loadViewInTemplate($viewName, $viewData); ?></div>
                    <?php } else {
                        ?>
                        <div class="col-sm-12"><?php $this->loadViewInTemplate($viewName, $viewData); ?></div>
                        <?php
                    }
                    ?>
                </div>
            </div>
        </section>
        <footer>
            <div class="container">
                <div class="row">
                    <div class="col-sm-4">
                        <div class="widget">
                            <h1><?php $this->lang->get('FEATUREDPRODUCTS'); ?></h1>
                            <div class="widget_body">
                                <?php $this->loadView('widget_item', ["list" => $viewData['widget_featured2']]); ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="widget">
                            <h1><?php $this->lang->get('ONSALEPRODUCTS'); ?></h1>
                            <div class="widget_body">
                                <?php $this->loadView('widget_item', ["list" => $viewData['widget_sale']]); ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="widget">
                            <h1><?php $this->lang->get('TOPRATEDPRODUCTS'); ?></h1>
                            <div class="widget_body">
                                <?php $this->loadView('widget_item', ["list" => $viewData['widget_topRated']]); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="subarea">
                <div class="container">
                    <div class="row">
                        <div class="col-xs-12 col-sm-8 col-sm-offset-2 no-padding">
                            <form action="https://registrallogistica.us19.list-manage.com/subscribe/post?u=ca863f3b4408afdd6bd73b4fd&amp;id=c3dabb65c4" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate>
                                <input type="email" value="" name="EMAIL" class="subemail required email" id="mce-EMAIL" placeholder="<?php $this->lang->get('SUBSCRIBETEXT'); ?>">
                                <input type="hidden" name="b_ca863f3b4408afdd6bd73b4fd_c3dabb65c4" tabindex="-1" value="">
                                <input type="submit" value="<?php $this->lang->get('SUBSCRIBEBUTTON'); ?>" name="subscribe" id="mc-embedded-subscribe" class="button">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="links">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-4">
                            <a href="<?php echo BASE_URL; ?>"><img width="150" src="<?php echo BASE_URL; ?>assets/images/logo.png" /></a><br/><br/>
                            <strong>Slogan da Loja Virtual</strong><br/><br/>
                            Endereço da Loja Virtual
                        </div>
                        <div class="col-sm-8 linkgroups">
                            <div class="row">
                                <div class="col-sm-4">
                                    <h3><?php $this->lang->get('CATEGORIES'); ?></h3>
                                    <ul>
                                        <li><a href="#">Categoria X</a></li>
                                        <li><a href="#">Categoria X</a></li>
                                        <li><a href="#">Categoria X</a></li>
                                        <li><a href="#">Categoria X</a></li>
                                        <li><a href="#">Categoria X</a></li>
                                        <li><a href="#">Categoria X</a></li>
                                    </ul>
                                </div>
                                <div class="col-sm-4">
                                    <h3><?php $this->lang->get('INFORMATION'); ?></h3>
                                    <ul>
                                        <li><a href="#">Menu 1</a></li>
                                        <li><a href="#">Menu 2</a></li>
                                        <li><a href="#">Menu 3</a></li>
                                        <li><a href="#">Menu 4</a></li>
                                        <li><a href="#">Menu 5</a></li>
                                        <li><a href="#">Menu 6</a></li>
                                    </ul>
                                </div>
                                <div class="col-sm-4">
                                    <h3><?php $this->lang->get('INFORMATION'); ?></h3>
                                    <ul>
                                        <li><a href="#">Menu 1</a></li>
                                        <li><a href="#">Menu 2</a></li>
                                        <li><a href="#">Menu 3</a></li>
                                        <li><a href="#">Menu 4</a></li>
                                        <li><a href="#">Menu 5</a></li>
                                        <li><a href="#">Menu 6</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="copyright">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-6">© <span>Loja 2.0</span> - <?php $this->lang->get('ALLRIGHTRESERVED'); ?>.</div>
                        <div class="col-sm-6">
                            <div class="payments">
                                <img src="<?php echo BASE_URL; ?>assets/images/visa.png" />
                                <img src="<?php echo BASE_URL; ?>assets/images/visa.png" />
                                <img src="<?php echo BASE_URL; ?>assets/images/visa.png" />
                                <img src="<?php echo BASE_URL; ?>assets/images/visa.png" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
        <script type="text/javascript">
            var BASE_URL = '<?php echo BASE_URL; ?>';
            var maxSlider = <?php echo $viewData['filters']["maxSlider"] ?? " 0;"; ?>
        </script>
        <script type="text/javascript" src="<?php echo BASE_URL; ?>assets/js/jquery-ui.min.js"></script>
        <script type="text/javascript" src="<?php echo BASE_URL; ?>assets/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="<?php echo BASE_URL; ?>assets/js/script.js"></script>
    </body>
</html>