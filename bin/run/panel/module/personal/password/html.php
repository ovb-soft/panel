<?php

return '
<form action="' . REQUEST . '" method="post">
    <div id="block">
        <p class="name">' . LE['pass'] . '</p>
        <p class="input">
            <input type="password" name="pass" placeholder="' . LE['pass_ph'] . '" value="' . HL['pass'] . '">
        </p>' . HL['wg_pass'] . '
        <p class="name">' . LE['confirm'] . '</p>
        <p class="input">
            <input type="password" name="confirm" placeholder="' . LE['confirm_ph'] . '" value="' . HL['confirm'] . '">
        </p>' . HL['wg_confirm'] . '
        <p class="button"><button id="button" type="submit" name="post">' . LE['save-upp'] . '</button></p>
    </div>
</form>';
