<?php
class migrationconverterhelper {

    static function sizes($product){
        $productSizes = [];
        if(count($product["productSize"]) > 0) {
            foreach ($product["productSize"] as $ps) {
                if($ps["quantity"] > 0) {
                    $productSizes[$ps["name"]] = Array(
                        Array(
                            "name" => $ps["name"],
                            "color" => $ps["color"]
                        )
                    );
                }
            }
        }
        return $productSizes;
    }


    static function product($product){

        $sizes = "";
        $qty = 0;
        $isUnique = false;
        $productSizes = [];
        if(count($product["productSize"]) > 0) {
            foreach ($product["productSize"] as $ps) {
                if($ps["quantity"] > 0) {
                    //separar esto en un metodo de conversion aparte...
                    $productSize = Array(
                        "talla" => $ps["name"],
                        "color" =>  $ps["color"]
                    );

                    $productSize = (object) $productSize;
                    $productSizes[] = $productSize;

                    $qty += $ps["quantity"];
                    if ($ps["name"] == "UNICA") {
                        $isUnique = true;
                        $sizes = $product["sizeDescription"];
                        //AQUI AGREGAR LA DESCRIPCION DEL PRODUCTO EN LA TALLA
                    } else {
                        $sizes .= $ps["name"] . "-";
                    }
                }
            }
        }

        $images = 0;

        if(count($product["productImage"]) > 0){
            $images = count($product["productImage"]);
        }


        $priceDiscount = $product["price"];
        $discountPercent = 0;

        if($product["discount"] > 0) {
            $priceDiscount = $product["price"] - (($product["price"] * $product["discount"]) / 100);
            $discountPercent = $product["discount"];
        } else if($product["category"]["discountPercent"] > 0) {
            $priceDiscount = $product["price"] - (($product["price"] * $product["category"]["discountPercent"]) / 100);
            $discountPercent = $product["category"]["discountPercent"];
        }


        $added = Array(
            "codigo" => $product["reference"],
            "id_categoria" => $product["category"]["id"],
            "orden" => $product["orden"],
            "tipo" => $product["category"]["name"],
            "precio" => $product["price"],
            "tela" => $product["material"],
            "tallas" => $sizes,
            "imagenes" => $images,
            "existencia" => $qty > 0 ? 1 : 0,
            "talla_unica" => $isUnique ? 0 : 0,
            "observaciones" => "",
            "fecha" => $product["createdAt"],
            "descuento" => $discountPercent,
            "descuento_especial" => 0,
            "precio_descuento" => ceil($priceDiscount),
            "productSizes" => $productSizes
        );

        $added = (object) $added;

        return  $added;

    }


    //convertir producto (v2 a v1)
    static function products($products){

        $list = [];

        if(count($products) <= 0){
            return $list;
        }

        foreach($products as $product){
            $productAdded = self::product($product);
            $list[] = $productAdded;
        }

        return $list;

    }

}