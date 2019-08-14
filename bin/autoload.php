<?php

spl_autoload_register(function($class) {
    require __DIR__ . D .
            (explode('\\', $class)[0] === 'run' ? '' : 'libs' . D) .
            str_replace('\\', D, $class) . '.php';
}, true);
