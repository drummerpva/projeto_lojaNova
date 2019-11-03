<div class="row">
    <div class="col-sm-5">
        <div class="mainPhoto">
            <img src="<?php echo BASE_URL . "media/products/" . $productImages[0]['url']; ?>" />
        </div>
        <div class="gallery">
            <?php foreach ($productImages as $img) {
                ?>
                <div class="photoItem">
                    <img src="<?php echo BASE_URL . "media/products/" . $img['url']; ?>" />
                </div>
                <?php
            }
            ?>
        </div>
    </div>
    <div class="col-sm-7">
        <h2><?php echo $productInfo['name']; ?></h2>
        <small><?php echo $productInfo['brand']; ?></small><br/>
        <?php
        if ($productInfo['rating'] != "0") {
            for ($q = 1; $q <= $productInfo['rating']; $q++) {
                ?>
                <img src="<?php echo BASE_URL . "assets/images/star.png" ?>" width="15"/>
                <?php
            }
        }
        ?>
        <hr/>
        <p><?php echo $productInfo['description']; ?></p>
        <hr/>
        De: <span class="priceFrom">R$ <?php echo number_format($productInfo['price_from'], 2, ",", "."); ?></span><br/>
        por <span class="originalPrice">R$ <?php echo number_format($productInfo['price'], 2, ",", "."); ?></span>
        <form method="POST" class="formAddCart" action="<?php echo BASE_URL."cart/add";?>" >
            <input type="hidden" name="idProduct" value="<?php echo $productInfo['Id'];?>" />
            <input type="hidden" name="qtProduct" value="1" />
            <button onclick="">-</button><input type="text" name="qt" required value="1" class="addToCartQT" disabled/><button>+</button>
            <input type="submit" class="addToCartSub"  value="<?php $this->lang->get("ADDTOCART"); ?>" />
        </form>

    </div>
</div>
<div class="row">
    <div class="col-sm-6">
        <h3><?php $this->lang->get("ESPECIFICATIONS"); ?></h3>
        <?php foreach ($productOptions as $op) {
            ?>
            <b><?php echo $op['name']; ?></b>: <?php echo $op['value']; ?><br/>

        <?php }
        ?>  
    </div>
    <div class="col-sm-6">
        <h3><?php $this->lang->get("REVIEWS"); ?></h3>
        <?php
        foreach ($productRates as $rate) {
            ?>
            <b><?php echo $rate['name_user']; ?></b> -  
            <?php for ($q = 0; $q < $rate['points']; $q++) {
                ?>
                <img src="<?php echo BASE_URL . "assets/images/star.png" ?>" width="13"/>
                <?php
            }
            ?>
            <br/>
            "<?php echo $rate['comment']; ?>"
            <hr/>

            <?php
        }
        ?>
    </div>
</div>