<h1>Checkout Transparente - Pagseguro</h1>


<h3>Dados Pessoais</h3>

<b>Nome:</b><br/>
<input type="text" name="name" required value="Douglas Poma" /><br/><br/>
<b>CPF:</b><br/>
<input type="tel" name="cpf" required value="07713530908"/><br/><br/>
<b>Telefone:</b><br/>
<input type="tel" name="telefone" required value="47992662121"/><br/><br/>
<b>E-mail:</b><br/>
<input type="email" name="email" required value="c82436053912049324975@sandbox.pagseguro.com.br"/><br/><br/>
<b>Senha:</b><br/>
<input type="password" name="password" required value="731483760u5748em"/><br/><br/>

<h3>Informações de endereço</h3>
<b>CEP:</b><br/>
<input type="tel" name="cep" required value="89370-000"/><br/><br/>
<b>Rua:</b><br/>
<input type="text" name="rua" required value="Rua Tnt Ary Rauen"/><br/><br/>
<b>Número:</b><br/>
<input type="tel" name="numero" required value="1114"/><br/><br/>
<b>Complemento:</b><br/>
<input type="text" name="complemento" required value="AP 5"/><br/><br/>
<b>Bairro:</b><br/>
<input type="text" name="bairro" required value="Hospital"/><br/><br/>
<b>Cidade:</b><br/>
<input type="text" name="cidade" required value="Papanduva" /><br/><br/>
<b>UF:</b><br/>
<input type="text" name="estado" required value="SC"/><br/><br/>

<h3>Informações de Pagamento</h3>
<b>Titular do Cartão:</b><br/>
<input type="text" name="cartaoTitular" required  value="Douglas Poma"/><br/><br/>
<b>CPF do Titular:</b><br/>
<input type="tel" name="cartaoCpf" required value="07713530908"/><br/><br/>
<b>Número do Cartão:</b><br/>
<input type="tel" name="cartaoNumero" required  maxlength="16"/><br/><br/>
<b>CVV:</b><br/>
<input type="tel" name="cartaoCvv" required value="123"/><br/><br/>
<b>Validade:</b><br/>
<select name="cartaoMes">
    <?php for ($q = 1; $q <= 12; $q++) {
        ?>
        <option <?php echo ($q == 12) ? "selected" : ""; ?> value="<?php echo ($q < 10) ? "0" . $q : $q; ?>"><?php echo ($q < 10) ? "0" . $q : $q; ?></option>
        <?php
    }
    ?>
</select>
<select name="cartaoAno">
    <?php for ($q = date("Y"); $q <= (date("Y") + 20); $q++) {
        ?>
        <option <?php echo ($q == 2030) ? "selected" : ""; ?> value="<?php echo $q; ?>"><?php echo $q; ?></option>
        <?php
    }
    ?>
</select><br/><br/>
<b>Parcelas: </b><br/>
<select name="parc"></select><br/><br/>
<button class="button efetuarCompra">Finalizar Compra</button>





<script type="text/javascript" src="https://stc.sandbox.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.directpayment.js"></script>
<script type="text/javascript" src="<?php echo BASE_URL . "assets/js/psCktTransparente.js" ?>"></script>

<script type="text/javascript">
    PagSeguroDirectPayment.setSessionId("<?php echo $sessionCode; ?>");
</script>
