<?php

namespace run\panel\modules\personal;

class Personal {

    public function __construct()
    {
        define('HL', $this->_hl());
        define('MODULE', [
            'content' => require 'html.php'
        ]);
    }

    private function _hl()
    {
        return [
            'mail' => AUTH['mail'],
            'user' => str_replace('~', ' ', filter_input(2, 'user'))
                ] + $this->_created();
    }

    private function _created()
    {
        $date = new \DateTime(null, new \DateTimeZone(TIME_ZONE));
        $date->setTimestamp(AUTH['created']);
        $d = explode(' ', $date->format('Y d m H i'));
        return [
            'time' => $d[3] . ':' . $d[4],
            'date' => $d[1] . '.' . $d[2] . '.' . $d[0]
        ];
    }

}
