<?php

return '
<form action="' . REQUEST . '" method="post">
    <div id="block">
        <p class="name">' . LE['new_pass'] . '</p>
        <p class="input">
            <input type="password" name="new_pass" placeholder="' . LE['new_pass_ph'] . '" value="' . HL['new_pass'] . '">
        </p>' . HL['wg_new_pass'] . '
        <p class="name">' . LE['confirm'] . '</p>
        <p class="input">
            <input type="password" name="confirm" placeholder="' . LE['confirm_ph'] . '" value="' . HL['confirm'] . '">
        </p>' . HL['wg_confirm'] . '
        <p class="button"><button id="button" type="submit" name="post">' . LE['save-upp'] . '</button></p>
    </div>
</form>';
