<?php

if ( ! function_exists('base_catalog_url'))
{
    function base_catalog_url($uri = '')
    {
        return "http://moie.lucymodas.com:18210/./uploads/" . $uri;
    }
}
