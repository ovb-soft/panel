<?php

namespace run\panel\core\login;

class Login {

    private $_hl = [
        'mail' => '',
        'pass' => '',
        'wg' => ''
    ];

    public function __construct()
    {
        define('LE_TMP', (require 'langs.php')[LANG]);
        $this->_hl['mail'] = filter_has_var(0, 'mail') ? trim(filter_input(0, 'mail')) : '';
        !AUTH['wg'] ?: $this->_warning();
        define('HL', $this->_hl);
        require 'template.php';
    }

    private function _warning()
    {
        $this->_hl['wg'] = $this->_switch();
    }

    private function _switch()
    {
        switch (AUTH['wg']) {
            case 1: $wg = LE_TMP['wg_incorrect'];
                break;
            case 2: $wg = LE_TMP['wg_blocked'];
                break;
            case 3: $wg = LE_TMP['wg_timeout'];
                break;
            case 4: $wg = LE_TMP['wg_server'];
                break;
            case 5: $wg = LE_TMP['wg_cookie'];
                break;
        }
        return isset($wg) ? str_replace('{ W }', $wg, HTML['wg']) : '';
    }

}
