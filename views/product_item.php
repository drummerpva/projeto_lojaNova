<div class="product_item">
    <a href="<?php echo BASE_URL."product/open/".($Id ?? "");?>">
        <div class="product_tags">
            <?php if($sale){?>
            <div class="product_tag product_tag_red"><?php $this->lang->get("SALE");?></div>
            <?php } 
            if($bestseller){?>
            <div class="product_tag product_tag_green"><?php $this->lang->get("BESTSELLER");?></div>
            <?php } 
            if($new_product){?>
            <div class="product_tag product_tag_blue"><?php $this->lang->get("NEW");?></div>
            <?php } ?>
            
        </div>
        <div class="product_image">
            <img src="<?php echo BASE_URL . "media/products/".$images[0]['url']; ?>" width="100%" />
        </div>
        <div class="product_name">
            <?php echo $name;?>
        </div>
        <div class="product_brand"><?php echo $brand_name?></div>
        <div class="product_price_from">R$ <?php echo number_format($price_from,2,",",".");?></div>
        <div class="product_price">R$ <?php echo number_format($price,2,",",".");?></div>
        <div style="clear: both;"></div>
    </a>
</div>