<?php

namespace run\panel\core;

define('HTML', require 'html' . D . 'pattern.php');

new Auth;
new lang\Lang;

class Core {

    use traits\Core;

    protected $res;

    public function __construct()
    {
        $this->_core_lang();
        define('HEAD', $this->const_head());
        define('LOGO', $this->const_logo());
        define('ERROR', $this->const_error());
    }

    protected function echo()
    {
        define('TITLE', $this->const_title(
                        isset($this->res['title']) ? $this->res['title'] : false
        ));
        define('ROUTE', $this->const_route(
                        isset($this->res['route']) ? $this->res['route'] : false
        ));
        define('CONTENT', $this->res['content']);
        require 'html' . D . 'template.php';
    }

    private function _core_lang()
    {
        $langs = MODULE . str_replace('/', D, PATH['path']) . D . 'langs.php';
        if (file_exists($langs)) {
            $lang = (require $langs)[LANG];
            !isset($lang['path']) ?: $this->path = $lang['path'];
            !isset($lang['le']) ?: $this->_core_le($lang['le']);
            !isset($lang['menu']) ?: $this->_core_menu($lang['menu']);
        }
    }

    private function _core_le($le)
    {
        define('LE', $le);
    }

    private function _core_menu($menu)
    {
        define('MENU', $this->const_menu($menu));
    }

}
