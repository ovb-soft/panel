<?php

return '
<form action="' . REQUEST . '" method="post">
    <input type="hidden" name="region" value="' . HL['region'] . '">
    <table id="table">
        <tr>
            <td class="solid block"><p>' . LE['choose_time'] . '</p></td>
            <td class="solid bold"><p>:</p></td>
            <td class="solid line"><p><select name="time_zone" size="1">' . HL['time_zone'] . '</select></p></td>
        </tr>
        <tr>
            <td colspan="3"><p class="button"><button id="button" type="submit" name="post">' . LE['save-upp'] . '</button></p></td>
        </tr>
    </table>
</form>';
