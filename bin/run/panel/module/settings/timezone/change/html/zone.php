<?php

return '
<form action="' . REQUEST . '" method="post">
    <table id="table">
        <tr>
            <td class="solid block"><p>' . LE['choose_zone'] . '</p></td>
            <td class="solid"><p>:</p></td>
            <td class="solid line"><p><select name="zone" size="1">' . HL['zone'] . '</select></p></td>
            <td class="solid line-right"><p><button type="submit" name="post">' . LE['choose'] . '</button></p></td>
        </tr>
        <tr>
            <td colspan="4"><div class="footer"></div></td>
        </tr>
    </table>
</form>';
