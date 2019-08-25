<?php

namespace run\panel\module\personal\edit;

class Edit extends \run\panel\core\corp\users\Users {

    private $_hl;
    private $_wg = [
        'wg_mail' => '',
        'wg_user' => ''
    ];

    public function module()
    {
        parent::users();
        $this->post ? $this->_post() : $this->_hl();
        define('HL', $this->_hl + $this->_wg);
        return [
            'content' => require 'html.php'
        ];
    }

    private function _hl()
    {
        $this->_hl = [
            'mail' => $this->mail,
            'user' => str_replace('^', ' ', $this->user)
        ];
    }

    private function _post()
    {
        $this->_hl = [
            'mail' => $this->post['mail'],
            'user' => $this->post['user']
        ];
        $this->_old_data();
    }

    private function _old_data()
    {
        (
                $this->_hl['mail'] === $this->mail and
                str_replace(' ', '^', $this->_hl['user']) === $this->user
                ) ? $this->_header() : $this->_hl_empty();
    }

    private function _hl_empty()
    {
        $hl = true;
        foreach ($this->_hl as $v) {
            empty($v) ?: $hl = false;
        }
        $hl ?: $this->_wg_mail();
    }

    private function _wg_mail()
    {
        if (!empty($this->_hl['mail'])) {
            $wg = '';
            if (!preg_match("'.+@.+\..+'i", $this->_hl['mail'])) {
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
        return strpos($this->_hl['mail'], ' ') ? WG['wg_mail_emptyh'] : '';
    }

    private function _wg_mail_length()
    {
        return strlen($this->_hl['mail']) > 255 ? WG['wg_mail_length'] : '';
    }

    private function _wg_mail_exists()
    {
        return (
                file_exists($this->dir['mail'] . $this->_hl['mail']) and
                $this->_hl['mail'] !== $this->mail
                ) ? WG['wg_mail_exists'] : '';
    }

    private function _wg_user()
    {
        if (!empty($this->_hl['user'])) {
            if (!preg_match("'^[a-z0-9\-_ ]{2,32}$'i", $this->_hl['user'])) {
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
                file_exists($this->dir['user'] . $this->_hl['user']) and
                $this->_hl['user'] !== $this->user
        ) {
            $this->_wg['wg_user'] = str_replace('{ W }', WG['wg_user_exists'], HTML['wg']);
        }
    }

    private function _empty()
    {
        $hl = true;
        foreach ($this->_hl as $v) {
            !empty($v) ?: $hl = false;
        }
        $wg = true;
        foreach ($this->_wg as $v) {
            empty($v) ?: $wg = false;
        }
        !($hl and $wg) ?: $this->_dir();
    }

    private function _dir()
    {
        $this->_hl['user'] = str_replace(' ', '^', $this->_hl['user']);
        $this->dir['old_mail'] = $this->dir['mail'] . $this->mail . D;
        $this->dir['new_mail'] = $this->dir['mail'] . $this->_hl['mail'] . D;
        $this->dir['old_user'] = $this->dir['user'] . $this->user . D;
        $this->dir['new_user'] = $this->dir['user'] . $this->_hl['user'] . D;
        $this->_save_mail();
    }

    private function _save_mail()
    {
        if (rename($this->dir['old_mail'], $this->dir['new_mail']) === false) {
            exit('Failed to rename directory.');
        }
        if (file_put_contents($this->dir['new_mail'] . 'user.sz', serialize([
                    'user' => $this->_hl['user'],
                    'path' => $this->dir['new_user']
                ])) === false) {
            exit('Failed to write data to file.');
        }
        $this->_save_user();
    }

    private function _save_user()
    {
        if (rename($this->dir['old_user'], $this->dir['new_user']) === false) {
            exit('Failed to rename directory.');
        }
        $data = unserialize(file_get_contents($this->dir['new_user'] . 'data.sz'));
        $data['mail'] = $this->_hl['mail'];
        if (file_put_contents($this->dir['new_user'] . 'data.sz', serialize($data)) === false) {
            exit('Failed to write data to file.');
        }
        $this->_cookie();
    }

    private function _cookie()
    {
        setcookie('user', $this->_hl['user'], 0, '/');
        $this->_header();
    }

    private function _header()
    {
        header('Location: /personal' . EXT);
        exit;
    }

}
