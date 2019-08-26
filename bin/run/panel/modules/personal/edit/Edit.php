<?php

namespace run\panel\modules\personal\edit;

class Edit extends Save {

    protected $hl;
    private $_wg = [
        'wg_mail' => '',
        'wg_user' => ''
    ];

    public function __construct()
    {
        parent::__construct();
        $this->post ? $this->_old_data($this->hl = $this->post) : $this->_hl();
        define('HL', $this->hl + $this->_wg);
        define('MODULE', [
            'content' => require 'html.php'
        ]);
    }

    private function _hl()
    {
        $this->hl = [
            'mail' => $this->mail,
            'user' => str_replace('^', ' ', $this->user)
        ];
    }

    private function _old_data()
    {
        (
                $this->hl['mail'] === $this->mail and
                str_replace(' ', '^', $this->hl['user']) === $this->user
                ) ? $this->header() : $this->_hl_empty();
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
        return (
                file_exists($this->dir['mail'] . $this->hl['mail']) and
                $this->hl['mail'] !== $this->mail
                ) ? WG['wg_mail_exists'] : '';
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
        $this->_empty();
    }

    private function _wg_user_exists()
    {
        if (
                file_exists($this->dir['user'] . $this->hl['user']) and
                $this->hl['user'] !== $this->user
        ) {
            $this->_wg['wg_user'] = str_replace('{ W }', WG['wg_user_exists'], HTML['wg']);
        }
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
