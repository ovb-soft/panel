<?php

namespace run\panel\module\settings\timezone\change;

class Change {

    private $_app;
    private $_region;

    public function module()
    {
        $this->_app = unserialize(file_get_contents(DATA . 'app.sz'));
        return [
            'content' => filter_has_var(0, 'post') ? $this->_post() : $this->_region()
        ];
    }

    private function _post()
    {
        $this->_region = filter_input(0, 'region');
        if (isset(LE['region'][$this->_region])) {
            if (filter_has_var(0, 'time_zone')) {
                $this->_app();
            } else {
                return $this->_time_zone();
            }
        } else {
            exit('Is no such zone.');
        }
    }

    private function _app()
    {
        $time = filter_input(0, 'time_zone');
        if (in_array($time, require $this->_region . '.php')) {
            $this->_app['region'] = $this->_region;
            $this->_app['time_zone'] = $time;
            if (file_put_contents(DATA . 'app.sz', serialize($this->_app)) === false) {
                exit('Failed to write data to file.');
            }
            $this->_header();
        } else {
            exit('Is no such time zone.');
        }
    }

    private function _header()
    {
        header('Location: /settings' . EXT);
        exit;
    }

    private function _time_zone()
    {
        $hl = [
            'region' => $this->_region,
            'time_zone' => ''
        ];
        foreach (require $this->_region . '.php' as $v) {
            $hl['time_zone'] .= str_replace(['{ V }', '{ O }'], [$v, $v], HTML[
                    $v === $this->_app['time_zone'] ? 'option-selected' : 'option'
            ]);
        }
        define('HL', $hl);
        return require 'html_time_zone.php';
    }

    private function _region()
    {
        $hl['region'] = '';
        foreach (LE['region'] as $k => $v) {
            $hl['region'] .= str_replace(['{ V }', '{ O }'], [$k, $v], HTML[
                    $k === $this->_app['region'] ? 'option-selected' : 'option'
            ]);
        }
        define('HL', $hl);
        return require 'html_region.php';
    }

}
