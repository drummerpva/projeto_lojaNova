$(function () {
    $(".efetuarCompra").on("click", function () {

        var id = PagSeguroDirectPayment.getSenderHash();

        var name = $("input[name=name]").val();
        var cpf = $("input[name=cpf]").val();
        var telefone = $("input[name=telefone]").val();
        var email = $("input[name=email]").val();
        var pass = $("input[name=password]").val();

        var cep = $("input[name=cep]").val();
        var rua = $("input[name=rua]").val();
        var numero = $("input[name=numero]").val();
        var complemento = $("input[name=complemento]").val();
        var bairro = $("input[name=bairro]").val();
        var cidade = $("input[name=cidade]").val();
        var estado = $("input[name=estado]").val();

        var cartaoTitular = $("input[name=cartaoTitular]").val();
        var cartaoCpf = $("input[name=cartaoCpf]").val();
        var cartaoNumero = $("input[name=cartaoNumero]").val();
        var cvv = $("input[name=cartaoCvv]").val();
        var vMes = $("select[name=cartaoMes]").val();
        var vAno = $("select[name=cartaoAno]").val();
        var qtParc = $("select[name=parc]").val();

        if (cartaoNumero != "" && cvv != "" && vMes != "" && vAno != "") {
            PagSeguroDirectPayment.createCardToken({
                cardNumber: cartaoNumero,
                brand: window.cardBrand,
                cvv: cvv,
                expirationMonth: vMes,
                expirationYear: vAno,
                success: function (r) {
                    window.cardToken = r.card.token;
                    //Finalizar o pagamento
                    $.ajax({
                        url: BASE_URL + "psCktTransparente/checkout",
                        type: 'POST',
                        dataType: 'json',
                        data: {
                            id: id,
                            name: name,
                            cpf: cpf,
                            telefone: telefone,
                            email: email,
                            pass: pass,
                            cep: cep,
                            rua: rua,
                            numero: numero,
                            complemento: complemento,
                            bairro: bairro,
                            cidade: cidade,
                            estado: estado,
                            cartaoTitular: cartaoTitular,
                            cartaoCpf: cartaoCpf,
                            cartaoNumero: cartaoNumero,
                            cvv: cvv,
                            vMes: vMes,
                            vAno: vAno,
                            cartaoToken: window.cardToken,
                            parc: qtParc
                        },
                        success: function (json) {
                            if (json.error == true) {
                                alert(json.msg);
                            } else {
                                window.location.href = BASE_URL+"psCktTransparente/obrigado"; 
                            }
                        },
                        error: function () {
                            console.log("Erro CHeckout Ajax");
                        }
                    });
                },
                error: function (r) {
                    console.log(r);
                },
                complete: function (r) {}
            });
        }
    });

    $("input[name=cartaoNumero]").on("keyup", function (e) {
        if ($(this).val().length == 6) {
            PagSeguroDirectPayment.getBrand({
                cardBin: $(this).val(),
                success: function (r) {
                    window.cardBrand = r.brand.name;
                    var cvvLimit = r.brand.cvvSize;
                    $("input[name=cartaoCvv]").attr("minlength", cvvLimit);
                    $("input[name=cartaoCvv]").attr("maxlength", cvvLimit);

                    PagSeguroDirectPayment.getInstallments({
                        amount: 100,
                        brand: window.carBrand,
                        maxInstallmentNoInterest: 10,
                        success: function (r) {
                            if (r.error == false) {
                                var parc = r.installments[window.cardBrand];
                                var html = "";
                                for (var i in parc) {
                                    var optionValue = parc[i].quantity + ";" + parc[i].installmentAmount + ";";
                                    if (parc[i].interestFree) {
                                        optionValue += "true";
                                    } else {
                                        optionValue += "false";
                                    }
                                    html += "<option value='" + optionValue + "'>" + parc[i].quantity + "x de R$ " + parc[i].installmentAmount + "</option>";
                                }
                                $("select[name=parc]").html(html);
                            }
                        },
                        error: function (r) {

                        },
                        complete: function (r) {}
                    });
                },
                error: function (r) {
                    console.log("erro");

                },
                complet: function (r) { }
            });

        }

    });

});