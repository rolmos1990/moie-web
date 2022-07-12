<?php

class callservicehelper {
    private $caller;

    const URL_PRODUCT = "http://ec2-3-85-198-54.compute-1.amazonaws.com:18210/product";
    const URL_CATEGORY = "http://ec2-3-85-198-54.compute-1.amazonaws.com:18210/category";

    function __constructor(){
    }

    function getToken(){
        return "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpZCI6NCwidXNlcm5hbWUiOiJ5Z29uemFsZXoiLCJpYXQiOjE2NTE0MzA4NTEsImV4cCI6MzMwMjg2NDE2MH0.2seSECKruL8eT9dw8-Qj-UCkjj3qzp8nwkpOG81AVIQ";
    }

    function callPost($url, $fields) {
        $fields_string = http_build_query($fields);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string );
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Authorization: ' . self::getToken(),
        ));
        $data = curl_exec($ch);
        curl_close($ch);
        return $data;
    }

    function callGet($url, $queryParams) {
        $fields_string = http_build_query($queryParams);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url . "?" . $fields_string);
        curl_setopt($ch, CURLOPT_POST, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Authorization: ' . self::getToken(),
        ));
        $data = curl_exec($ch);
        if (curl_errno($ch)) {
            $error_msg = curl_error($ch);
        }
        curl_close($ch);
        return $data;
    }

    function getProducts($limit, $page, $conditional = null){

        if(!$conditional) {
            $queryParams = array("limit" => $limit, "offset" => $page, "conditional" => "published::1");
        } else {
            $queryParams = array("limit" => $limit, "offset" => $page, "conditional" => $conditional);
        }

        $result = $this->callGet(self::URL_PRODUCT, $queryParams);
        $resultData = json_decode($result, true);
        return $resultData;
    }

    function getProduct($reference){

        $queryParams = array("limit" => 1, "conditional" => "reference::" . $reference);
        $result = $this->callGet(self::URL_PRODUCT, $queryParams);
        $resultData = json_decode($result, true);

        $product = $resultData["data"];

        return $product[0];
    }

    function getCategories($limit, $page, $conditional = null){
        if(!$conditional) {
            $queryParams = array("limit" => $limit, "offset" => $page, "conditional" => "status::1");
        } else {
            $queryParams = array("limit" => $limit, "offset" => $page, "conditional" => $conditional);
        }
        $result = $this->callGet(self::URL_CATEGORY, $queryParams);
        $resultData = json_decode($result, true);
        return $resultData;
    }

    function getCategory($category){

        $queryParams = array("limit" => 1, "conditional" => "id::" . $category);
        $result = $this->callGet(self::URL_CATEGORY, $queryParams);
        $resultData = json_decode($result, true);

        $product = $resultData["data"];

        return $product[0];
    }

}
