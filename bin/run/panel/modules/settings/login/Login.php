<?php

namespace run\panel\modules\settings\login;

class Login {

    private $_auth;

    public function __construct()
    {
        $this->_auth = unserialize(file_get_contents(DATA . 'panel' . D . 'auth.sz'));
        !filter_has_var(0, 'post') ?: $this->_post();
        define('HL', $this->_hl());
        define('MODULE', [
            'content' => require 'html.php'
        ]);
    }

    private function _post()
    {
        $this->_auth['block'] = (int) filter_input(0, 'block');
        $this->_auth['timer'] = (int) filter_input(0, 'timer');
        if (file_put_contents(DATA . 'panel' . D . 'auth.sz', serialize($this->_auth)) === false) {
            exit('Failed to write data to file.');
        }
        $this->_header();
    }

    private function _header()
    {
        header('Location: /settings' . EXT);
        exit;
    }

    private function _hl()
    {
        $hl['block'] = '';
        foreach (LE['blocks'] as $k => $v) {
            $hl['block'] .= str_replace(['{ V }', '{ O }'], [$k, $v], HTML[
                    $k === $this->_auth['block'] ? 'option-selected' : 'option'
            ]);
        }
        $hl['timer'] = '';
        foreach (LE['timers'] as $k => $v) {
            $hl['timer'] .= str_replace(['{ V }', '{ O }'], [$k, $v], HTML[
                    $k === $this->_auth['timer'] ? 'option-selected' : 'option'
            ]);
        }
        return $hl;
    }

}
