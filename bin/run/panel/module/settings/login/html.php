<?php

return '
<form action="' . REQUEST . '" method="post">
    <table id="table">
        <tr>
            <td class="solid block"><p>' . LE['block'] . '</p></td>
            <td class="solid bold"><p>:</p></td>
            <td class="solid line"><p><select name="block" size="1">' . HL['block'] . '</select></p></td>
        </tr>
        <tr>
            <td class="solid block"><p>' . LE['timer'] . '</p></td>
            <td class="solid bold"><p>:</p></td>
            <td class="solid line"><p><select name="timer" size="1">' . HL['timer'] . '</select></p></td>
        </tr>
        <tr>
            <td colspan="3"><p class="button"><button id="button" type="submit" name="post">' . LE['save-upp'] . '</button></p></td>
        </tr>
    </table>
</form>';
