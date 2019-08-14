<?php

return '
<form action="' . REQUEST . '" method="post">
    <table id="table">
        <tr>
            <td class="td-solid"><p>' . LE['multilang'] . '</p></td>
            <td class="td-solid-vertical"><p>:</p></td>
            <td class="td-solid">
                <p class="radio">
                    <input type="radio" name="multilang" value="0"' . HL['yes'] . '><span>' . LE['yes'] . '</span>
                    <input type="radio" name="multilang" value="1"' . HL['no'] . '><span>' . LE['no'] . '</span>
                </p>
            </td>
        </tr>
        <tr>
            <td class="td-solid"><p>' . LE['lang'] . '</p></td>
            <td class="td-solid-vertical"><p>:</p></td>
            <td class="td-solid-select"><p><select name="lang" size="1">' . HL['lang'] . '</select></p></td>
        </tr>
        <tr>
            <td colspan="3"><div class="td-button"><button id="button" type="submit" name="post">' . LE['save-upp'] . '</button></div></td>
        </tr>
    </table>
</form>';
