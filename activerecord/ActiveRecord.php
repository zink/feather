<?php
if (!defined('PHP_VERSION_ID') || PHP_VERSION_ID < 50300)
	die('PHP ActiveRecord requires PHP 5.3 or higher');

define('PHP_ACTIVERECORD_VERSION_ID','1.0');

if (!defined('PHP_ACTIVERECORD_AUTOLOAD_PREPEND'))
	define('PHP_ACTIVERECORD_AUTOLOAD_PREPEND',true);

require __DIR__.'/libs/Singleton.php';
require __DIR__.'/libs/Config.php';
require __DIR__.'/libs/Utils.php';
require __DIR__.'/libs/DateTime.php';
require __DIR__.'/libs/Model.php';
require __DIR__.'/libs/Table.php';
require __DIR__.'/libs/ConnectionManager.php';
require __DIR__.'/libs/Connection.php';
require __DIR__.'/libs/SQLBuilder.php';
require __DIR__.'/libs/Reflections.php';
require __DIR__.'/libs/Inflector.php';
require __DIR__.'/libs/CallBack.php';
require __DIR__.'/libs/Exceptions.php';
require __DIR__.'/libs/Cache.php';

if (!defined('PHP_ACTIVERECORD_AUTOLOAD_DISABLE'))
	spl_autoload_register('activerecord_autoload',false,PHP_ACTIVERECORD_AUTOLOAD_PREPEND);

function activerecord_autoload($class_name)
{
	$path = ActiveRecord\Config::instance()->get_model_directory();
	$root = realpath(isset($path) ? $path : '.');

	if (($namespaces = ActiveRecord\get_namespaces($class_name)))
	{
		$class_name = array_pop($namespaces);
		$directories = array();

		foreach ($namespaces as $directory)
			$directories[] = $directory;

		$root .= DIRECTORY_SEPARATOR . implode($directories, DIRECTORY_SEPARATOR);
	}

	$file = "$root/".strtolower($class_name).".php";

	if (file_exists($file))
		require_once $file;
}
?>
