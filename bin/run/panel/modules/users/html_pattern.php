<?php

return [
    'date' => '<span class="line-right size-11">{ T }</span><span class="size-13">{ D }</span>',
    'action'=>    '
            <table>
                <tr>
                    <td class="line-right"><p><a href="/users/delete' . EXT . '?user={ U }">{ D }</a></p></td>
                    <td><p><a href="/users/block' . EXT . '?user={ U }">{ B }</a></p></td>
                </tr>
            </table>',
    'tr' => '
        <tr>
            <td class="solid block size-12"><p>{ D }</p></td>
            <td class="solid bold"><p>|</p></td>
            <td class="solid block"><p>{ U }</p></td>
            <td class="solid bold"><p>:</p></td>
            <td class="solid block"><p>{ A }</p></td>
            <td class="solid bold"><p>:</p></td>
            <td class="solid block"><p>{ M }</p></td>
            <td class="solid bold"><p>:</p></td>
            <td class="solid block"><p>{ C }</p></td>
        </tr>'
];
