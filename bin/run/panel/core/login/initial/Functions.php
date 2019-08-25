<?php

namespace run\panel\core\login\initial;

trait Functions {

    private function slash()
    {
        header('Location: /');
        exit;
    }

    private function hash(int $int)
    {
        return substr(str_shuffle(
                        'ABCDEFGHIJKLMNOPQRSTUVWXYZ' .
                        'abcdefghijklmnopqrstuvwxyz' .
                        '0123456789'
                ), 0, $int);
    }

    private function header($ext)
    {
        header('Location: /main' . $ext);
        exit;
    }

}
