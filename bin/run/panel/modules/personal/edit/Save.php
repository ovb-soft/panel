<?php

namespace run\panel\modules\personal\edit;

class Save extends \run\panel\core\corp\users\Users {

    public function __construct()
    {
        parent::__construct();
    }

    protected function save()
    {
        $this->hl['user'] = str_replace(' ', '~', $this->hl['user']);
        $this->dir['auth'] .= 'data' . D;
        $this->dir['old_mail'] = $this->dir['mail'] . $this->mail . D;
        $this->dir['new_mail'] = $this->dir['mail'] . $this->hl['mail'] . D;
        $this->dir['old_user'] = $this->dir['user'] . $this->user . D;
        $this->dir['new_user'] = $this->dir['user'] . $this->hl['user'] . D;
        $this->_save_list_date();
    }

    private function _save_list_date()
    {
        $file = $this->dir['auth'] . 'date.sz';
        $data = unserialize(file_get_contents($file));
        $data[$this->hl['user']] = $data[$this->user];
        unset($data[$this->user]);
        if (file_put_contents($file, serialize($data)) === false) {
            exit('Failed to write data to file.');
        }
        $this->_save_list_mail();
    }

    private function _save_list_mail()
    {
        $file = $this->dir['auth'] . 'mail.sz';
        $data = unserialize(file_get_contents($file));
        $data[$this->hl['user']] = $this->hl['mail'];
        unset($data[$this->user]);
        if (file_put_contents($file, serialize($data)) === false) {
            exit('Failed to write data to file.');
        }
        $this->_save_list_access();
    }

    private function _save_list_access()
    {
        $file = $this->dir['auth'] . 'access.sz';
        $data = unserialize(file_get_contents($file));
        $data[$this->hl['user']] = AUTH['access'];
        unset($data[$this->user]);
        if (file_put_contents($file, serialize($data)) === false) {
            exit('Failed to write data to file.');
        }
        $this->_save_mail();
    }

    private function _save_mail()
    {
        if (rename($this->dir['old_mail'], $this->dir['new_mail']) === false) {
            exit('Failed to rename directory.');
        }
        if (file_put_contents($this->dir['new_mail'] . 'user.sz', serialize([
                    'user' => $this->hl['user'],
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
        $data['mail'] = $this->hl['mail'];
        if (file_put_contents($this->dir['new_user'] . 'data.sz', serialize($data)) === false) {
            exit('Failed to write data to file.');
        }
        $this->_save_cookie();
    }

    private function _save_cookie()
    {
        setcookie('user', $this->hl['user'], 0, '/');
        $this->header();
    }

    protected function header()
    {
        header('Location: /personal' . EXT);
        exit;
    }

}
