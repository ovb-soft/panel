<?php

return '
<form action="' . REQUEST . '" method="post">
    <input type="hidden" name="zone" value="' . HL['zone'] . '">
    <table id="table">
        <tr>
            <td class="solid block"><p>' . LE['choose_time'] . '</p></td>
            <td class="solid"><p>:</p></td>
            <td class="solid line"><p><select name="timezone" size="1">' . HL['timezone'] . '</select></p></td>
        </tr>
        <tr>
            <td colspan="3"><p class="button"><button id="button" type="submit" name="post">' . LE['save-upp'] . '</button></p></td>
        </tr>
    </table>
</form>';
