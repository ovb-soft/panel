<?php

return [
    'div' => '
                <div class="right">
                    <ul class="hover">
                        <li>&#9660; { L }</li>
                        <li>
                        <form action="' . REQUEST . '" method="post">
                            <div>{ B }</div>
                        </form>
                        </li>
                    </ul>
                </div>',
    'button' => '<button type="submit" name="core:lang" value="{ V }"><img src="/panel/default/lang/20x13.{ L }.png">{ B }</button>',
    'hidden' => '<input type="hidden" name="{ N }">',
    'hidden-value' => '<input type="hidden" name="{ N }" value="{ V }">'
];
