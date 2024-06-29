<?php

include_once './vendor/autoload.php';

use Hewgo\Hump;

function hump($name, $input = null)
{
    Hump::dump($name, $input);
}
