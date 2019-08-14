<?php

namespace run\panel\core\lang;

class Lang {

    protected function lang()
    {
        define('LANG', $this->_const_lang());
        define('LT', require 'langs.php');
    }

    private function _const_lang()
    {
        return 'ru';
    }

}
