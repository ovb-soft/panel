<?php

namespace run\panel\modules\personal\password;

class Password extends Save {

    protected $hl = [
        'pass' => '',
        'confirm' => ''
    ];
    protected $pass;
    private $_wg = [
        'wg_pass' => '',
        'wg_confirm' => ''
    ];

    public function __construct()
    {
        parent::__construct();
        !$this->post ?: $this->_hl_empty($this->hl = $this->post);
        define('HL', $this->hl + $this->_wg);
        define('MODULE', [
            'content' => require 'html.php'
        ]);
    }

    private function _hl_empty()
    {
        $hl = true;
        foreach ($this->hl as $v) {
            empty($v) ?: $hl = false;
        }
        $hl ?: $this->_pass();
    }

    private function _pass()
    {
        if ($this->hl['pass']) {
            $this->dir['mail'] .= unserialize(file_get_contents(
                                    $this->dir['user'] . $this->user . D . 'data.sz'
                    ))['mail'] . D;
            $this->pass = unserialize(file_get_contents($this->dir['mail'] . 'pass.sz'));
            if (!preg_match("'^[a-z0-9]{4,32}$'i", $this->hl['pass'])) {
                $this->_pass_match();
            } elseif (password_verify($this->hl['pass'], $this->pass['pass'])) {
                $this->_pass_verify();
            } elseif ($this->hl['pass'] !== $this->hl['confirm']) {
                $this->_pass_confirm();
            }
            $this->_wg_empty();
        } else {
            $this->_hl();
        }
    }

    private function _pass_match()
    {
        $this->_wg['wg_pass'] = str_replace('{ W }', WG['wg_pass'], HTML['wg']);
        $this->_hl();
    }

    private function _pass_verify()
    {
        $this->_wg['wg_pass'] = str_replace('{ W }', WG['wg_pass_old'], HTML['wg']);
        $this->_hl();
    }

    private function _pass_confirm()
    {
        if ($this->hl['confirm']) {
            $this->hl['confirm'] = '';
            $this->_wg['wg_confirm'] = str_replace('{ W }', WG['wg_pass_not_match'], HTML['wg']);
        } else {
            $this->_wg['wg_confirm'] = str_replace(
                    '{ W }', WG['wg_pass_enter_confirm'], HTML['wg']
            );
        }
    }

    private function _hl()
    {
        $this->hl = [
            'pass' => '',
            'confirm' => ''
        ];
    }

    private function _wg_empty()
    {
        $wg = false;
        foreach ($this->_wg as $v) {
            empty($v) ?: $wg = true;
        }
        $wg ?: $this->save();
    }

}
