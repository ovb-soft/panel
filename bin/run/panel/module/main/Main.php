<?php

namespace run\panel\module\main;

class Main {

    public function module()
    {
        return [
            'content' => require 'html.php'
        ];
    }

}
