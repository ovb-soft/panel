<?php

namespace run\panel\modules\users;

class Users {

    private $_append = '';
    private $_list;
    private $_html;

    public function __construct()
    {
        !file_exists(USER['auth'] . 'data') ?: $this->_list();
        define('MODULE', [
            'content' => MENU . $this->_append
        ]);
    }

    private function _list()
    {
        $this->_list = [
            'access' => unserialize(file_get_contents(USER['auth'] . 'data' . D . 'access.sz')),
            'date' => unserialize(file_get_contents(USER['auth'] . 'data' . D . 'date.sz')),
            'mail' => unserialize(file_get_contents(USER['auth'] . 'data' . D . 'mail.sz'))
        ];
        $this->_html = require 'html_pattern.php';
        define('HL', $this->_hl());
        $this->_append = require 'html.php';
    }

    private function _hl()
    {
        $tr = '';
        foreach ($this->_list['access'] as $k => $v) {
            $r = [
                $this->_action($k),
                str_replace('~', ' ', $k),
                $v,
                $this->_list['mail'][$k],
                str_replace(['{ T }', '{ D }'], $this->_created($k), $this->_html['date'])
            ];
            $tr .= str_replace(
                    ['{ D }', '{ U }', '{ A }', '{ M }', '{ C }'], $r, $this->_html['tr']
            );
        }
        return [
            'tr' => $tr
        ];
    }

    private function _action($k)
    {
        $s = ['{ U }', '{ D }', '{ B }'];
        $r = [$k, LE['delete'], LE['block']];
        return str_replace($s, $r, $this->_html['action']);
    }

    private function _created($k)
    {
        $date = new \DateTime(null, new \DateTimeZone(TIME_ZONE));
        $date->setTimestamp($this->_list['date'][$k]);
        $d = explode(' ', $date->format('Y d m H i'));
        return [
            'time' => $d[3] . ':' . $d[4],
            'date' => $d[1] . '.' . $d[2] . '.' . $d[0]
        ];
    }

}
