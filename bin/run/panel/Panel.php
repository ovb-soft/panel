<?php

namespace run\panel;

class Panel extends core\Core {

    public function __construct()
    {
        parent::core();
        PATH['path'] === 'logout' ? $this->_logout() : $this->_login();
    }

    private function _logout()
    {
        header('Location: /');
    }

    private function _login()
    {
        $this->res['content'] = '';
        $this->echo();
    }

}
