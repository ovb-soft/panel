<?php

namespace run\panel\core;

define('CORE', __DIR__ . D);

class Core extends Auth {

    protected $res;

    protected function core()
    {
        parent::auth();
        $this->_core_lang();
        define('HTML', require 'html' . D . 'pattern.php');
        define('LOGO', $this->_const_logo());
        define('ERROR', $this->_const_error());
    }

    protected function echo()
    {
        define('CONTENT', $this->res['content']);
        require 'html' . D . 'template.php';
    }

    private function _core_lang()
    {
        $langs = MODULE . str_replace('/', D, PATH['path']) . D . 'langs.php';
        if (file_exists($langs)) {
            $lang = (require $langs)[LANG];
            !isset($lang['path']) ?: define('LP', $lang['path']);
            !isset($lang['le']) ?: define('LE', $lang['le']);
        }
    }

    private function _const_logo()
    {
        return PATH['path'] === 'main' ? HTML['logo'] : HTML['a-logo'];
    }

    private function _const_error()
    {
        return (PATH['error'] or ! file_exists(
                        MODULE . str_replace('/', D, PATH['path']) . D . PATH['class'] . '.php'
        ));
    }

}
