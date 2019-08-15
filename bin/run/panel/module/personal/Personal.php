<?php

namespace run\panel\module\personal;

class Personal {

    public function module()
    {
        return [
            'content' => require 'html.php'
        ];
    }

}
