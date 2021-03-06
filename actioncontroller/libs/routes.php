<?php
namespace ActionController;
class Routes{
    /*
     *
     * 路由解析
     *
     */
    static function parseUrl($path){
        $queryString = array();
        $pathInfo = explode('/', substr($path,1));
        $pathInfo = array_filter($pathInfo);
        $GLOBALS['control'] = $pathInfo[0];
        array_shift($pathInfo);
        $GLOBALS['action'] = (isset($pathInfo[0]) ? $pathInfo[0] : 'index');
        array_shift($pathInfo);
        self::parseQueryString($pathInfo);
    }
    /*
     *
     * 检查路由是否存在，检查传出参数是否合法
     * 如果合法实例化控制器
     *
     */
    static function parseQueryString(array$queryString){
        $GLOBALS['param'] = array();
        $urlRule = require APP_PATH.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'routes.php';
        $databases  = require APP_PATH.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'database.php';
        if (isset($urlRule[$GLOBALS['control']][$GLOBALS['action']])){
            foreach($queryString as $key=>$val){
                $pattern = '/^-?[a-zA-Z0-9_]+$/';
                if(preg_match($pattern, $val)){
                    array_push($GLOBALS['param'],$val);
                }
            };
            if(isset($databases)){
                define('DATABASE',$databases['development']['type'].'://'.$databases['development']['user'].':'.$databases['development']['password'].'@'.$databases['development']['host'].'/'.$databases['development']['database'].'?charset='.$databases['development']['charset']);
                \ActiveRecord\Config::initialize(function($cfg){
                        $cfg->set_model_directory(MODELS_PATH);
                        $cfg->set_connections(array(
                        'development' =>DATABASE));
                });
            }else{
                Error::handlingExceptions('database');
            };
            $controlClass = ucfirst($GLOBALS['control']).'Controller';
            $control = new $controlClass;
            $control -> $GLOBALS['action']();
        }else{
            Error::handlingExceptions(404);
        }
    }
}
?>
