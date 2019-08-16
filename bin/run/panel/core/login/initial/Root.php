<?php

namespace run\panel\core\login\initial;

define('CORE', dirname(__DIR__, 2) . D);

class Root extends \run\panel\core\lang\Lang {

    use \run\uses\Hash;

    private $_dir;
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
        parent::lang();
        $this->_dir = [
            'auth' => DATA . 'panel' . D . 'auth' . D,
            'mail' => DATA . 'panel' . D . 'auth' . D . 'mail' . D,
            'user' => DATA . 'panel' . D . 'auth' . D . 'user' . D
        ];
        REQUEST === '/' ?: $this->_slash();
        define('LE_TMP', (require 'langs.php')[LANG]);
        define('HTML', require 'pattern.php');
        define('HL', $this->_hl());
        require 'template.php';
    }

    private function _slash()
    {
        header('Location: /');
        exit;
    }

    private function _hl()
    {
        !filter_has_var(0, 'post') ?: $this->_hl = [
                    'mail' => trim(filter_input(0, 'mail')),
                    'user' => $this->_double_space_cut(trim(filter_input(0, 'user'))),
                    'pass' => trim(filter_input(0, 'pass')),
                    'confirm' => trim(filter_input(0, 'confirm'))
        ];
        $this->_empty();
        return $this->_hl + $this->_wg;
    }

    private function _double_space_cut($data)
    {
        return preg_replace('/ +/', ' ', $data);
    }

    private function _empty($hl = true)
    {
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
                $wg = LE_TMP['wg_mail'];
            }
            !empty($wg) ?: $wg .= $this->_wg_mail_emptyh();
            !empty($wg) ?: $wg .= $this->_wg_mail_length();
            !empty($wg) ?: $wg .= $this->_wg_mail_exists();
            if (!empty($wg)) {
                $this->_wg['wg_mail'] = str_replace('{ W }', $wg, HTML['wg']);
            }
        } else {
            $this->_wg['wg_mail'] = str_replace('{ W }', LE_TMP['wg_mail_enter'], HTML['wg']);
        }
        $this->_wg_user();
    }

    private function _wg_mail_emptyh()
    {
        return strpos($this->_hl['mail'], ' ') ? LE_TMP['wg_mail_emptyh'] : '';
    }

    private function _wg_mail_length()
    {
        return strlen($this->_hl['mail']) > 255 ? LE_TMP['wg_mail_length'] : '';
    }

    private function _wg_mail_exists()
    {
        return file_exists($this->_dir['mail'] . $this->_hl['mail']) ? LE_TMP['wg_mail_exists'] : '';
    }

    private function _wg_user()
    {
        if (!empty($this->_hl['user'])) {
            if (!preg_match("'^[a-z0-9\-_ ]{2,32}$'i", $this->_hl['user'])) {
                $this->_wg['wg_user'] = str_replace('{ W }', LE_TMP['wg_user'], HTML['wg']);
            }
            if (empty($this->_wg['wg_user'])) {
                $this->_wg_user_exists();
            }
        } else {
            $this->_wg['wg_user'] = str_replace('{ W }', LE_TMP['wg_user_enter'], HTML['wg']);
        }
        $this->_wg_pass();
    }

    private function _wg_user_exists()
    {
        if (file_exists($this->_dir['user'] . $this->_hl['user'])) {
            $this->_wg['wg_user'] = str_replace('{ W }', LE_TMP['wg_user_exists'], HTML['wg']);
        }
    }

    private function _wg_pass()
    {
        if (!empty($this->_hl['pass'])) {
            if (!preg_match("'^[a-z0-9]{4,32}$'i", $this->_hl['pass'])) {
                $this->_hl['pass'] = '';
                $this->_wg['wg_pass'] = str_replace('{ W }', LE_TMP['wg_pass'], HTML['wg']);
            }
        } else {
            if (!empty($this->_hl['mail']) and ! empty($this->_hl['user'])) {
                $this->_wg['wg_pass'] = str_replace('{ W }', LE_TMP['wg_pass_enter'], HTML['wg']);
            }
        }
        $this->_wg_confirm();
    }

    private function _wg_confirm()
    {
        if (!empty($this->_hl['pass']) and ! empty($this->_hl['confirm'])) {
            if ($this->_hl['pass'] !== $this->_hl['confirm']) {
                $this->_hl['confirm'] = '';
                $this->_wg['wg_confirm'] = str_replace('{ W }', LE_TMP['wg_not_match'], HTML['wg']);
            }
        } elseif (!empty($this->_hl['pass']) and empty($this->_hl['confirm'])) {
            if (!empty($this->_hl['mail']) and ! empty($this->_hl['user'])) {
                $this->_wg['wg_confirm'] = str_replace(
                        '{ W }', LE_TMP['wg_enter_confirm'], HTML['wg']
                );
            }
        }
        $this->_wg_empty();
    }

    private function _wg_empty($hl = true, $wg = true)
    {
        foreach ($this->_hl as $v) {
            !empty($v) ?: $hl = false;
        }
        foreach ($this->_wg as $v) {
            empty($v) ?: $wg = false;
        }
        !($hl and $wg) ?: $this->_save_dir();
    }

    private function _save_dir()
    {
        $this->_hl['user'] = str_replace(' ', '+', $this->_hl['user']);
        file_exists($this->_dir['auth']) ?: mkdir($this->_dir['auth']);
        file_exists($this->_dir['mail']) ?: mkdir($this->_dir['mail']);
        file_exists($this->_dir['user']) ?: mkdir($this->_dir['user']);
        $this->_dir['mail'] .= $this->_hl['mail'] . D;
        $this->_dir['user'] .= $this->_hl['user'] . D;
        file_exists($this->_dir['mail']) ?: mkdir($this->_dir['mail']);
        file_exists($this->_dir['user']) ?: mkdir($this->_dir['user']);
        $this->_save_mail();
    }

    private function _save_mail()
    {
        file_put_contents($this->_dir['mail'] . 'pass.sz', serialize([
            'pass' => password_hash($this->_hl['pass'], PASSWORD_DEFAULT),
            'time' => TS
        ]));
        file_put_contents($this->_dir['mail'] . 'user.sz', serialize([
            'user' => $this->_hl['user'],
            'path' => $this->_dir['user']
        ]));
        $this->_save_user();
    }

    private function _save_user()
    {
        $hash = $this->hash(32);
        file_put_contents($this->_dir['user'] . 'data.sz', serialize([
            'created' => TS,
            'mail' => $this->_hl['mail'],
            'status' => 'root'
        ]));
        file_put_contents($this->_dir['user'] . 'hash.sz', serialize([
            'hash' => $hash,
            'time' => TS,
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
        $this->_header($app['ext']);
    }

    private function _header($ext)
    {
        header('Location: /main' . $ext);
        exit;
    }

}
