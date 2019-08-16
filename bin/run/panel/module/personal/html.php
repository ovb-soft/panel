<?php

$DATE = HL['date']['day'] . '<b>.</b>' . HL['date']['month'] . '<b>.</b>' . HL['date']['year'];
$TIME = HL['time']['hour'] . '<b>:</b>' . HL['time']['minute'];

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
        <td colspan="3"><p class="footer"></p></td>
    </tr>
</table>';
