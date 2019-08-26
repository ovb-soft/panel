<?php

echo '<!DOCTYPE html>
<html lang="' . LANG . '">
    <head>
        <meta charset="utf-8">
        <meta name="google" content="notranslate">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>' . LT['title'] . TITLE . '</title>
        <link rel="icon" href="/panel/default/favicon.ico">
        <link rel="stylesheet" href="/panel/icon/font.css">
        <link rel="stylesheet" href="/panel/default/style.css">' . HEAD . '
    </head>
    <body>
        <div id="header">
            <div class="container">
                <div class="left">' . LOGO . '</div>
                <div class="right"><a href="/logout' . EXT . '"><i class="icon-logout"></i>' . LT['sign_out-upp'] . '</a></div>' . LANGS . '
                <div class="right"><a href="/personal' . EXT . '"><i class="icon-dot-3"></i><i class="icon-user"></i></a></div>
                <div class="clear"></div>
            </div>
        </div>
        <div class="container">' . ROUTE . CONTENT . '
        </div>
    </body>
</html>';
