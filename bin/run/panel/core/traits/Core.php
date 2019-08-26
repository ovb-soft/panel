<?php

namespace run\panel\core\traits;

trait Core {

    protected $path;

    private function const_menu($menu)
    {
        $blank = [];
        if (isset($menu['blank'])) {
            $blank = $menu['blank'];
            unset($menu['blank']);
        }
        asort($menu);
        reset($menu);
        $li = '';
        foreach ($menu as $k => $v) {
            $html = in_array($k, $blank) ? 'li-blank' : 'li';
            $li .= str_replace(['[H]', '[A]'], [$k, $v], HTML['menu'][$html]);
        }
        return str_replace('[L]', $li, HTML['menu']['ul']);
    }

    private function const_head()
    {
        return file_exists(DOC . 'panel' . D . 'default' . D . PATH['exp'][0] . '.css') ?
                HTML['css'] : '';
    }

    private function const_logo()
    {
        return PATH['path'] === 'main' ? HTML['logo'] : HTML['a-logo'];
    }

    private function const_error()
    {
        return (PATH['error'] or ! file_exists(
                        MODULES . str_replace('/', D, PATH['path']) . D . PATH['class'] . '.php'
        ));
    }

    private function const_title()
    {
        $title = '';
        if (ERROR) {
            $title = ' | ' . LT['404']['title'];
        } elseif ($this->path) {
            foreach (PATH['exp'] as $v) {
                $title .= ' » ' . $this->path[$v];
            }
            !isset(MODULE['title']) ?: $title .= ' » ' . MODULE['title'];
        }
        return $title;
    }

    private function const_route()
    {
        $route = '';
        if ($this->path) {
            for ($i = 0, $c = count(PATH['exp']), $routes = '', $path = ''; $i < $c; $i++) {
                if ($i === $c - 1) {
                    $routes .= str_replace(
                            '{ T }', $this->path[PATH['exp'][$i]], HTML['route']['p']
                    );
                    break;
                }
                $search = ['{ H }', '{ A }'];
                $path .= '/' . PATH['exp'][$i];
                $replace = [$path, $this->path[PATH['exp'][$i]]];
                $routes .= str_replace($search, $replace, HTML['route']['a']);
            }
            $route = $this->_const_route_append($routes);
        }
        return $route;
    }

    private function _const_route_append($routes)
    {
        if (isset(MODULE['route'])) {
            $routes .= isset(MODULE['route']['red']) ?
                    str_replace('{ T }', MODULE['route']['red'], HTML['route']['p-red']) :
                    str_replace('{ T }', MODULE['route'], HTML['route']['p']);
        }
        return str_replace('{ R }', $routes, HTML['route']['div']);
    }

}
