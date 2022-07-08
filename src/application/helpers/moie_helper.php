<?php

if ( ! function_exists('base_catalog_url'))
{
    function base_catalog_url($uri = '')
    {
        return "http://ec2-3-85-198-54.compute-1.amazonaws.com:18210/uploads/" . $uri;
    }
}
