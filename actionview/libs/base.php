<?php
namespace ActionView;
include "tpl.php";
class Base extends \RainTPL{
    //yield 用来标记layout内主内容位置
    private $contentDelimiter = 'yield'; //layout 主内容分隔符

    //@param:$assetPath:(private)静态文件定位目录。
    var $assetPath;
    function __construct(){
        if(CDN){
            $assetsRoot = CDN.DIRECTORY_SEPARATOR;
        }else{
            $assetsRoot = $GLOBALS['env']['appRoot'].DIRECTORY_SEPARATOR.'app'.DIRECTORY_SEPARATOR;
        }
        $GLOBALS['env']['assetsPath'] = $assetsRoot.ASSETS_PATH;
        $GLOBALS['env']['javascriptsPath'] = $assetsRoot.JAVASCRIPTS_PATH;
        $GLOBALS['env']['imagesPath'] = $assetsRoot.IMAGES_PATH;
        $GLOBALS['env']['stylesheetsPath'] = $assetsRoot.STYLESEETS_PATH;

        \raintpl::configure("base_url", $GLOBALS['env']['baseURL'] );
        //\raintpl::configure("assets_path", $GLOBALS['env']['assetsPath'] );
        \raintpl::configure("tpl_dir", VIEWS_PATH );
        \raintpl::configure("cache_dir", APP_PATH.DIRECTORY_SEPARATOR.CACHE_DIR.DIRECTORY_SEPARATOR."compiled/" );
    }
    function parse($viewData,$layout,$view){
        if($layout){
            $this -> output($viewData,$layout,$view);
        }else{
            $this -> output($viewData,$view);
        }
    }
    function output($viewData,$layout,$view=false){ 
        foreach($viewData as $key=>$value){
            $this->assign($key,$value);
        }
        if($view){
            $this -> assign('yield',$view);
        }
        $output = $this->draw($layout);
    }
}
?>
        
