<?php

namespace run\panel\core\lang;

class Lang {

    public function __construct()
    {
        define('LANG', $this->_const_lang());
        define('LT', require 'lang' . D . LANG . '.php');
        define('LANGS', $this->_const_langs());
    }

    private function _const_lang()
    {
        $this->_lang = unserialize(file_get_contents(DATA . 'panel' . D . 'lang.sz'));
        $lang = $this->_lang['lang'];
        if ($this->_lang['multilang']) {
            return $lang;
        }
        if (filter_has_var(0, 'core:lang')) {
            $post = filter_input(0, 'core:lang');
            if (isset($this->_lang['langs'][$post])) {
                setcookie('lang', $post, strtotime('+ 1 year'), '/');
                $lang = $post;
            }
        } elseif (filter_has_var(2, 'lang')) {
            $cookie = filter_input(2, 'lang');
            !isset($this->_lang['langs'][$cookie]) ?: $lang = $cookie;
        }
        return $lang;
    }

    private function _const_langs()
    {
        if ($this->_lang['multilang']) {
            return '';
        }
        $button = '';
        foreach ($this->_lang['langs'] as $k => $v) {
            if ($k !== LANG) {
                $button .= str_replace(
                        ['{ V }', '{ L }', '{ B }'], [$k, $k, $v], HTML['langs']['button']
                );
            }
        }
        $search = ['{ L }', '{ B }'];
        $replace = [$this->_lang['langs'][LANG], $this->_const_langs_hidden() . $button];
        return str_replace($search, $replace, HTML['langs']['div']);
    }

    private function _const_langs_hidden()
    {
        $hidden = '';
        $post = filter_input_array(0);
        if ($post !== null) {
            foreach ($post as $k => $v) {
                if ($k === 'core:lang') {
                    continue;
                }
                $hidden .= ($k === 'login' or $k === 'post') ?
                        str_replace('{ N }', $k, HTML['langs']['hidden']) :
                        str_replace(['{ N }', '{ V }'], [$k, $v], HTML['langs']['hidden-value']);
            }
        }
        return $hidden;
    }

}
