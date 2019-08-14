<?php

return [
    'css' => '
        <link rel="stylesheet" href="/panel/default/' . PATH['exp'][0] . '.css">',
    'logo' => '<div class="logo"></div>',
    'a-logo' => '<a href="/main' . EXT . '"><div class="logo"></div></a>',
    'wg' => '<p class="input-warning">{ W }</p>',
    'id-error' => '
            <p id="id-error">{ E }</p>',
    'option' => '<option value="{ V }">{ O }</option>',
    'option-selected' => '<option value="{ V }" selected>{ O }</option>',
    'route' => [
        'div' => '
            <div id="route">{ R }
                <div class="clear"></div>
            </div>',
        'p' => '
                <p><span>&#187;</span>{ T }</p>',
        'p-red' => '
                <p><span>&#187;</span><span class="red">{ T }</span></p>',
        'a' => '
                <p><span>&#187;</span><a href="{ H }' . EXT . '">{ A }</a></p>'
    ]
];
