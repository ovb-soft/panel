<?php

namespace run\panel\core\corp\users;

define('WG', require 'lang' . D . LANG . '.php');

class Users {

    protected $dir;
    protected $user;
    protected $mail;
    protected $input;

    public function __construct()
    {
        $this->dir = USER;
        $this->user = false;
        $this->mail = false;
        $this->input = false;
        !filter_has_var(2, 'user') ?: $this->_users_user();
        $this->_users_input();
    }

    private function _users_user()
    {
        $this->user = filter_input(2, 'user');
        $file = $this->dir['user'] . $this->user . D . 'data.sz';
        !file_exists($file) ?: $this->mail = unserialize(file_get_contents($file))['mail'];
    }

    private function _users_input()
    {
        if (filter_has_var(0, 'mail')) {
            $this->input['mail'] = trim(filter_input(0, 'mail'));
        } elseif (filter_has_var(1, 'mail')) {
            $this->input['mail'] = trim(filter_input(1, 'mail'));
        }
        if (filter_has_var(0, 'user')) {
            $this->input['user'] = $this->_users_cut_double_space_user();
        } elseif (filter_has_var(1, 'user')) {
            $this->input['user'] = trim(filter_input(1, 'user'));
        }
        if (filter_has_var(0, 'pass')) {
            $this->input['pass'] = trim(filter_input(0, 'pass'));
        } elseif (filter_has_var(1, 'pass')) {
            $this->input['pass'] = trim(filter_input(1, 'pass'));
        }
        if (filter_has_var(0, 'confirm')) {
            $this->input['confirm'] = trim(filter_input(0, 'confirm'));
        } elseif (filter_has_var(1, 'confirm')) {
            $this->input['confirm'] = trim(filter_input(1, 'confirm'));
        }
    }

    private function _users_cut_double_space_user()
    {
        return preg_replace('/ +/', ' ', trim(filter_input(0, 'user')));
    }

}
