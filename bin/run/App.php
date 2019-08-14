<?php

namespace run;

define('DATA', __DIR__ . D . 'data' . D);
define('REQUEST', urldecode(filter_input(5, 'REQUEST_URI')));

class App {

    private $_app;
    private $_ext;
    private $_path;

    public function __construct()
    {
        file_exists(DATA) ? $this->_app() : new panel\core\login\initial\Data;
    }

    private function _app()
    {
        $this->_app = unserialize(file_get_contents(DATA . 'app.sz'));
        $this->_branches();
    }

    private function _branches()
    {
        $this->_path();
        $this->_ext === $this->_app['ext'] ? $this->_panel() : $this->_open();
    }

    private function _path()
    {
        $query = strrchr(REQUEST, '?');
        $urn = $query ? substr(REQUEST, 0, - strlen($query)) : REQUEST;
        $this->_ext = strrchr($urn, '.');
        $path = $this->_ext ? substr($urn, 1, - strlen($this->_ext)) : substr($urn, 1);
        $this->_path = [
            'error' => $this->_error($path),
            'path' => $path
        ];
    }

    private function _error($path)
    {
        return (
                preg_match('/^[\w\-\.\/\?\&\=\:]+$/iu', REQUEST) === 0 or
                preg_match('/\/\//', REQUEST) === 1 or
                preg_match('/[\/]$/', $path) === 1 or
                $this->_ext and empty($path)
                ) ? true : false;
    }

    private function _panel()
    {
        define('EXT', $this->_app['ext']);
        define('PATH', $this->_path);
        new panel\Panel;
    }

    private function _open()
    {
        define('EXT', $this->_app['ext']);
        new open\Open;
    }

}
