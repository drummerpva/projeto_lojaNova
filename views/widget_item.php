<?php foreach ($list as $item){?>
<div class="widget_item">
    <a href="<?php echo BASE_URL."product/open/".($item['Id'] ?? "");?>">
        <div class="widget_info">
            <div class="widget_productName"><?php echo $item['name'] ?? "";?></div>
            <div class="widget_price"><span>R$ <?php echo number_format($item['price_from'],2,",",".") ?? "";?></span>  R$ <?php echo number_format($item['price'],2,",",".") ?? "";?></div>
        </div>
        <div class="widget_photo">
            <img src="<?php echo BASE_URL . "media/products/".$item['images'][0]['url']; ?>" />
        </div>
        <div style="clear:both"></div>
    </a>
</div>
<?php } ?>