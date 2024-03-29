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

    static function checkIsJson($string) {
        return is_string($string) &&
            (is_object(json_decode($string)) ||
                is_array(json_decode($string)));
    }


    static function product($product){

        $sizes = "";
        //$qty = 0;
        $isUnique = false;
        $productSizes = [];
        $lastItem = count($product["productSize"]);
        $counter = 0;
        if(count($product["productSize"]) > 0) {
            foreach ($product["productSize"] as $key => $ps) {
                $counter++;
                if($ps["quantity"] > 0) {
                    //separar esto en un metodo de conversion aparte...
                    $productSize = Array(
                        "talla" => $ps["name"],
                        "color" =>  $ps["color"]
                    );

                    $productSize = (object) $productSize;
                    $productSizes[] = $productSize;

                    //$qty += $ps["quantity"];

                    if ($ps["name"] == "UNICA") {
                        $isUnique = true;
                        $sizes = $product["sizeDescription"];
                        //AQUI AGREGAR LA DESCRIPCION DEL PRODUCTO EN LA TALLA
                    } else {
                        $sizes .= $ps["name"];

                        if ($counter < $lastItem) {
                            $sizes.= ',';
                        }
                    }
                }
            }
        }

        $images = 0;

        if(count($product["productImage"]) > 0){
            $images = count($product["productImage"]);
        }

        //create order for products (with service)
        $imagesObj = [];
        if(count($product["productImage"]) > 0){
            usort($product['productImage'], function($a, $b) {return strcmp($a['group'], $b['group']);});
            $index = 0;
            foreach ($product['productImage'] as $pi) {
                $index++;
                $parsed = $pi['thumbs'];

                if(migrationconverterhelper::checkIsJson($parsed)){
                    $parsed = json_decode($parsed, true);
                }

                $imagesObj[$pi['group']] = array(
                    'small' => array_key_exists('small', $parsed) ? $parsed['small'] : "",
                    'medium' => array_key_exists('medium', $parsed) ? $parsed['medium'] : "",
                    'high' => array_key_exists('high', $parsed) ? $parsed['high'] : "",
                    'original' => $pi['path'],
                    'index' => $index);
            }
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

            $added = array(
                "id" => $product["id"],
                "codigo" => $product["reference"],
                "id_categoria" => $product["category"]["id"],
                "orden" => $product["orden"],
                "tipo" => $product["description"],
                "precio" => $product["price"],
                "tela" => $product["material"],
                "tallas" => $sizes,
                "imagenes" => $images,
                "existencia" => $product['productAvailable']['available'] ? 1 : 0,
                "talla_unica" => $isUnique ? 0 : 0,
                "observaciones" => "",
                "fecha" => $product["createdAt"],
                "descuento" => $discountPercent,
                "precio_descuento" => ceil($priceDiscount),
                "productSizes" => $productSizes,
                "productImages" => $imagesObj
            );

        $added = (object) $added;

        return  $added;

    }

    static function category($category){
        $added = Array(
            "id" => $category["id"],
            "nombre" => $category["name"],
            "descuento" => $category["discountPercent"],
            "orden" => 0,
            "actualizacion" => $category["updatedAt"],
            "filename" => $category["filename"],
            "filenameBanner" => $category["filenameBanner"]
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
            if($productAdded->existencia > 0){
                $list[] = $productAdded;
            }
        }

        return $list;

    }

    //convertir producto (v2 a v1)
    static function categories($categories){

        $list = [];

        if(count($categories) <= 0){
            return $list;
        }
        foreach($categories as $category){
            $productAdded = self::category($category);
            $list[] = $productAdded;
        }

        return $list;

    }

}
