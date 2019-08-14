<?php

namespace run\panel\core;

define('CORE', __DIR__ . D);

class Core extends Auth {

    protected $res;
    private $_lp;

    protected function core()
    {
        parent::auth();
        $this->_core_lang();
        define('HTML', require 'html' . D . 'pattern.php');
        define('HEAD', $this->_const_head());
        define('LOGO', $this->_const_logo());
        define('ERROR', $this->_const_error());
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
            !isset($lang['path']) ?: define('LP', $lang['path']);
            !isset($lang['le']) ?: define('LE', $lang['le']);
        }
    }

    private function _const_head()
    {
        return file_exists(DOC . 'panel' . D . 'default' . D . PATH['exp'][0] . '.css') ?
                HTML['css'] : '';
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

    private function _const_title()
    {
        $this->_lp = defined('LP');
        $title = '';
        if (ERROR) {
            $title = ' | ' . LT['404']['title'];
        } elseif ($this->_lp) {
            foreach (PATH['exp'] as $v) {
                $title .= ' » ' . LP[$v];
            }
            !isset($this->res['title']) ?: $title .= ' » ' . $this->res['title'];
        }
        return $title;
    }

    private function _const_route()
    {
        $route = '';
        if ($this->_lp) {
            for ($i = 0, $c = count(PATH['exp']), $routes = '', $path = ''; $i < $c; $i++) {
                if ($i === $c - 1) {
                    $routes .= str_replace('{ T }', LP[PATH['exp'][$i]], HTML['route']['p']);
                    break;
                }
                $search = ['{ H }', '{ A }'];
                $path .= '/' . PATH['exp'][$i];
                $replace = [$path, LP[PATH['exp'][$i]]];
                $routes .= str_replace($search, $replace, HTML['route']['a']);
            }
            if (isset($this->res['route'])) {
                $routes .= isset($this->res['route']['red']) ?
                        str_replace('{ T }', $this->res['route']['red'], HTML['route']['p-red']) :
                        str_replace('{ T }', $this->res['route'], HTML['route']['p']);
            }
            $route = str_replace('{ R }', $routes, HTML['route']['div']);
        }
        return $route;
    }

}
