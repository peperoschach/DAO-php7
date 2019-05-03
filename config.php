<?php
spl_autoload_register(function ($nameClass) {

    $dirClass = 'class';
    $fileName = $dirClass . DIRECTORY_SEPARATOR . $nameClass . '.php';

    $fileName = str_replace((DIRECTORY_SEPARATOR === '/' ? '\\' : '/'), DIRECTORY_SEPARATOR, $fileName);
    if (file_exists($fileName)) {
        require_once($fileName);
    }
});
