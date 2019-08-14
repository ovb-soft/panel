<?php

namespace run\panel\module\settings\login;

class Login {

    private $_auth;

    public function module()
    {
        $this->_auth = unserialize(file_get_contents(DATA . 'panel' . D . 'auth.sz'));
        !filter_has_var(0, 'post') ?: $this->_post();
        define('HL', $this->_hl());
        return [
            'content' => require 'html.php'
        ];
    }

    public function _hl() {
        $hl['block'] = '';
        foreach (LE['blocks'] as $k => $v) {
            $html = $k === $this->_auth['block'] ? 'option-selected' : 'option';
            $hl['block'] .= str_replace(['{ V }', '{ O }'], [$k, $v], HTML[$html]);
        }
        $hl['timer'] = '';
        foreach (LE['timers'] as $k => $v) {
            $html = $k === $this->_auth['timer'] ? 'option-selected' : 'option';
            $hl['timer'] .= str_replace(['{ V }', '{ O }'], [$k, $v], HTML[$html]);
        }
        return $hl;
    }

    public function _post() {
        $this->_auth['block'] = (int) filter_input(0, 'block');
        $this->_auth['timer'] = (int) filter_input(0, 'timer');
        file_put_contents(DATA . 'panel' . D . 'auth.sz', serialize($this->_auth));
        $this->_header();
    }

    private function _header() {
        header('Location: /settings' . EXT);
        exit;
    }

}
