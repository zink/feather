<?php
require_once(__DIR__.DIRECTORY_SEPARATOR.'feather_config.php');
class Kernel{
    static function routes(){
        if(!isset($_SERVER['PATH_INFO']) || $_SERVER['PATH_INFO'] == ''|| $_SERVER['PATH_INFO'] == '/'){
           $_SERVER['PATH_INFO'] = '/home/index';
        }
        //加载用户配置文件
        require_once(CONFIG_PATH.'config.php');
        //自动加载类函数
        require_once(__DIR__.DIRECTORY_SEPARATOR.'autoload.php');
        //加载字符串加密模块
        require_once(__DIR__.DIRECTORY_SEPARATOR.'encrypt'.DIRECTORY_SEPARATOR.'authcode.php');
        //加载ActionController
        require_once(__DIR__.DIRECTORY_SEPARATOR.'actioncontroller'.DIRECTORY_SEPARATOR.'ActionController.php');
        //加载ActionView
        require_once(__DIR__.DIRECTORY_SEPARATOR.'actionview'.DIRECTORY_SEPARATOR.'ActionView.php');
        //加载ActiveRecord
        require_once(__DIR__.DIRECTORY_SEPARATOR.'activerecord'.DIRECTORY_SEPARATOR.'ActiveRecord.php');
        ActionController\Routes::parseUrl($_SERVER['PATH_INFO']);
    }
}
?>
