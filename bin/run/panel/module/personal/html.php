<?php

return '
<form action="' . REQUEST . '" method="post" id="table">
    <table>
        <tr>
            <td class="solid block"><p>' . LE['password'] . '</p></td>
            <td class="solid"><p>:</p></td>
            <td class="solid line"><p><a href="/personal/password' . EXT . '">' . LE['change_password'] . '</a></p></td>
        </tr>
        <tr>
            <td colspan="3"><p class="footer"></p></td>
        </tr>
    </table>
</form>';
