<?php

$DATE = HL['created']['day'] . '<b>.</b>' . HL['created']['month'] . '<b>.</b>' . HL['created']['year'];
$TIME = HL['created']['hour'] . '<b>:</b>' . HL['created']['minute'];

return '
<table id="table">
    <tr>
        <td class="solid block"><p>' . LE['created'] . '</p></td>
        <td class="solid bold"><p>:</p></td>
        <td class="solid line"><p><span class="date">' . $DATE . '</span><span class="time">' . $TIME . '</span></p></td>
    </tr>
    <tr>
        <td class="solid block"><p>' . LE['password'] . '</p></td>
        <td class="solid bold"><p>:</p></td>
        <td class="solid line"><p><a href="/personal/password' . EXT . '">' . LE['change_password'] . '</a></p></td>
    </tr>
    <tr>
        <td colspan="3"><div class="footer"></div></td>
    </tr>
</table>';
