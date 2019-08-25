<?php

namespace run\panel\module\users\create;

class Create extends \run\panel\core\corp\users\Users {

    private $_access;
    private $_hl_access;
    private $_hl = [
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

    public function module()
    {
        parent::users();
        $this->_hl_access();
        !$this->post ?: $this->_post();
        $this->_hl['access'] = $this->_hl_access;
        define('HL', $this->_hl + $this->_wg);
        return [
            'content' => require 'html.php'
        ];
    }

    private function _hl_access()
    {
        $this->_access = $this->post ? filter_input(0, 'access') : 'user';
        if (isset(LE['access'][$this->_access])) {
            $access = '';
            foreach (LE['access'] as $k => $v) {
                $access .= str_replace(['{ V }', '{ O }'], [$k, $v], HTML[
                        $k === $this->_access ? 'option-selected' : 'option'
                ]);
            }
            $this->_hl_access = $access;
        } else {
            exit('User access not found');
        }
    }

    private function _post()
    {
        $this->_hl = [
            'mail' => $this->post['mail'],
            'user' => $this->post['user'],
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
        return file_exists($this->dir['mail'] . $this->_hl['mail']) ? WG['wg_mail_exists'] : '';
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
        $this->_wg_pass();
    }

    private function _wg_user_exists()
    {
        if (file_exists($this->dir['user'] . $this->_hl['user'])) {
            $this->_wg['wg_user'] = str_replace('{ W }', WG['wg_user_exists'], HTML['wg']);
        }
    }

    private function _wg_pass()
    {
        if (!empty($this->_hl['pass'])) {
            if (!preg_match("'^[a-z0-9]{4,32}$'i", $this->_hl['pass'])) {
                $this->_hl['pass'] = '';
                $this->_wg['wg_pass'] = str_replace('{ W }', WG['wg_pass'], HTML['wg']);
            }
        } else {
            if (!empty($this->_hl['mail']) and ! empty($this->_hl['user'])) {
                $this->_wg['wg_pass'] = str_replace('{ W }', WG['wg_pass_enter'], HTML['wg']);
            }
        }
        $this->_wg_confirm();
    }

    private function _wg_confirm()
    {
        if (!empty($this->_hl['pass']) and ! empty($this->_hl['confirm'])) {
            if ($this->_hl['pass'] !== $this->_hl['confirm']) {
                $this->_hl['confirm'] = '';
                $this->_wg['wg_confirm'] = str_replace(
                        '{ W }', WG['wg_pass_not_match'], HTML['wg']
                );
            }
        } elseif (!empty($this->_hl['pass']) and empty($this->_hl['confirm'])) {
            if (!empty($this->_hl['mail']) and ! empty($this->_hl['user'])) {
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
        foreach ($this->_hl as $v) {
            !empty($v) ?: $hl = false;
        }
        $wg = true;
        foreach ($this->_wg as $v) {
            empty($v) ?: $wg = false;
        }
        !($hl and $wg) ?: $this->_save_dir();
    }

    private function _save_dir()
    {
        $this->_hl['user'] = str_replace(' ', '^', $this->_hl['user']);
        $this->dir['mail'] .= $this->_hl['mail'] . D;
        $this->dir['user'] .= $this->_hl['user'] . D;
        file_exists($this->dir['mail']) ?: mkdir($this->dir['mail']);
        file_exists($this->dir['user']) ?: mkdir($this->dir['user']);
        $this->_save_mail();
    }

    private function _save_mail()
    {
        if (
                file_put_contents($this->dir['mail'] . 'pass.sz', serialize([
                    'pass' => password_hash($this->_hl['pass'], PASSWORD_DEFAULT),
                    'time' => TIMESTAMP
                ])) === false) {
            exit('Failed to write data to file.');
        }
        if (
                file_put_contents($this->dir['mail'] . 'user.sz', serialize([
                    'user' => $this->_hl['user'],
                    'path' => $this->dir['user']
                ])) === false) {
            exit('Failed to write data to file.');
        }
        $this->_save_user();
    }

    private function _save_user()
    {
        if (
                file_put_contents($this->dir['user'] . 'data.sz', serialize([
                    'created' => TIMESTAMP,
                    'mail' => $this->_hl['mail'],
                    'access' => $this->_access
                ])) === false) {
            exit('Failed to write data to file.');
        }
        $this->_header();
    }

    private function _header()
    {
        header('Location: /users' . EXT);
        exit;
    }

}
