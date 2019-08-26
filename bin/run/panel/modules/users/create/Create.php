<?php

namespace run\panel\modules\users\create;

class Create extends Save {

    protected $access;
    protected $hl = [
        'mail' => '',
        'user' => '',
        'pass' => '',
        'confirm' => ''
    ];
    private $_access;
    private $_wg = [
        'wg_mail' => '',
        'wg_user' => '',
        'wg_pass' => '',
        'wg_confirm' => ''
    ];

    public function __construct()
    {
        parent::__construct();
        $this->_access();
        !$this->post ?: $this->_hl_empty($this->hl = $this->post);
        $this->hl['access'] = $this->_access;
        define('HL', $this->hl + $this->_wg);
        define('MODULE', [
            'content' => require 'html.php'
        ]);
    }

    private function _access()
    {
        $this->access = $this->post ? filter_input(0, 'access') : 'user';
        if (isset(LE['access'][$this->access])) {
            $access = '';
            foreach (LE['access'] as $k => $v) {
                $access .= str_replace(['{ V }', '{ O }'], [$k, $v], HTML[
                        $k === $this->access ? 'option-selected' : 'option'
                ]);
            }
            $this->_access = $access;
        } else {
            exit('User access not found');
        }
    }

    private function _hl_empty()
    {
        $hl = true;
        foreach ($this->hl as $v) {
            empty($v) ?: $hl = false;
        }
        $hl ?: $this->_wg_mail();
    }

    private function _wg_mail()
    {
        if (!empty($this->hl['mail'])) {
            $wg = '';
            if (!preg_match("'.+@.+\..+'i", $this->hl['mail'])) {
                $wg = WG['wg_mail'];
            }
            !empty($wg) ?: $wg .= $this->_wg_mail_emptyh();
            !empty($wg) ?: $wg .= $this->_wg_mail_length();
            !empty($wg) ?: $wg .= $this->_wg_mail_exists();
            if (!empty($wg)) {
                $this->_wg['wg_mail'] = str_replace('{ W }', $wg, HTML['wg']);
            }
        } else {
            $this->_wg['wg_mail'] = str_replace('{ W }', WG['wg_mail_enter'], HTML['wg']);
        }
        $this->_wg_user();
    }

    private function _wg_mail_emptyh()
    {
        return strpos($this->hl['mail'], ' ') ? WG['wg_mail_emptyh'] : '';
    }

    private function _wg_mail_length()
    {
        return strlen($this->hl['mail']) > 255 ? WG['wg_mail_length'] : '';
    }

    private function _wg_mail_exists()
    {
        return file_exists($this->dir['mail'] . $this->hl['mail']) ? WG['wg_mail_exists'] : '';
    }

    private function _wg_user()
    {
        if (!empty($this->hl['user'])) {
            if (!preg_match("'^[a-z0-9\-_ ]{2,32}$'i", $this->hl['user'])) {
                $this->_wg['wg_user'] = str_replace('{ W }', WG['wg_user'], HTML['wg']);
            }
            if (empty($this->_wg['wg_user'])) {
                $this->_wg_user_exists();
            }
        } else {
            $this->_wg['wg_user'] = str_replace('{ W }', WG['wg_user_enter'], HTML['wg']);
        }
        $this->_wg_pass();
    }

    private function _wg_user_exists()
    {
        if (file_exists($this->dir['user'] . $this->hl['user'])) {
            $this->_wg['wg_user'] = str_replace('{ W }', WG['wg_user_exists'], HTML['wg']);
        }
    }

    private function _wg_pass()
    {
        if (!empty($this->hl['pass'])) {
            if (!preg_match("'^[a-z0-9]{4,32}$'i", $this->hl['pass'])) {
                $this->hl['pass'] = '';
                $this->_wg['wg_pass'] = str_replace('{ W }', WG['wg_pass'], HTML['wg']);
            }
        } else {
            if (!empty($this->hl['mail']) and ! empty($this->hl['user'])) {
                $this->_wg['wg_pass'] = str_replace('{ W }', WG['wg_pass_enter'], HTML['wg']);
            }
        }
        $this->_wg_confirm();
    }

    private function _wg_confirm()
    {
        if (!empty($this->hl['pass']) and ! empty($this->hl['confirm'])) {
            if ($this->hl['pass'] !== $this->hl['confirm']) {
                $this->hl['confirm'] = '';
                $this->_wg['wg_confirm'] = str_replace(
                        '{ W }', WG['wg_pass_not_match'], HTML['wg']
                );
            }
        } elseif (!empty($this->hl['pass']) and empty($this->hl['confirm'])) {
            if (!empty($this->hl['mail']) and ! empty($this->hl['user'])) {
                $this->_wg['wg_confirm'] = str_replace(
                        '{ W }', WG['wg_pass_enter_confirm'], HTML['wg']
                );
            }
        }
        $this->_empty();
    }

    private function _empty()
    {
        $hl = true;
        foreach ($this->hl as $v) {
            !empty($v) ?: $hl = false;
        }
        $wg = true;
        foreach ($this->_wg as $v) {
            empty($v) ?: $wg = false;
        }
        !($hl and $wg) ?: $this->save();
    }

}
