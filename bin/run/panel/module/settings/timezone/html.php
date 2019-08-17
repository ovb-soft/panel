<?php

return '
<table id="table">
    <tr>
        <td class="solid block"><p>' . LE['timezone'] . '</p></td>
        <td class="solid"><p>:</p></td>
        <td class="solid line"><p>' . HL['timezone'] . '</p></td>
        <td class="solid line-right"><p><a href="/settings/timezone/change' . EXT . '">' . LE['change'] . '</a></p></td>
    </tr>
    <tr>
        <td colspan="4"><div class="footer"></div></td>
    </tr>
</table>';
