<?php

namespace run\panel\core;

define('CORE', __DIR__ . D);
define('HTML', require 'html' . D . 'pattern.php');

class Core extends Auth {

    use traits\Core;

    protected $res;
    private $_path;

    protected function core()
    {
        parent::auth();
        $this->_core_lang();
        define('HEAD', $this->const_head());
        define('LOGO', $this->const_logo());
        define('ERROR', $this->const_error());
    }

    protected function echo()
    {
        define('TITLE', $this->_const_title());
        define('ROUTE', $this->_const_route());
        define('CONTENT', $this->res['content']);
        require 'html' . D . 'template.php';
    }

    private function _core_lang()
    {
        $langs = MODULE . str_replace('/', D, PATH['path']) . D . 'langs.php';
        if (file_exists($langs)) {
            $lang = (require $langs)[LANG];
            !isset($lang['path']) ?: $this->_path = $lang['path'];
            !isset($lang['le']) ?: define('LE', $lang['le']);
            !isset($lang['menu']) ?: define('MENU', $this->const_menu($lang['menu']));
        }
    }

    private function _const_title()
    {
        $title = '';
        if (ERROR) {
            $title = ' | ' . LT['404']['title'];
        } elseif ($this->_path) {
            foreach (PATH['exp'] as $v) {
                $title .= ' » ' . $this->_path[$v];
            }
            !isset($this->res['title']) ?: $title .= ' » ' . $this->res['title'];
        }
        return $title;
    }

    private function _const_route()
    {
        $route = '';
        if ($this->_path) {
            for ($i = 0, $c = count(PATH['exp']), $routes = '', $path = ''; $i < $c; $i++) {
                if ($i === $c - 1) {
                    $routes .= str_replace(
                            '{ T }', $this->_path[PATH['exp'][$i]], HTML['route']['p']
                    );
                    break;
                }
                $search = ['{ H }', '{ A }'];
                $path .= '/' . PATH['exp'][$i];
                $replace = [$path, $this->_path[PATH['exp'][$i]]];
                $routes .= str_replace($search, $replace, HTML['route']['a']);
            }
            $route = $this->_const_routes($routes);
        }
        return $route;
    }

    private function _const_routes($routes)
    {
        if (isset($this->res['route'])) {
            $routes .= isset($this->res['route']['red']) ?
                    str_replace('{ T }', $this->res['route']['red'], HTML['route']['p-red']) :
                    str_replace('{ T }', $this->res['route'], HTML['route']['p']);
        }
        return str_replace('{ R }', $routes, HTML['route']['div']);
    }

}
