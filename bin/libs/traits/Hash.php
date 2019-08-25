<?php

namespace traits;

trait Hash {

    private function hash(int $int)
    {
        return substr(str_shuffle(
                        'ABCDEFGHIJKLMNOPQRSTUVWXYZ' .
                        'abcdefghijklmnopqrstuvwxyz' .
                        '0123456789'
                ), 0, $int);
    }

}
