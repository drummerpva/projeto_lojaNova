<div class="row">
    <?php
    $a = 0;
    foreach ($list as $productItem) {
        ?>
        <div class="col-sm-4">
            <?php $this->loadView('product_item', $productItem); ?>
        </div>
        <?php
        if ($a >= 2) {
            $a = 0;
            echo "</div><div class='row'>";
        } else {
            $a++;
        }
    }
    ?>
</div>
<div class="paginationArea">
    <?php for ($q = 1; $q <= $numberOfPages; $q++) {
        ?>
        <div class="paginationItem <?php echo ($currentPage == $q) ? "pag_active" : ""; ?> ">
            <a href="<?php echo BASE_URL . "?";
            $pagArray = $_GET;
            $pagArray['p'] = $q;
            echo http_build_query($pagArray);        
            ?>">
                <?php echo $q; ?>
            </a>
        </div>
        <?php
    }
    ?>
</div>