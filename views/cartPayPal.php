<h1>Checkout PayPal</h1>
<?php echo (!empty($error)) ? "<div class='warn'>".$error."</div>" : "";?>
<form method="POST">
    <fieldset>
        <legend>Dados Pessoais</legend>

        <b>Nome:</b><br/>
        <input type="text" name="name" required value="Douglas Poma" /><br/><br/>
        <b>CPF:</b><br/>
        <input type="tel" name="cpf" required value="07713530908"/><br/><br/>
        <b>Telefone:</b><br/>
        <input type="tel" name="telefone" required value="47992662121"/><br/><br/>
        <b>E-mail:</b><br/>
        <input type="email" name="email" required value="teste@mp.com"/><br/><br/>
        <b>Senha:</b><br/>
        <input type="password" name="password" required value="123"/><br/><br/>
    </fieldset>
    <fieldset>
        <legend>Informações de endereço</legend>
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
    </fieldset>
    <button  type="submit" class="button efetuarCompra">Finalizar Compra</button>
</form>