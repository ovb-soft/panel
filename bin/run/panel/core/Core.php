<?php

namespace run\panel\core;

define('CORE', __DIR__ . D);

class Core extends Auth {

    protected $res;

    protected function core()
    {
        parent::auth();
        define('HTML', require 'html' . D . 'pattern.php');
    }

    protected function echo()
    {
        define('CONTENT', $this->res['content']);
        require 'html' . D . 'template.php';
    }

}
