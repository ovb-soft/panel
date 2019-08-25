<?php

namespace run\panel\module\personal;

class Personal {

    private $_dir;

    public function module()
    {
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
        $user = filter_input(2, 'user');
        $data = unserialize(file_get_contents($this->_dir['user'] . $user . D . 'data.sz'));
        return [
            'mail' => $data['mail'],
            'user' => str_replace('^', ' ', $user),
            'created' => $this->_created($data['created'])
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
