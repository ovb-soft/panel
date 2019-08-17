<?php

namespace run\panel\module\settings\timezone;

class Timezone {

    private $_app;

    public function module()
    {
        $this->_app = unserialize(file_get_contents(DATA . 'app.sz'));
        define('HL', [
            'timezone' => $this->_app['timezone']
        ]);
        return [
            'content' => require 'html.php'
        ];
    }

}
