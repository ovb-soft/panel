<?php

namespace initial;

define('USER', [
    'auth' => DATA . 'panel' . D . 'auth' . D,
    'mail' => DATA . 'panel' . D . 'auth' . D . 'mail' . D,
    'user' => DATA . 'panel' . D . 'auth' . D . 'user' . D
]);
define('HTML', require 'pattern.php');

new \run\panel\core\lang\Lang;

class Root extends \run\panel\core\corp\users\Users {

    use Functions,
        \traits\Hash;

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

    public function __construct()
    {
        parent::users();
        REQUEST === '/' ?: $this->slash();
        define('LE', (require 'langs.php')[LANG]);
        !$this->post ?: $this->_post();
        define('HL', $this->_hl + $this->_wg);
        require 'template.php';
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
        return strpos($this->_hl['mail'], ' ') ? WG['wg_mail_emptyh'] : '';
    }

    private function _wg_mail_length()
    {
        return strlen($this->_hl['mail']) > 255 ? WG['wg_mail_length'] : '';
    }

    private function _wg_user()
    {
        if (!empty($this->_hl['user'])) {
            if (!preg_match("'^[a-z0-9\-_ ]{2,32}$'i", $this->_hl['user'])) {
                $this->_wg['wg_user'] = str_replace('{ W }', WG['wg_user'], HTML['wg']);
            }
        } else {
            $this->_wg['wg_user'] = str_replace('{ W }', WG['wg_user_enter'], HTML['wg']);
        }
        $this->_wg_pass();
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
        file_exists($this->dir['auth']) ?: mkdir($this->dir['auth']);
        file_exists($this->dir['mail']) ?: mkdir($this->dir['mail']);
        file_exists($this->dir['user']) ?: mkdir($this->dir['user']);
        $this->dir['mail'] .= $this->_hl['mail'] . D;
        $this->dir['user'] .= $this->_hl['user'] . D;
        file_exists($this->dir['mail']) ?: mkdir($this->dir['mail']);
        file_exists($this->dir['user']) ?: mkdir($this->dir['user']);
        $this->_save_mail();
    }

    private function _save_mail()
    {
        file_put_contents($this->dir['mail'] . 'pass.sz', serialize([
            'pass' => password_hash($this->_hl['pass'], PASSWORD_DEFAULT),
            'time' => TIMESTAMP
        ]));
        file_put_contents($this->dir['mail'] . 'user.sz', serialize([
            'user' => $this->_hl['user'],
            'path' => $this->dir['user']
        ]));
        $this->_save_user();
    }

    private function _save_user()
    {
        $hash = $this->hash(32);
        file_put_contents($this->dir['user'] . 'data.sz', serialize([
            'created' => TIMESTAMP,
            'mail' => $this->_hl['mail'],
            'access' => 'root'
        ]));
        file_put_contents($this->dir['user'] . 'hash.sz', serialize([
            'hash' => $hash,
            'time' => TIMESTAMP,
            'agent' => filter_input(5, 'HTTP_USER_AGENT')
        ]));
        setcookie('user', $this->_hl['user'], 0, '/');
        setcookie('hash', $hash, 0, '/');
        $this->_save_app();
    }

    private function _save_app()
    {
        $app = unserialize(file_get_contents(DATA . 'app.sz'));
        $app['root'] = $this->_hl['user'];
        file_put_contents(DATA . 'app.sz', serialize($app));
        $this->ext = $app['ext'];
        $this->header();
    }

}
