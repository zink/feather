<?php
function __load_class($class){
    $tick = substr($class,-10);
    switch($tick){
        case 'Controller':
            /*
             * 自动加载控制器
             */
            $class = explode('Controller',$class);
            $class = strtolower($class[0]).'_controller.php';
            $file = CONTROLLERS_PATH.$class;
            require_once $file;
        break;
        default:
            /*
               系统插件加载
             */
           $class = 'actioncontroller_class_'.strtolower($class).'.php';
           $file = PLUGINS_PATH.$class;
           require_once $file;
        break;
    };
}
spl_autoload_register('__load_class');
?>
