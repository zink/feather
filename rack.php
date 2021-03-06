<?php
require_once(__DIR__.DIRECTORY_SEPARATOR.'feather_config.php');
require_once(__DIR__.DIRECTORY_SEPARATOR.'encrypt'.DIRECTORY_SEPARATOR.'authcode.php');
require_once __DIR__.DIRECTORY_SEPARATOR.'generate'.DIRECTORY_SEPARATOR.'generate.php';
require_once __DIR__.DIRECTORY_SEPARATOR.'generate'.DIRECTORY_SEPARATOR.'colors.php';

//set command line color
$color = new Colors();
$echoCreate = $color->colored(' create ','white','green');
$echoError = $color->colored(' Error ','white','red');
$echoRoute = $color->colored(' Route ','white','green');

//require path
$generate_controller = __DIR__.DIRECTORY_SEPARATOR.'generate/controller.php';
$generate_model = __DIR__.DIRECTORY_SEPARATOR.'generate/model.php';


$dbArgv = explode(':',$argv[1]);
if($dbArgv[0]== 'db'){
    require_once __DIR__.DIRECTORY_SEPARATOR.'migrations/ruckus.php';
}else{
    switch($argv[1]){
        case 'g':
            new Generate(array_slice($argv,2));
        break;
        case 'generate':
            new Generate(array_slice($argv,2));
        break;
    }
}
?>
