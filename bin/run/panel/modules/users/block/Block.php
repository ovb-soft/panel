<?php

namespace run\panel\modules\users\block;

class Block {

    public function __construct()
    {
        define('MODULE', [
            'content' => require 'html.php'
        ]);
    }

}
