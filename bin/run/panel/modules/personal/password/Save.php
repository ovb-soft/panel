<?php

namespace run\panel\modules\personal\password;

class Save extends \run\panel\core\corp\users\Users {

    public function __construct()
    {
        parent::__construct();
    }

    protected function save()
    {
        $this->pass['pass'] = password_hash($this->hl['pass'], PASSWORD_DEFAULT);
        if (file_put_contents($this->dir['mail'] . 'pass.sz', serialize($this->pass)) === false) {
            exit('Failed to write data to file.');
        }
        $this->header();
    }

    protected function header()
    {
        header('Location: /personal' . EXT);
        exit;
    }

}
