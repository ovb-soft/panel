<?php

namespace run\open;

class Open {

    public function __construct()
    {
        define('LANG', 'ru');
        define('LT', require 'langs.php');
        require 'template.php';
    }

}
