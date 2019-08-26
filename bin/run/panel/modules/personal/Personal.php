<?php

namespace run\panel\modules\personal;

class Personal extends \run\panel\core\corp\users\Users {

    public function __construct()
    {
        parent::__construct();
        define('HL', $this->_hl());
        define('MODULE', [
            'content' => require 'html.php'
        ]);
    }

    private function _hl()
    {
        return [
            'mail' => $this->mail,
            'user' => str_replace('^', ' ', $this->user),
            'created' => $this->_created(unserialize(file_get_contents(
                                    $this->dir['user'] . $this->user . D . 'data.sz'
                    ))['created'])
        ];
    }

    private function _created($created)
    {
        $date = new \DateTime(null, new \DateTimeZone(TIME_ZONE));
        $date->setTimestamp($created);
        $exp = explode(' ', $date->format('Y d m H i s'));
        return [
            'year' => $exp[0],
            'day' => $exp[1],
            'month' => $exp[2],
            'hour' => $exp[3],
            'minute' => $exp[4],
            'second' => $exp[5]
        ];
    }

}
