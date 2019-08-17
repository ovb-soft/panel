<?php

namespace run\panel\module\personal;

class Personal extends \DateTime {

    private $_dir;

    public function module()
    {
        parent::setTimezone(new \DateTimeZone(TIMEZONE));
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
        return [
            'date' => $this->_hl_date($data['created'])
        ];
    }

    private function _hl_date($timestamp)
    {
        parent::setTimestamp($timestamp);
        $exp = explode(' ', parent::format('Y d m H i s'));
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
