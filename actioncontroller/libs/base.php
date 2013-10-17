<?php
namespace ActionController;
abstract class Base{
    function __construct(){
        $webUrl = "http://".$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME'];
        $this -> http = new Httpclient();
        if(REWRITE){
            $GLOBALS['env']['baseURL'] = $this -> baseURL = str_replace('/index.php','',$webUrl);
        }else{
            $GLOBALS['env']['baseURL'] = $this -> baseURL = $webUrl;
        }
        $GLOBALS['env']['appRoot'] = $this -> appRoot = str_replace('/index.php','',$webUrl);
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
    public function render($args=array()){
        if(file_exists(LAYOUT_PATH.$GLOBALS['control'].'.html')){
            $layout = $GLOBALS['control'];
        }else{
            $layout = 'application';
        }
        $default = array(
                'format'=>'html',
                'layout'=>$layout,
                'view'=>$GLOBALS['action']
                );
        $args = array_merge($default,$args);
        switch($args['format']){
            case 'html':
                $viewFile = $GLOBALS['control'].DIRECTORY_SEPARATOR.$args['view'];
                $actionView = new \ActionView\Base();
                if($args['layout']){
                    $layoutFile = 'layouts/'.$args['layout'];
                }else{
                    $layoutFile = false;
                }
                $actionView -> parse(get_object_vars($this),$layoutFile,$viewFile);
            break;
            case 'js':
                $viewFile = $GLOBALS['control'].'/'.$args[view].'.ajax';
                $actionView = new \ActionView\Base();
                $actionView -> output(get_object_vars($this),$viewFile);
            break;
        }
    }
    public function redirect($path){
        $_SERVER['PATH_INFO'] = '/'.$path;
        header('Location: '.$this -> baseURL.'/'.$path);
        //\Kernel::routes();
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
