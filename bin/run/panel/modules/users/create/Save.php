<?php

namespace run\panel\modules\users\create;

class Save extends \run\panel\core\corp\users\Users {

    public function __construct()
    {
        parent::__construct();
    }

    protected function save()
    {
        $this->hl['user'] = str_replace(' ', '^', $this->hl['user']);
        $this->dir['mail'] .= $this->hl['mail'] . D;
        $this->dir['user'] .= $this->hl['user'] . D;
        file_exists($this->dir['mail']) ?: mkdir($this->dir['mail']);
        file_exists($this->dir['user']) ?: mkdir($this->dir['user']);
        $this->_save_mail();
    }

    private function _save_mail()
    {
        if (
                file_put_contents($this->dir['mail'] . 'pass.sz', serialize([
                    'pass' => password_hash($this->hl['pass'], PASSWORD_DEFAULT),
                    'time' => TIMESTAMP
                ])) === false) {
            exit('Failed to write data to file.');
        }
        if (
                file_put_contents($this->dir['mail'] . 'user.sz', serialize([
                    'user' => $this->hl['user'],
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
                    'mail' => $this->hl['mail'],
                    'access' => $this->access
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
