<?php
define('CONTROLLER_HELP',"
  - g controller [name]
      create a controller and add a route rule
      Examples:
          % - g controller user

          app/controllers/user_controller.php
          route.php
              |_ user => array(
                          'index' => array()
                      )
        ");
define('MODEL_HELP',"
  - g model [name]
      create a model
      Examples:
          % - g model user

          app/models/user.php
        ");
define('VIEW_HELP',"
  - g view [controller] [name]
      create a view
      Examples:
          % - g view user index

          app/views/user/index.html
        ");
define('SCAFFOLD_HELP',"
  - g scaffold [name]
      scaffold where help you to build a complete MVC and migrate 
      Examples:
          % - g scaffold user

          app/models/user.php
          app/controllers/user_controller.php
          app/views/user/index.html
          app/views/user/show.html
          app/views/user/edit.html
          db/migrations/yourdatabase/20130806095838_CreateUsersTable.php
          route.php
              |_ user => array(
                          'index' => array(),
                          'show' => array(),
                          'edit' => array(),
                          'create' => array()
                      )
        ");

class Generate{
    function __construct($argv){
        if(count($argv) == 0){
            $this -> throwMsg('error','miss arguments','no_argv');
            exit;
        }
        switch($argv[0]){
            case 'controller':
                if(isset($argv[1])){
                    $this -> createController($argv[1]);
                }else{
                    $this -> throwMsg('error','miss controller name!','no_clt_name');
                }
            break;
            case 'model':
                if(isset($argv[1])){
                    $this -> createModel($argv[1]);
                }else{
                    $this -> throwMsg('error','miss Model name!','no_mdl_name');
                }
            break;
            case 'view':
                if(isset($argv[1])){
                    if(isset($argv[2])){
                        $this -> createView($argv[1],$argv[2]);
                    }else{
                        $this -> createView($argv[1]);
                    }
                }else{
                    $this -> throwMsg('error','miss Model name!','no_view_name');
                }
            break;
            case 'scaffold':
                if(isset($argv[1])){
                    $this -> scaffold($argv[1]);
                }else{
                    $this -> throwMsg('error','miss name!','no_scaffold_name');
                }
            break;
        }
    }
    function createController($name){
        $tpl = $this -> get_tpl('controller');
        $tpl = str_replace('<%name%>',ucfirst($name),$tpl);
        $cltName = $name.'_controller.php';
        $cltFile = APP_PATH.DIRECTORY_SEPARATOR.'app'.DIRECTORY_SEPARATOR.'controllers'.DIRECTORY_SEPARATOR.$cltName;
        if(file_exists($cltFile)){
            $this -> throwMsg('error','Controller exists!',"controller file: $cltName exists!");
        }else{
            $return = file_put_contents($cltFile,$tpl);
            if($return){
                $this -> throwMsg('success','Controller created',$cltFile);
                $this -> createRoute($name);
            }else{
                $this -> throwMsg('error','Error','Can\'t create controller file');
            }
        }
    }
    function createModel($name){
        $tpl = $this -> get_tpl('model');
        $tpl = str_replace('<%name%>',ucfirst($name),$tpl);
        $mdName = $name.'.php';
        $mdFile = APP_PATH.DIRECTORY_SEPARATOR.'app'.DIRECTORY_SEPARATOR.'models'.DIRECTORY_SEPARATOR.$mdName;
        if(file_exists($mdFile)){
            $this -> throwMsg('error','Model exists!',"Model file: $mdName exists!");
        }else{
            $return = file_put_contents($mdFile,$tpl);
            if($return){
                $this -> throwMsg('success','Model created',$mdFile);
            }else{
                $this -> throwMsg('error','Error','Can\'t create model file');
            }
        }
    }
    function createView($controller,$name = 'index'){
        $tpl = $this -> get_tpl('view');
        $tpl = str_replace('<%name%>',$name,$tpl);
        $tpl = str_replace('<%controller%>',$controller,$tpl);
        $viName = $controller.DIRECTORY_SEPARATOR.$name.'.html';
        $viFile = APP_PATH.DIRECTORY_SEPARATOR.'app'.DIRECTORY_SEPARATOR.'views'.DIRECTORY_SEPARATOR.$viName;
        $viDir = APP_PATH.DIRECTORY_SEPARATOR.'app'.DIRECTORY_SEPARATOR.'views'.DIRECTORY_SEPARATOR.$controller;
        if(file_exists($viFile)){
            $this -> throwMsg('error','View exists!',"view file: $viName exists!");
        }else{
            if(!is_dir($viDir)){
                mkdir($viDir);
            }
            $return = file_put_contents($viFile,$tpl);
            if($return){
                $this -> throwMsg('success','View created',$viFile);
            }else{
                $this -> throwMsg('error','Error','Can\'t create view file');
            }
        }
    }
    function createRoute($name){
        $routeFile = APP_PATH.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'routes.php';
        $route = require_once($routeFile);
        if(isset($route[$name])){
            $this -> throwMsg('error','Route exists!','route: '.$name.' exists');
        }else{
            $oldRoute = file_get_contents($routeFile);
            $routeMatch = '/(<?[\s\S]*)(?:\)\;)/';
            preg_match($routeMatch,$oldRoute,$matchs);
            $check = preg_match('/(\,|,\s*)$/',$matchs[1]);
            if(!$check){
                $endRoute = $matchs[1].',';
            }else{
                $endRoute = $matchs[1];
            }
            $newRoute = "\n    '".$name."' => array(\n        'index' => array(),\n    ),\n);\n?>";
            $endRoute .= $newRoute;
            $return = file_put_contents($routeFile,$endRoute);
            if($return){
                $this -> throwMsg('success','Route created',$name."=> array(\n'index' => array()\n)");
            }else{
                $this -> throwMsg('error','Error','Can\'t create route');
            }
        }
    }
    function scaffold($name){
        $this->createController($name);
        $this->createModel($name);
        $this->createView($name);
    }
    function createHelp($name){
        //todo
    }
    function get_tpl($tpl){
        return file_get_contents(__DIR__.DIRECTORY_SEPARATOR.'templates'.DIRECTORY_SEPARATOR.$tpl.'.tpl');
    }
    function throwMsg($type,$title,$msg){
        $color = new Colors();
        switch ($type){
            case 'success':
                $title = $color->colored($title,'white','green');
            break;
            case 'error':
                $title = $color->colored($title,'white','red');
            break;
        }
        switch ($msg){
            case 'no_argv':
                echo $title.CONTROLLER_HELP.VIEW_HELP.MODEL_HELP.SCAFFOLD_HELP;
            break;
            case 'no_clt_name':
                echo $title.CONTROLLER_HELP;
            break;
            case 'no_mdl_name':
                echo $title.MODEL_HELP;
            break;
            case 'no_view_name':
                echo $title.VIEW_HELP;
            break;
            case 'no_scaffold_name':
                echo $title.SCAFFOLD_HELP;
            break;
            default:
                echo "$title\n    $msg\n";
            break;
        }
    }
}
?>
