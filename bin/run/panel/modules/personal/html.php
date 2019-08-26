<?php

$date = HL['created']['day'] . '<b>.</b>' . HL['created']['month'] . '<b>.</b>' . HL['created']['year'];
$time = HL['created']['hour'] . '<b>:</b>' . HL['created']['minute'];

return '
<table id="table">
    <tr>
        <td class="solid block"><p>' . LE['mail'] . '</p></td>
        <td class="solid bold"><p>:</p></td>
        <td class="solid line"><p>' . HL['mail'] . '</p></td>
    </tr>
    <tr>
        <td class="solid block"><p>' . LE['user'] . '</p></td>
        <td class="solid bold"><p>:</p></td>
        <td class="solid line"><p>' . HL['user'] . '</p></td>
    </tr>
    <tr>
        <td colspan="3"><p class="double"><a href="/personal/edit' . EXT . '">' . LE['edit'] . '</a></p></td>
    </tr>
    <tr>
        <td class="solid block"><p>' . LE['created'] . '</p></td>
        <td class="solid bold"><p>:</p></td>
        <td class="solid line"><p><span class="date">' . $date . '</span><span class="time">' . $time . '</span></p></td>
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
