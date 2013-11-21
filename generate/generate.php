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
            case 'init':
                $this -> initApp();
            break;
        }
    }
    function initApp(){
        $appDir = APP_PATH.DIRECTORY_SEPARATOR.'app'.DIRECTORY_SEPARATOR;
        /*
           make app dir
         */

        mkdir($appDir);

        /*
           make views dir
         */

        mkdir(VIEWS_PATH);


        /*
           make controllers dir
         */

        mkdir(CONTROLLERS_PATH);


        /*
           make models dir
         */

        mkdir(MODELS_PATH);


        /*
           make layouts dir
         */
        mkdir(LAYOUTS_PATH);


        /*
           make assets dir
         */

        mkdir($appDir.ASSETS_PATH);

        /*
           make javascripts dir
         */

        mkdir($appDir.JAVASCRIPTS_PATH);

        /*
           make images dir
         */

        mkdir($appDir.IMAGES_PATH);

        /*
           make stylesheets dir
         */

        mkdir($appDir.STYLESEETS_PATH);

        /*
           make cache dir
         */

        mkdir(DEFAULT_CACHE_PATH);
        mkdir(DEFAULT_CACHE_PATH.'cache');
        mkdir(DEFAULT_CACHE_PATH.'compiled');

        /*
           make config dir and config files
         */

        $this -> createConfig();

        /*
           make rack files
         */

        $this -> createRack();

        /*
           make public dir
         */

        $this -> createPublic();

        /*
           make app index files 
         */

        $this -> createIndex();

        /*
           make data files 
         */

        $this -> createData();

        /*
           make app files 
         */

        $this -> scaffold('home');
    }
    function createData(){
    }
    function createIndex(){
        $index = APP_PATH.DIRECTORY_SEPARATOR.'index.php';
        $tpl = $this -> getTpl('index');
        $return = file_put_contents($index,$tpl);
        if($return){
            $this -> throwMsg('success','index file created',$index);
        }else{
            $this -> throwMsg('error','Error','Can\'t create index file');
        }
    }
    function createPublic(){
        mkdir(PUBLIC_PATH);
        $_404File = PUBLIC_PATH.'404.html';
        $_404tpl = $this->getTpl('404');
        $_404Return = file_put_contents($_404File,$_404tpl);
        if($_404Return){
            $this -> throwMsg('success','404 file created',$_404File);
        }else{
            $this -> throwMsg('error','Error','Can\'t create 404 file');
        }
    }
    function createRack(){
        $racktpl = $this->getTpl('rack');
        $rackFile = APP_PATH.DIRECTORY_SEPARATOR.'rack';
        $return = file_put_content($rackFile,$racktpl);
        if($return){
            $this -> throwMsg('success','Rack file created',$rackFile);
        }else{
            $this -> throwMsg('error','Error','Can\'t create rack file');
        }
    }
    function createConfig(){
        mkdir(CONFIG_PATH);
        $configFile = CONFIG_PATH.'config.php';
        $dbFile = CONFIG_PATH.'database.php';
        $configtpl = $this->getTpl('config');
        $dbtpl = $this->getTpl('database');
        $configReturn = file_put_contents($configFile,$configtpl);
        if($configReturn){
            $this -> throwMsg('success','Config file created',$configFile);
        }else{
            $this -> throwMsg('error','Error','Can\'t create config file');
        }
        $dbReturn = file_put_contents($dbFile,$dbtpl);
        if($dbReturn){
            $this -> throwMsg('success','Database config file created',$dbFile);
        }else{
            $this -> throwMsg('error','Error','Can\'t create database config file');
        }
    }
    function createController($name){
        $appliction = CONTROLLERS_PATH.'application_controller.php';
        if(!file_exists($appliction)){
            $app = $this -> getTpl('application_controller');
            $app = str_replace('<{name}>',$name,$app);
            $appReturn = file_put_contents($appliction,$app);
            if($appReturn){
                $this -> throwMsg('success','appliction controller created',$appliction);
            }else{
                $this -> throwMsg('error','Error','Can\'t create appliction controller file');
            }
        }
        $tpl = $this -> getTpl('controller');
        $tpl = str_replace('<{name}>',ucfirst($name),$tpl);
        $cltName = $name.'_controller.php';
        $cltFile = CONTROLLERS_PATH.$cltName;
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
        $tpl = $this -> getTpl('model');
        $tpl = str_replace('<{name}>',ucfirst($name),$tpl);
        $mdName = $name.'.php';
        $mdFile = MODELS_PATH.$mdName;
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
        $appliction = LAYOUTS_PATH.'application.html';
        if(!file_exists($appliction)){
            $app = $this -> getTpl('application_view');
            $appReturn = file_put_contents($appliction,$app);
            if($appReturn){
                $this -> throwMsg('success','appliction view created',$appliction);
            }else{
                $this -> throwMsg('error','Error','Can\'t create appliction view file');
            }
        }
        $tpl = $this -> getTpl('view');
        $tpl = str_replace('<{name}>',$name,$tpl);
        $tpl = str_replace('<{controller}>',$controller,$tpl);
        $viName = $controller.DIRECTORY_SEPARATOR.$name.'.html';
        $viFile = VIEWS_PATH.$viName;
        $viDir = VIEWS_PATH.$controller;
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
        $routeFile = CONFIG_PATH.'routes.php';
        if(!file_exists($routeFile)){
            $tpl = $this->getTpl('route');
            $tpl = str_replace('<{name}>',$name,$tpl);
            $return = file_put_contents($routeFile,$tpl);
            if($return){
                $this -> throwMsg('success','Route file created',$routeFile);
            }else{
                $this -> throwMsg('error','Error','Can\'t create route file');
            }
        }else{
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
            };
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
    function getTpl($tpl){
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
