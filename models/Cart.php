<?php

class Cart extends Model {

    public function getList() {
        $array = [];
        $cart = $_SESSION['cart'] ?? [];
        $products = new Products();
        foreach ($cart as $id => $qt) {
            $info = $products->getInfo($id);

            $array[] = [
                "id" => $id,
                "qt" => $qt,
                "price" => $info['price'],
                "name" => $info['name'],
                "image" => $info['image']['url'],
                "weight" => $info['weight'],
                "width" => $info['width'],
                "height" => $info['height'],
                "length" => $info['length'],
                "diameter" => $info['diameter']
            ];
        }
        return $array;
    }

    public function getSubTotal() {
        $list = $this->getList();
        $subTotal = 0;

        foreach ($list as $l) {
            $subTotal += ($l['qt'] * $l['price']);
        }
        return $subTotal;
    }

    public function shippingCalculate($cepDest) {
        $array = [
            "price" => 0,
            "date" => ""
        ];
        global $config;

        $nVlPeso = 0;
        $nVlComprimento = 0;
        $nVlAltura = 0;
        $nVlLargura = 0;
        $nVlDiametro = 0;
        $nVlDeclarado = 0;

        $list = $this->getList();
        foreach ($list as $item) {
            $nVlPeso += ($item['weight'] * $item['qt']);
            $nVlComprimento += ($item['length'] * $item['qt']);
            $nVlAltura += ($item['height'] * $item['qt']);
            $nVlLargura += ($item['width'] * $item['qt']);
            $nVlDiametro += ($item['diameter'] * $item['qt']);
            $nVlDeclarado += ($item['price'] * $item['qt']);
        }

        $soma = $nVlComprimento + $nVlAltura + $nVlLargura;
        if ($soma > 200) {
            $nVlComprimento = 66;
            $nVlAltura = 66;
            $nVlLargura = 66;
        }
        if($nVlDiametro > 90){
            $nVlDiametro = 90;
        }
        if($nVlPeso > 40){
            $nVlPeso = 40;
        }
        $data = [
            "nCdServico" => "40010", //40010 Sedex - 41106 PAC
            "sCepOrigem" => $config['cepOrigin'],
            "sCepDestino" => $cepDest,
            "nVlPeso" => $nVlPeso,
            "nCdFormato" => "1", //1 Caixa - 3 Envelope
            "nVlComprimento" => $nVlComprimento,
            "nVlAltura" => $nVlAltura,
            "nVlLargura" => $nVlLargura,
            "nVlDiametro" => $nVlDiametro,
            "nCdMaoPropria" => "N",
            "nVlValorDeclarado" => $nVlDeclarado,
            "sCdAvisoRecebimento" => "N",
            "StrRetorno" => "xml"
        ];
        $url = "http://ws.correios.com.br/calculador/CalcPrecoPrazo.aspx";
        //$url = "http://ws.correios.com.br/calculador/CalcPrecoPrazo.asmx?op=CalcPrecoPrazo";
        $data = http_build_query($data);
        $ch = curl_init($url . "?" . $data);
        //$ch = curl_init($url . "&" . $data);
        //echo($url . "?" . $data);exit;
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $r = curl_exec($ch);
        $r = simplexml_load_string($r);
        $array['price'] = current($r->cServico->Valor);
        $array['date'] = current($r->cServico->PrazoEntrega);


        return $array;
    }

}
