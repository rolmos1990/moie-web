<?php

if ( ! function_exists('base_catalog_url'))
{
    function base_catalog_url($uri = '')
    {
        return "https://moie2.lucymodas.com/./uploads/" . $uri;
    }
}

if ( ! function_exists('base_product_catalog_url'))
{
    function base_product_catalog_url($uri = '')
    {
        return "http://localhost:18210/" . $uri;
    }
}
