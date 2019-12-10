<?php

function loadEntities($class_name)
{
    $file_name = $class_name . '.php';
    if (file_exists($file_name))
    {
        include $file_name;
    }
}

spl_autoload_register('loadEntities');
