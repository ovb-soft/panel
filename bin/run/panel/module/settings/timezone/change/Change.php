<?php

namespace run\panel\module\settings\timezone\change;

class Change {

    private $_app;
    private $_zone;

    public function module()
    {
        $this->_app = unserialize(file_get_contents(DATA . 'app.sz'));
        return [
            'content' => filter_has_var(0, 'post') ? $this->_post() : $this->_zone()
        ];
    }

    private function _post()
    {
        $this->_zone = filter_input(0, 'zone');
        if (isset(LE['zone'][$this->_zone])) {
            if (filter_has_var(0, 'timezone')) {
                $this->_app();
            } else {
                return $this->_timezone();
            }
        } else {
            header('Location: /settings/timezone/change' . EXT);
            exit;
        }
    }

    private function _app()
    {
        $timezone = filter_input(0, 'timezone');
        if (in_array($timezone, require $this->_zone . '.php')) {
            $this->_app['zone'] = $this->_zone;
            $this->_app['timezone'] = $timezone;
            if (file_put_contents(DATA . 'app.sz', serialize($this->_app)) === false) {
                exit('Failed to write data to file.');
            }
        }
        header('Location: /settings/timezone' . EXT);
        exit;
    }

    private function _timezone()
    {
        $hl = [
            'zone' => $this->_zone,
            'timezone' => ''
        ];
        foreach (require $this->_zone . '.php' as $v) {
            $hl['timezone'] .= str_replace(['{ V }', '{ O }'], [$v, $v], HTML[
                    $v === $this->_app['timezone'] ? 'option-selected' : 'option'
            ]);
        }
        define('HL', $hl);
        return require 'html' . D . 'timezone.php';
    }

    private function _zone()
    {
        $hl['zone'] = '';
        foreach (LE['zone'] as $k => $v) {
            $hl['zone'] .= str_replace(['{ V }', '{ O }'], [$k, $v], HTML[
                    $k === $this->_app['zone'] ? 'option-selected' : 'option'
            ]);
        }
        define('HL', $hl);
        return require 'html' . D . 'zone.php';
    }

}
