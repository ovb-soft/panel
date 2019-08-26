<?php

return '
<form action="' . REQUEST . '" method="post">
    <table id="table">
        <tr>
            <td class="th double-top"><p>' . LE['action'] . '</p></td>
            <td class="double double-top"><p>|</p></td>
            <td class="th double-top"><p>' . LE['user'] . '</p></td>
            <td class="double double-top"><p>|</p></td>
            <td class="th double-top"><p>' . LE['access'] . '</p></td>
            <td class="double double-top"><p>|</p></td>
            <td class="th double-top"><p>' . LE['mail'] . '</p></td>
            <td class="double double-top"><p>|</p></td>
            <td class="th double-top"><p>' . LE['created'] . '</p></td>
        </tr>' . HL['tr'] . '
        <tr>
            <td colspan="9"><div class="footer"></div></td>
        </tr>
    </table>
</form>';
