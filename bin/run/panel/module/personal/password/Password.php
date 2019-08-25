<?php

namespace run\panel\module\personal\password;

class Password extends \run\panel\core\corp\users\Users {

    private $_hl = [
        'pass' => '',
        'confirm' => ''
    ];
    private $_pass;
    private $_wg = [
        'wg_pass' => '',
        'wg_confirm' => ''
    ];

    public function module()
    {
        parent::users();
        !$this->post ?: $this->_post();
        define('HL', $this->_hl + $this->_wg);
        return [
            'content' => require 'html.php'
        ];
    }

    private function _post()
    {
        $this->_hl = [
            'pass' => $this->post['pass'],
            'confirm' => $this->post['confirm']
        ];
        $this->_hl_empty();
    }

    private function _hl_empty()
    {
        $hl = true;
        foreach ($this->_hl as $v) {
            empty($v) ?: $hl = false;
        }
        $hl ?: $this->_pass();
    }

    private function _pass()
    {
        if ($this->_hl['pass']) {
            $this->dir['mail'] .= unserialize(file_get_contents(
                                    $this->dir['user'] . $this->user . D . 'data.sz'
                    ))['mail'] . D;
            $this->_pass = unserialize(file_get_contents($this->dir['mail'] . 'pass.sz'));
            if (!preg_match("'^[a-z0-9]{4,32}$'i", $this->_hl['pass'])) {
                $this->_pass_match();
            } elseif (password_verify($this->_hl['pass'], $this->_pass['pass'])) {
                $this->_pass_verify();
            } elseif ($this->_hl['pass'] !== $this->_hl['confirm']) {
                $this->_pass_confirm();
            }
            $this->_wg_empty();
        } else {
            $this->_hl();
        }
    }

    private function _pass_match()
    {
        $this->_wg['wg_pass'] = str_replace('{ W }', WG['wg_pass_match'], HTML['wg']);
        $this->_hl();
    }

    private function _pass_verify()
    {
        $this->_wg['wg_pass'] = str_replace('{ W }', WG['wg_pass_old'], HTML['wg']);
        $this->_hl();
    }

    private function _pass_confirm()
    {
        if ($this->_hl['confirm']) {
            $this->_hl['confirm'] = '';
            $this->_wg['wg_confirm'] = str_replace('{ W }', WG['wg_pass_not_match'], HTML['wg']);
        } else {
            $this->_wg['wg_confirm'] = str_replace(
                    '{ W }', WG['wg_pass_enter_confirm'], HTML['wg']
            );
        }
    }

    private function _hl()
    {
        $this->_hl = [
            'pass' => '',
            'confirm' => ''
        ];
    }

    private function _wg_empty()
    {
        $wg = false;
        foreach ($this->_wg as $v) {
            empty($v) ?: $wg = true;
        }
        $wg ?: $this->_save();
    }

    private function _save()
    {
        $this->_pass['pass'] = password_hash($this->_hl['pass'], PASSWORD_DEFAULT);
        if (file_put_contents($this->dir['mail'] . 'pass.sz', serialize($this->_pass)) === false) {
            exit('Failed to write data to file.');
        }
        $this->_header();
    }

    private function _header()
    {
        header('Location: /personal' . EXT);
        exit;
    }

}
