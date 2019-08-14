<?php

namespace run\panel\core\login\initial;

class Data {

    public function __construct()
    {
        file_exists(DATA) ?: mkdir(DATA);
        $this->_app();
    }

    private function _app()
    {
        file_put_contents(DATA . 'app.sz', serialize([
            'ext' => '.ww'
        ]));
        $this->_header();
    }

    private function _header()
    {
        header('Location: /');
        exit;
    }

}
