<?php

echo '<!DOCTYPE html>
<html lang="' . LANG . '">
    <head>
        <meta charset="utf-8">
        <meta name="google" content="notranslate">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>' . LE_TMP['title'] . '</title>
        <link rel="icon" href="/panel/default/favicon.ico">
        <link rel="stylesheet" href="/panel/default/style.css">
        <style>
            @media(min-width: 480px){
                .container{
                    width: 456px;
                }
            }
        </style>
    </head>
    <body>
        <div id="header">
            <div class="container">
                <div class="left"><div class="logo"></div></div>' . LANGS . '
                <div class="clear"></div>
            </div>
        </div>
        <div class="container">
            <div id="route">
                <p><span>&#187;</span>' . LE_TMP['route'] . '</p>
                <div class="clear"></div>
            </div>
            <form action="' . REQUEST . '" method="post">
                <p class="name">' . LE_TMP['mail'] . '</p>
                <p class="input">
                    <input type="text" name="mail" placeholder="' . LE_TMP['mail_ph'] . '" value="' . HL['mail'] . '">
                </p>' . HL['wg_mail'] . '
                <p class="name">' . LE_TMP['user'] . '</p>
                <p class="input">
                    <input type="text" name="user" placeholder="' . LE_TMP['user_ph'] . '" value="' . HL['user'] . '">
                </p>' . HL['wg_user'] . '
                <p class="name">' . LE_TMP['pass'] . '</p>
                <p class="input">
                    <input type="password" name="pass" placeholder="' . LE_TMP['pass_ph'] . '" value="' . HL['pass'] . '">
                </p>' . HL['wg_pass'] . '
                <p class="name">' . LE_TMP['confirm'] . '</p>
                <p class="input">
                    <input type="password" name="confirm" placeholder="' . LE_TMP['confirm_ph'] . '" value="' . HL['confirm'] . '">
                </p>' . HL['wg_confirm'] . '
                <div class="button button-double">
                    <p><button id="button" type="submit" name="post">' . LE_TMP['create-upp'] . '</button></p>
                </div>
            </form>
        </div>
    </body>
</html>';
