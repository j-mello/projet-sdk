<?php


function autoloader($className)
{
    $class = "App/".explode("\\",$className)[count(explode("\\",$className))-1].".php";
    if(file_exists($class)){
        include $class;
    }
}

spl_autoload_register('autoloader');