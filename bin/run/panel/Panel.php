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
        setcookie('hash', '', 0, '/');
        setcookie('user', '', 0, '/');
        header('Location: /');
    }

    private function _login()
    {
        isset(AUTH['wg']) ? new core\login\Login : $this->_module();
    }

    private function _module()
    {
        $this->res['content'] = '';
        $this->echo();
    }

}
