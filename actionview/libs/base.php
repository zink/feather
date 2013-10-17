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
            $GLOBALS['env']['assetsPath'] = $this -> assetPath = CDN.DIRECTORY_SEPARATOR.'asset';
        }else{
            $GLOBALS['env']['assetPath'] = $this -> assetPath = $GLOBALS['env']['appRoot'].DIRECTORY_SEPARATOR.'app'.DIRECTORY_SEPARATOR.'asset';
        }
        \raintpl::configure("base_url", $GLOBALS['env']['baseURL'] );
        \raintpl::configure("asset_path", $GLOBALS['env']['assetPath'] );
        \raintpl::configure("tpl_dir", VIEW_PATH );
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
        
