<?php

namespace initial;

class Save extends \run\panel\core\corp\users\Users {

    use \traits\Hash;

    public function __construct()
    {
        parent::__construct();
    }

    protected function save()
    {
        $this->hl['user'] = str_replace(' ', '^', $this->hl['user']);
        file_exists($this->dir['auth']) ?: mkdir($this->dir['auth']);
        file_exists($this->dir['mail']) ?: mkdir($this->dir['mail']);
        file_exists($this->dir['user']) ?: mkdir($this->dir['user']);
        $this->dir['mail'] .= $this->hl['mail'] . D;
        $this->dir['user'] .= $this->hl['user'] . D;
        file_exists($this->dir['mail']) ?: mkdir($this->dir['mail']);
        file_exists($this->dir['user']) ?: mkdir($this->dir['user']);
        $this->_save_mail();
    }

    private function _save_mail()
    {
        file_put_contents($this->dir['mail'] . 'pass.sz', serialize([
            'pass' => password_hash($this->hl['pass'], PASSWORD_DEFAULT),
            'time' => TIMESTAMP
        ]));
        file_put_contents($this->dir['mail'] . 'user.sz', serialize([
            'user' => $this->hl['user'],
            'path' => $this->dir['user']
        ]));
        $this->_save_user();
    }

    private function _save_user()
    {
        $hash = $this->hash(32);
        file_put_contents($this->dir['user'] . 'data.sz', serialize([
            'created' => TIMESTAMP,
            'mail' => $this->hl['mail'],
            'access' => 'root'
        ]));
        file_put_contents($this->dir['user'] . 'hash.sz', serialize([
            'hash' => $hash,
            'time' => TIMESTAMP,
            'agent' => filter_input(5, 'HTTP_USER_AGENT')
        ]));
        setcookie('user', $this->hl['user'], 0, '/');
        setcookie('hash', $hash, 0, '/');
        $this->_save_app();
    }

    private function _save_app()
    {
        $app = unserialize(file_get_contents(DATA . 'app.sz'));
        $app['root'] = $this->hl['user'];
        file_put_contents(DATA . 'app.sz', serialize($app));
        $this->header($app['ext']);
    }

    private function header($ext)
    {
        header('Location: /personal' . $ext);
        exit;
    }

}
