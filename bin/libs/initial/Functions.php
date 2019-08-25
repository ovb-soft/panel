<?php

namespace initial;

trait Functions {

    protected $ext;

    private function slash()
    {
        header('Location: /');
        exit;
    }

    private function header()
    {
        header('Location: /main' . $this->ext);
        exit;
    }

}
