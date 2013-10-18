<?php
/*
   是否执行rewrite
 */
define('REWRITE',false);

/*是否开启ecae环境*/
define('ECAE_MODE', false);

/*
 * 系统环境
 * @param development
 * @param production
 * @param test
*/
define('ENV', 'development');

/*
 * @notice cdn资源根路径，false时静态资源默认保存在app/assets/中，
 * @param false
 * @param [URL/PATH]
 * @warning 静态资源存储在cdn服务器中时，assets目录结构要保持不变。
 */
define('CDN',false);

/*
 * @notice 缓存目录，缓存目录下包含cache和compiled，cache目录下保存纯静态页面（不含php标签），compiled目录下保存视图编译后文件。
 * @param false
 * @param [URL/PATH]
 * @warning cache下的纯静态模式只有在ENV = production下才会开启。
 */
define('CACHE_DIR','data');

?>
