<?php

namespace run\panel;

define('USER', [
    'auth' => DATA . 'panel' . D . 'auth' . D,
    'mail' => DATA . 'panel' . D . 'auth' . D . 'mail' . D,
    'user' => DATA . 'panel' . D . 'auth' . D . 'user' . D
]);
define('MODULE', __DIR__ . D . 'module' . D);

class Panel extends core\Core {

    public function __construct()
    {
        parent::__construct();
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
        isset(AUTH['wg']) ? new core\login\Login : $this->_error_404();
    }

    private function _error_404()
    {
        ERROR ? $this->_error_code('404') : $this->_module();
        $this->echo();
    }

    private function _error_code($code)
    {
        $this->res['content'] = str_replace('{ E }', LT[$code]['content'], HTML['id-error']);
    }

    private function _module()
    {
        $run = '\\run\\panel\\module\\' .
                str_replace('/', '\\', PATH['path']) . '\\' .
                PATH['class'];
        $this->res = (new $run)->module();
    }

}
