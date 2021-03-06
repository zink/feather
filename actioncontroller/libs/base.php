<?php
namespace ActionController;
abstract class Base{
    function __construct(){
        //spl_autoload_register(__NAMESPACE__.'\Base::__load_plugins');
        $webUrl = "http://".$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME'];
        if(REWRITE){
            $GLOBALS['env']['baseURL'] = str_replace('/index.php','',$webUrl);
        }else{
            $GLOBALS['env']['baseURL'] = $webUrl;
        }
        $GLOBALS['env']['appRoot'] = str_replace('/index.php','',$webUrl);
        if(CDN){
            $assetsRoot = CDN.DIRECTORY_SEPARATOR;
        }else{
            $assetsRoot = $GLOBALS['env']['appRoot'].DIRECTORY_SEPARATOR.'app'.DIRECTORY_SEPARATOR;
        }
        $GLOBALS['env']['assetsPath'] = $assetsRoot.ASSETS_PATH;
        $GLOBALS['env']['javascriptsPath'] = $assetsRoot.JAVASCRIPTS_PATH;
        $GLOBALS['env']['imagesPath'] = $assetsRoot.IMAGES_PATH;
        $GLOBALS['env']['stylesheetsPath'] = $assetsRoot.STYLESEETS_PATH;
        $this -> env = $GLOBALS['env'];
        $_GET['param'] = $GLOBALS['param'];
    }
    /*
       tell actionview to render views
       @param array(
                  layout=>[layout file],
                  view => [view file],
                  format=>[js,html]
              )
     */
     function render($args=array()){
        $controller_view_path = str_replace('controller','',strtolower(get_class($this)));
        if(file_exists(LAYOUTS_PATH.$controller_view_path.'.html')){
            $layout = $controller_view_path;
        }else{
            $layout = 'application';
        }
        $default = array(
                'format'=>'html',
                'layout'=>$layout,
                'view'=>$GLOBALS['action'],
                'return_string' =>false 
                );
        $args = array_merge($default,$args);
        switch($args['format']){
            case 'html':
                $viewFile = $controller_view_path.DIRECTORY_SEPARATOR.$args['view'];
                $actionView = new \ActionView\Base();
                $layoutFile = 'layouts/'.$args['layout'];
                $actionView -> assign('yield',$viewFile);
                $actionView->assign(get_object_vars($this));
                if($args['return_string']){
                    return $actionView->draw($layoutFile,$args['return_string']);
                }else{
                    $actionView->draw($layoutFile,$args['return_string']);
                }
            break;
            case 'js':
                $viewFile = $controller_view_path.DIRECTORY_SEPARATOR.$args['view'].'.ajax';
                $actionView = new \ActionView\Base();
                $actionView->assign(get_object_vars($this));
                if($args['return_string']){
                    return $actionView->draw($viewFile,$args['return_string']);
                }else{
                    $actionView->draw($viewFile,$args['return_string']);
                }
            break;
        }
    }
    public function redirect($path){
        $_SERVER['PATH_INFO'] = '/'.$path;
        header('Location: '.$GLOBALS['env']['baseURL'].'/'.$path);
    }
    public function modifier_cut($string, $length = 80, $etc = '...', $break_words = false, $middle = false){
        if ($length == 0)
            return '';

        if (isset($string{$length+1})) {

            $length -= min($length, strlen($etc));

            if (!$break_words && !$middle) {
                $string =  $this->utftrim(substr($string, 0, $length+1));
            }
            if(!$middle) {
                    return $this->utftrim(substr($string, 0, $length)) . $etc;
                } else {
                    return $this->utftrim(substr($string, 0, $length/2)) . $etc . $this->utftrim(substr($string, -$length/2));
                }
        } else {
            return $string;
        }
    }

    public function utftrim($str){
        $found = false;
        for($i=0;$i<4&&$i<strlen($str);$i++)
        {
            $ord = ord(substr($str,strlen($str)-$i-1,1));
            if($ord> 192)
            {

                $found = true;
                break;
            }
        }
        if($found)
        {
            if($ord>240)
            {
                if($i==3) return $str;
                else return substr($str,0,strlen($str)-$i-1);
            }
            elseif($ord>224)
            {
                if($i==2) return $str;
                else return substr($str,0,strlen($str)-$i-1);
            }
            else
            {
                if($i==1) return $str;
                else return substr($str,0,strlen($str)-$i-1);
            }
        }
        else return $str;
    }
}
?>
