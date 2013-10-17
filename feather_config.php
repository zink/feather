<?php
//时区设置
date_default_timezone_set('UTC');

//应用文件根目录
define('APP_PATH',getcwd());

//视图文件路径;
define('VIEW_PATH',APP_PATH.DIRECTORY_SEPARATOR.'app'.DIRECTORY_SEPARATOR.'views'.DIRECTORY_SEPARATOR);

//layout根路径;
define('LAYOUT_PATH',APP_PATH.DIRECTORY_SEPARATOR.'app'.DIRECTORY_SEPARATOR.'views'.DIRECTORY_SEPARATOR.'layouts'.DIRECTORY_SEPARATOR);

//应用配置文件目录
define('CONFIG_PATH',APP_PATH.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'config.php');
?>
