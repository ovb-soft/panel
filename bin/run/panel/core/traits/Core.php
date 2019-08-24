<?php

namespace run\panel\core\traits;

trait Core {

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

    private function _const_menu($menu)
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

}
