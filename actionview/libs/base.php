<?php
namespace ActionView;
include "tpl.php";
class Base extends \RainTPL{
    //yield 用来标记layout内主内容位置
    private $contentDelimiter = 'yield'; //layout 主内容分隔符
    function __construct(){
        \raintpl::configure("base_url", $GLOBALS['env']['baseURL'] );
        \raintpl::configure("tpl_dir", VIEWS_PATH );
        \raintpl::configure("cache_dir", APP_PATH.DIRECTORY_SEPARATOR.CACHE_DIR.DIRECTORY_SEPARATOR."compiled/" );
    }
}
?>
        
