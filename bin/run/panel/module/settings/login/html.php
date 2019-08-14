<?php

return '
<form action="' . REQUEST . '" method="post">
    <table id="table">
        <tr>
            <td class="td-solid"><p>' . LE['block'] . '</p></td>
            <td class="td-v-solid"><p>:</p></td>
            <td class="td-solid-select"><p><select name="block" size="1">' . HL['block'] . '</select></p></td>
        </tr>
        <tr>
            <td class="td-solid"><p>' . LE['timer'] . '</p></td>
            <td class="td-v-solid"><p>:</p></td>
            <td class="td-solid-select"><p><select name="timer" size="1">' . HL['timer'] . '</select></p></td>
        </tr>
        <tr>
            <td colspan="3"><div class="td-button"><button id="button" type="submit" name="post">' . LE['save-upp'] . '</button></div></td>
        </tr>
    </table>
</form>';
