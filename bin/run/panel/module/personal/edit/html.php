<?php

return '
<form action="' . REQUEST . '" method="post">
    <div id="block">
        <p class="name">' . LE['mail'] . '</p>
        <p class="input">
            <input type="text" name="mail" placeholder="' . LE['mail_ph'] . '" value="' . HL['mail'] . '">
        </p>' . HL['wg_mail'] . '
        <p class="name">' . LE['user'] . '</p>
        <p class="input">
            <input type="text" name="user" placeholder="' . LE['user_ph'] . '" value="' . HL['user'] . '">
        </p>' . HL['wg_user'] . '
        <p class="button"><button id="button" type="submit" name="post">' . LE['save-upp'] . '</button></p>
    </div>
</form>';
