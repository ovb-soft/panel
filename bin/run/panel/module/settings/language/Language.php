<?php

namespace run\panel\module\settings\language;

class Language {

    private $_lang;

    public function module()
    {
        $this->_lang = unserialize(file_get_contents(DATA . 'panel' . D . 'lang.sz'));
        !filter_has_var(0, 'post') ?: $this->_post();
        define('HL', $this->_hl());
        return [
            'content' => require 'html.php'
        ];
    }

    private function _post()
    {
        $this->_lang['multilang'] = (bool) filter_input(0, 'multilang');
        $lang = filter_input(0, 'lang');
        $this->_lang['lang'] = isset($this->_lang['langs'][$lang]) ? $lang : $this->_lang['lang'];
        if (file_put_contents(DATA . 'panel' . D . 'lang.sz', serialize($this->_lang)) === false) {
            exit('Failed to write data to file.');
        }
        !$this->_lang['multilang'] ?: setcookie('lang', '', 0, '/');
        header('Location: /settings' . EXT);
        exit;
    }

    private function _hl()
    {
        $hl['yes'] = $this->_lang['multilang'] ? '' : ' checked';
        $hl['no'] = $this->_lang['multilang'] ? ' checked' : '';
        $hl['lang'] = '';
        foreach ($this->_lang['langs'] as $k => $v) {
            $hl['lang'] .= str_replace(['{ V }', '{ O }'], [$k, $v], HTML[
                    $k === $this->_lang['lang'] ? 'option-selected' : 'option'
            ]);
        }
        return $hl;
    }

}
