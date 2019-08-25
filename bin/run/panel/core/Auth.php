<?php

namespace run\panel\core;

class Auth {

    use \traits\Hash;

    private $_dir;
    private $_data;

    public function __construct()
    {
        $auth = ['wg' => false];
        if (filter_has_var(0, 'login')) {
            $auth = $this->_post();
            if (!isset($auth['wg'])) {
                header('Location: ' . REQUEST);
                exit;
            }
        } elseif (filter_has_var(2, 'user') or filter_has_var(2, 'hash')) {
            $auth = $this->_cookie();
        }
        define('AUTH', $auth);
    }

    private function _post()
    {
        $mail = trim(filter_input(0, 'mail'));
        $this->_data['pass'] = trim(filter_input(0, 'pass'));
        if ($mail and $this->_data['pass']) {
            $this->_dir['mail'] = USER['mail'] . $mail . D;
            return $this->_exists();
        }
        return ['wg' => false];
    }

    private function _exists()
    {
        if (file_exists($this->_dir['mail'] . 'pass.sz')) {
            return $this->_block();
        }
        return ['wg' => 1];
    }

    private function _block()
    {
        $pass = unserialize(file_get_contents($this->_dir['mail'] . 'pass.sz'));
        $time = $pass['time'];
        $pass['time'] = TIMESTAMP;
        file_put_contents($this->_dir['mail'] . 'pass.sz', serialize($pass));
        $block = unserialize(file_get_contents(DATA . 'panel' . D . 'auth.sz'))['block'];
        if (TIMESTAMP - $block > $time) {
            return $this->_password($pass['pass']);
        }
        return ['wg' => 2];
    }

    private function _password($pass)
    {
        if (password_verify($this->_data['pass'], $pass)) {
            $user = unserialize(file_get_contents($this->_dir['mail'] . 'user.sz'));
            setcookie('user', $user['user'], 0, '/');
            $this->_data['user'] = $user['user'];
            $this->_data['path'] = $user['path'];
            $this->_data['agent'] = filter_input(5, 'HTTP_USER_AGENT');
            return $this->_hash();
        }
        return ['wg' => 1];
    }

    private function _cookie()
    {
        $this->_data['user'] = filter_input(2, 'user');
        $this->_data['hash'] = filter_input(2, 'hash');
        if ($this->_data['user'] and $this->_data['hash']) {
            $this->_data['path'] = USER['user'] . $this->_data['user'] . D;
            return $this->_timer();
        }
        return ['wg' => 5];
    }

    private function _timer()
    {
        if (file_exists($this->_data['path'] . 'hash.sz')) {
            $this->_data['agent'] = filter_input(5, 'HTTP_USER_AGENT');
            $timer = unserialize(file_get_contents(DATA . 'panel' . D . 'auth.sz'))['timer'];
            $hash = unserialize(file_get_contents($this->_data['path'] . 'hash.sz'));
            if (
                    $this->_data['hash'] === $hash['hash'] and
                    TIMESTAMP - $timer < $hash['time'] and
                    $this->_data['agent'] === $hash['agent']) {
                return $this->_hash();
            }
            return ['wg' => 3];
        }
        return ['wg' => 4];
    }

    private function _hash()
    {
        $hash = $this->hash(32);
        setcookie('hash', $hash, 0, '/');
        if (file_put_contents($this->_data['path'] . 'hash.sz', serialize([
                    'hash' => $hash,
                    'time' => TIMESTAMP,
                    'agent' => $this->_data['agent']
                ]))) {
            return unserialize(file_get_contents($this->_data['path'] . 'data.sz'))['access'];
        }
        return ['wg' => 4];
    }

}
