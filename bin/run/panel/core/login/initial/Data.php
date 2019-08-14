<?php

namespace run\panel\core\login\initial;

class Data {

    private $_panel;

    public function __construct()
    {
        file_exists(DATA) ?: mkdir(DATA);
        $this->_panel = DATA . 'panel' . D;
        file_exists($this->_panel) ?: mkdir($this->_panel);
        $this->_app();
    }

    private function _app()
    {
        file_put_contents(DATA . 'app.sz', serialize([
            'root' => false,
            'ext' => '.ww'
        ]));
        $this->_panel_langs();
    }

    private function _panel_langs()
    {
        file_put_contents($this->_panel . 'lang.sz', serialize([
            'lang' => 'ru',
            'langs' => [
                'en' => 'English',
                'ru' => 'Русский'
            ],
            'multilang' => false
        ]));
        $this->_panel_auth();
    }

    private function _panel_auth()
    {
        file_put_contents($this->_panel . 'auth.sz', serialize([
            'block' => 2,
            'timer' => 1800
        ]));
        $this->_header();
    }

    private function _header()
    {
        header('Location: /');
        exit;
    }

}
