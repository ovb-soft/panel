<?php

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
        <td colspan="3"><p class="colspan"><a href="/personal/edit' . EXT . '">' . LE['edit'] . '</a></p></td>
    </tr>
    <tr>
        <td class="solid block"><p>' . LE['created'] . '</p></td>
        <td class="solid bold"><p>:</p></td>
        <td class="solid line"><p><span class="line-right size-11">' . HL['time'] . '</span><span class="size-13">' . HL['date'] . '</span></p></td>
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
