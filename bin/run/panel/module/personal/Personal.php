<?php

namespace run\panel\module\personal;

class Personal extends \DateTime {

    private $_dir;

    public function module()
    {
        parent::setTimezone(new \DateTimeZone('-02:00'));
        $this->_dir = [
            'mail' => DATA . 'panel' . D . 'auth' . D . 'mail' . D,
            'user' => DATA . 'panel' . D . 'auth' . D . 'user' . D
        ];
        define('HL', $this->_hl());
        return [
            'content' => require 'html.php'
        ];
    }

    private function _hl()
    {
        $data = $this->_pass = unserialize(file_get_contents(
                        $this->_dir['user'] . filter_input(2, 'user') . D . 'data.sz'
        ));
        $date = $this->_hl_date($data['created']);
        return [
            'date' => $date['date'],
            'time' => $date['time']
        ];
    }

    private function _hl_date($timestamp)
    {
        parent::setTimezone(new \DateTimeZone('Europe/Moscow'));
        parent::setTimestamp($timestamp);
        $ts = explode(' ', parent::format('d.m.Y H:i'));
        $d = explode('.', $ts[0]);
        $t = explode(':', $ts[1]);
        return [
            'date' => [
                'day' => $d[0],
                'month' => $d[1],
                'year' => $d[2]
            ],
            'time' => [
                'hour' => $t[0],
                'minute' => $t[1]
            ]
        ];
    }

}
