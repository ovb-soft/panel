<?php

return '
<form action="' . REQUEST . '" method="post">
    <table id="table">
        <tr>
            <td class="solid line"><p><select name="status" size="1">' . STATUS . '</select></p></td>
            <td class="solid bold"><p>:</p></td>
            <td class="solid block"><p>' . LE['status'] . '</p></td>
        </tr>
    </table>
    <div id="block">
        <p class="name">' . LE['mail'] . '</p>
        <p class="input">
            <input type="text" name="mail" placeholder="' . LE['mail_ph'] . '" value="' . HL['mail'] . '">
        </p>' . HL['wg_mail'] . '
        <p class="name">' . LE['user'] . '</p>
        <p class="input">
            <input type="text" name="user" placeholder="' . LE['user_ph'] . '" value="' . HL['user'] . '">
        </p>' . HL['wg_user'] . '
        <p class="name">' . LE['pass'] . '</p>
        <p class="input">
            <input type="password" name="pass" placeholder="' . LE['pass_ph'] . '" value="' . HL['pass'] . '">
        </p>' . HL['wg_pass'] . '
        <p class="name">' . LE['confirm'] . '</p>
        <p class="input">
            <input type="password" name="confirm" placeholder="' . LE['confirm_ph'] . '" value="' . HL['confirm'] . '">
        </p>' . HL['wg_confirm'] . '
        <p class="button"><button id="button" type="submit" name="post">' . LE['create-upp'] . '</button></p>
    </div>
</form>';
