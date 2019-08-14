<?php

const D = DIRECTORY_SEPARATOR;
const DOC = __DIR__ . D;
require DOC . '..' . D . 'bin' . D . 'autoload.php';
new run\App;
