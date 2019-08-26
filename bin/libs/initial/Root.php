<?php

namespace initial;

define('USER', [
    'auth' => DATA . 'panel' . D . 'auth' . D,
    'mail' => DATA . 'panel' . D . 'auth' . D . 'mail' . D,
    'user' => DATA . 'panel' . D . 'auth' . D . 'user' . D
]);
define('HTML', require 'pattern.php');

new \run\panel\core\lang\Lang;

class Root extends Save {

    protected $hl = [
        'mail' => '',
        'user' => '',
        'pass' => '',
        'confirm' => ''
    ];
    private $_wg = [
        'wg_mail' => '',
        'wg_user' => '',
        'wg_pass' => '',
        'wg_confirm' => ''
    ];

    public function __construct()
    {
        parent::__construct();
        REQUEST === '/' ?: $this->slash();
        define('LE', require 'lang' . D . LANG . '.php');
        !$this->post ?: $this->_hl_empty($this->hl = $this->post);
        define('HL', $this->hl + $this->_wg);
        require 'template.php';
    }

    private function slash()
    {
        header('Location: /');
        exit;
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
                $wg = LE['wg_mail'];
            }
            !empty($wg) ?: $wg .= $this->_wg_mail_emptyh();
            !empty($wg) ?: $wg .= $this->_wg_mail_length();
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

    private function _wg_user()
    {
        if (!empty($this->hl['user'])) {
            if (!preg_match("'^[a-z0-9\-_ ]{2,32}$'i", $this->hl['user'])) {
                $this->_wg['wg_user'] = str_replace('{ W }', WG['wg_user'], HTML['wg']);
            }
        } else {
            $this->_wg['wg_user'] = str_replace('{ W }', WG['wg_user_enter'], HTML['wg']);
        }
        $this->_wg_pass();
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
