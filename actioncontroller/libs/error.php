<?php
namespace ActionController;

class Error{
    function handlingExceptions($error){
        switch($error){
        case 404:
            $page404 = file_get_contents(PUBLIC_PATH.'404.html');
            header('HTTP/1.1 404 Not Found');
            header("status: 404 Not Found");
            echo $page404;
            break;
        case 'database':
            header("Content-type: text/html; charset=utf-8"); 
            echo '请设置正确的数据库连接';
            break;
        case 'view':
            header("Content-type: text/html; charset=utf-8"); 
            echo '未找到视图文件';
            break;
        case 'layout':
            header("Content-type: text/html; charset=utf-8"); 
            echo '未找到layout文件';
            break;
        }
        exit;
    }
}
?>
