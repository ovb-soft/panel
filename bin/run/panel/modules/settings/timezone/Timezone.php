<?php

namespace run\panel\modules\settings\timezone;

class Timezone {

    public function __construct()
    {
        define('MODULE', [
            'content' => require 'html.php'
        ]);
    }

}
