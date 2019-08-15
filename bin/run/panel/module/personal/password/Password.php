<?php

namespace run\panel\module\personal\password;

class Password {

    private $_dir;
    private $_pass;
    private $_hl = [
        'new_pass' => '',
        'confirm' => ''
    ];
    private $_wg = [
        'wg_new_pass' => '',
        'wg_confirm' => ''
    ];

    public function module()
    {
        $this->_dir = [
            'mail' => DATA . 'panel' . D . 'auth' . D . 'mail' . D,
            'user' => DATA . 'panel' . D . 'auth' . D . 'user' . D
        ];
        !filter_has_var(0, 'post') ?: $this->_post();
        define('HL', $this->_hl + $this->_wg);
        return [
            'content' => require 'html.php'
        ];
    }

    private function _post()
    {
        $this->_hl['new_pass'] = trim(filter_input(0, 'new_pass'));
        $this->_hl['confirm'] = trim(filter_input(0, 'confirm'));
        $this->_hl();
    }

    private function _hl()
    {
        $hl = true;
        foreach ($this->_hl as $v) {
            empty($v) ?: $hl = false;
        }
        $hl ?: $this->_check();
    }

    private function _check()
    {
        if ($this->_hl['new_pass']) {
            $this->_dir['mail'] .= unserialize(file_get_contents(
                                    $this->_dir['user'] . filter_input(2, 'user') . D . 'data.sz'
                    ))['mail'] . D;
            $this->_pass = unserialize(file_get_contents($this->_dir['mail'] . 'pass.sz'));
            if (!preg_match("'^[a-z0-9]{4,32}$'i", $this->_hl['new_pass'])) {
                $this->_check_match();
            } elseif (password_verify($this->_hl['new_pass'], $this->_pass['pass'])) {
                $this->_check_verify();
            } elseif ($this->_hl['new_pass'] !== $this->_hl['confirm']) {
                $this->_check_confirm();
            }
            $this->_wg();
        } else {
            $this->_empty();
        }
    }

    private function _check_match()
    {
        $this->_wg['wg_new_pass'] = str_replace('{ W }', LE['wg_match'], HTML['wg']);
        $this->_empty();
    }

    private function _check_verify()
    {
        $this->_wg['wg_new_pass'] = str_replace('{ W }', LE['wg_old'], HTML['wg']);
        $this->_empty();
    }

    private function _check_confirm()
    {
        if ($this->_hl['confirm']) {
            $this->_hl['confirm'] = '';
            $this->_wg['wg_confirm'] = str_replace('{ W }', LE['wg_not_match'], HTML['wg']);
        } else {
            $this->_wg['wg_confirm'] = str_replace('{ W }', LE['wg_enter_confirm'], HTML['wg']);
        }
    }

    private function _empty()
    {
        $this->_hl = [
            'new_pass' => '',
            'confirm' => ''
        ];
    }

    private function _wg()
    {
        $wg = false;
        foreach ($this->_wg as $v) {
            empty($v) ?: $wg = true;
        }
        $wg ?: $this->_save();
    }

    private function _save()
    {
        $this->_pass['pass'] = password_hash($this->_hl['new_pass'], PASSWORD_DEFAULT);
        file_put_contents($this->_dir['mail'] . 'pass.sz', serialize($this->_pass));
        $this->_header();
    }

    private function _header()
    {
        header('Location: /personal' . EXT);
        exit;
    }

}
