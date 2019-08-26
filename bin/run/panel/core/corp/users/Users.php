<?php

namespace run\panel\core\corp\users;

define('WG', require 'lang' . D . LANG . '.php');

class Users {

    protected $dir;
    protected $user;
    protected $mail;
    protected $post;

    public function __construct()
    {
        $this->dir = USER;
        $this->user = false;
        $this->mail = false;
        $this->post = false;
        !filter_has_var(2, 'user') ?: $this->_users_user();
        !filter_has_var(0, 'post') ?: $this->_users_post();
    }

    private function _users_user()
    {
        $this->user = filter_input(2, 'user');
        $file = $this->dir['user'] . $this->user . D . 'data.sz';
        !file_exists($file) ?: $this->mail = unserialize(file_get_contents($file))['mail'];
    }

    private function _users_post()
    {
        !filter_has_var(0, 'mail') ?: $this->post['mail'] = trim(filter_input(0, 'mail'));
        !filter_has_var(0, 'user') ?: $this->post['user'] = $this->_users_cut_double_space_user();
        !filter_has_var(0, 'pass') ?: $this->post['pass'] = trim(filter_input(0, 'pass'));
        !filter_has_var(0, 'confirm') ?: $this->post['confirm'] = trim(filter_input(0, 'confirm'));
    }

    private function _users_cut_double_space_user()
    {
        return preg_replace('/ +/', ' ', trim(filter_input(0, 'user')));
    }

}
