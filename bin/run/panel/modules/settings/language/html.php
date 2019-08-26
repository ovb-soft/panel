<?php

return '
<form action="' . REQUEST . '" method="post">
    <table id="table">
        <tr>
            <td class="solid block"><p>' . LE['multilang'] . '</p></td>
            <td class="solid bold"><p>:</p></td>
            <td class="solid line">
                <p class="radio">
                    <input type="radio" name="multilang" value="0"' . HL['yes'] . '><span>' . LE['yes'] . '</span>
                    <input type="radio" name="multilang" value="1"' . HL['no'] . '><span>' . LE['no'] . '</span>
                </p>
            </td>
        </tr>
        <tr>
            <td class="solid block"><p>' . LE['lang'] . '</p></td>
            <td class="solid bold"><p>:</p></td>
            <td class="solid line"><p><select name="lang" size="1">' . HL['lang'] . '</select></p></td>
        </tr>
        <tr>
            <td colspan="3"><p class="button"><button id="button" type="submit" name="post">' . LE['save-upp'] . '</button></p></td>
        </tr>
    </table>
</form>';
