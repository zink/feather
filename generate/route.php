<?php
    $routeFile = APP_PATH.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'routes.php';
    $route = file_get_contents($routeFile);
    $routeMatch = '/(<?[\s\S]*)(?:\)\;)/';
    preg_match($routeMatch,$route,$matchs);
    $check = preg_match('/(\,|,\s*)$/',$matchs[1]);
    if(!$check){
        $endRoute = $matchs[1].',';
    }else{
        $endRoute = $matchs[1];
    }
    $newRoute = "\n    '".$argv[3]."' => array(\n        'index' => array(),\n    ),\n);\n?>";
    $endRoute .= $newRoute;
    $return = file_put_contents($routeFile,$endRoute);
    if($return){
            echo <<< EOF
                $echoRoute:
                    $argv[3] => array(
                        'index' => array(),
                    ),
EOF;
    }
?>
