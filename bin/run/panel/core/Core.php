<?php

namespace run\panel\core;

class Core extends Auth {

    protected $res;

    protected function core()
    {
        parent::auth();
    }

    protected function echo()
    {
        define('CONTENT', $this->res['content']);
        require 'html' . D . 'template.php';
    }

}
