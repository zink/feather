<?php
//时区设置
date_default_timezone_set('UTC');

//app root path
define('APP_PATH',getcwd());

//views path;
define('VIEWS_PATH',APP_PATH.DIRECTORY_SEPARATOR.'app'.DIRECTORY_SEPARATOR.'views'.DIRECTORY_SEPARATOR);

//layouts path;
define('LAYOUTS_PATH',VIEWS_PATH.'layouts'.DIRECTORY_SEPARATOR);

//controllers path;
define('CONTROLLERS_PATH',APP_PATH.DIRECTORY_SEPARATOR.'app'.DIRECTORY_SEPARATOR.'controllers'.DIRECTORY_SEPARATOR);

//models path;
define('MODELS_PATH',APP_PATH.DIRECTORY_SEPARATOR.'app'.DIRECTORY_SEPARATOR.'models'.DIRECTORY_SEPARATOR);

/*
   assets path
   @warning when template compiling feather will replace all relative paths of assets
 */;
define('ASSETS_PATH','assets');
//javascripts path;
define('JAVASCRIPTS_PATH',ASSETS_PATH.DIRECTORY_SEPARATOR.'javascripts');
//images path;
define('IMAGES_PATH',ASSETS_PATH.DIRECTORY_SEPARATOR.'images');
//stylesheet path;
define('STYLESEETS_PATH',ASSETS_PATH.DIRECTORY_SEPARATOR.'stylesheets');


//app config path
define('CONFIG_PATH',APP_PATH.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR);

//app public path
define('PUBLIC_PATH',APP_PATH.DIRECTORY_SEPARATOR.'public'.DIRECTORY_SEPARATOR);

//default cache path
define('DEFAULT_CACHE_PATH',APP_PATH.DIRECTORY_SEPARATOR.'data'.DIRECTORY_SEPARATOR);

//plugins path
define('PLUGINS_PATH',__DIR__.DIRECTORY_SEPARATOR.'plugins'.DIRECTORY_SEPARATOR);
?>
