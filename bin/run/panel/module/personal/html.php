<?php

$DATE = HL['date']['day'] . '<b>.</b>' . HL['date']['month'] . '<b>.</b>' . HL['date']['year'];
$TIME = HL['date']['hour'] . '<b>:</b>' . HL['date']['minute'];

return '
<table id="table">
    <tr>
        <td class="solid block"><p>' . LE['created'] . '</p></td>
        <td class="solid"><p>:</p></td>
        <td class="solid line"><p><span class="date">' . $DATE . '</span><span class="time">' . $TIME . '</span></p></td>
    </tr>
    <tr>
        <td class="solid block"><p>' . LE['password'] . '</p></td>
        <td class="solid"><p>:</p></td>
        <td class="solid line"><p><a href="/personal/password' . EXT . '">' . LE['change_password'] . '</a></p></td>
    </tr>
    <tr>
        <td colspan="3"><div class="footer"></div></td>
    </tr>
</table>';
