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
define('ASSETS_PATH','assets'.DIRECTORY_SEPARATOR);
//javascripts path;
define('JAVASCRIPTS_PATH',ASSETS_PATH.'javascripts'.DIRECTORY_SEPARATOR);
//images path;
define('IMAGES_PATH',ASSETS_PATH.'images'.DIRECTORY_SEPARATOR);
//stylesheet path;
define('STYLESEETS_PATH',ASSETS_PATH.'stylesheets'.DIRECTORY_SEPARATOR);


//app config path
define('CONFIG_PATH',APP_PATH.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR);

//app public path
define('PUBLIC_PATH',APP_PATH.DIRECTORY_SEPARATOR.'public'.DIRECTORY_SEPARATOR);
?>
