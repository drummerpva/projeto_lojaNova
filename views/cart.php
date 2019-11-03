<h1>Carrinho de compras</h1>
<table width="100%">
    <tr>
        <th width="100">Imagem</th>
        <th>Nome</th>
        <th align="center" width="80">Qtd.</th>
        <th width="<?php echo (empty($_SESSION['shipping'])) ? "240" : "150"; ?>" align="center">Preço</th>
        <th width="80"></th>
    </tr>
    <?php
    $subTotal = 0;
    foreach ($list as $l) {
        $subTotal += ($l['qt'] * $l['price']);
        ?>
        <tr>
            <td><img src="<?php echo BASE_URL . "media/products/" . $l['image']; ?>"  width="80"/></td>
            <td><?php echo $l['name']; ?></td>
            <td align="center"><?php echo $l['qt']; ?></td>
            <td align="right"><?php echo "R$ " . number_format($l['price'], 2, ",", "."); ?></td>
            <td align="center"><a href="<?php echo BASE_URL . "cart/del/" . $l['id']; ?>"><img src="<?php echo BASE_URL . "assets/images/delete.png" ?>" width="15" /></a></td>
        </tr>
        <?php
    }
    ?>
    <tr>
        <td colspan="3" align="right">Sub-Total</td>
        <td align="right"><?php echo "<b>R$ " . number_format($subTotal, 2, ",", ".") . "</b>"; ?></td>
    </tr>
    <tr>
        <td colspan="3" align="right">Frete</td>
        <?php if (empty($shipping)) {
            ?>
            <td align="right">
                <form method="POST">
                    <input type="tel" name="cep" placeholder="Qual seu CEP?" required/><input type="submit" value="Calcular"/>
                </form>
            </td>
        <?php } else { ?>
            <td align="right"><?php echo "<b>R$ " . ((!empty($shipping)) ? $shipping['price'] : "0,00" ); ?> - (<?php echo $shipping['date'] . " dia" . (($shipping['date'] != '1') ? "s" : ""); ?>)</b></td>
        <?php } ?>
    </tr>
    <tr>
        <td colspan="3" align="right">Total</td>
        <td align="right"><b><?php echo "R$ " . ((!empty($shipping)) ? number_format($subTotal + str_replace(",", ".", $shipping['price']), 2, ",", ".") : number_format($subTotal, 2, ",", ".")); ?></b></td>
    </tr>
</table>
<hr/>
<?php if (!empty($shipping)) {
    ?>
<form method="POST" style="float:right;" action="<?php echo BASE_URL."cart/paymentRedirect";?>">
    <select name="paymentType" required>
        <option></option>
        <option value="checkoutTransparente">PagSeguro Checkout Trabsparente</option>
        <option value="mp">Mercado Pago</option>
        <option value="paypal">PayPal</option>
        <option value="boleto">Boleto Bancário</option>
    </select>
    <input type="submit" value="Finalizar Compra" class="button"/>
</form>
    <?php
}
?>