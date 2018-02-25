<?php

namespace Hoday\Banners;

/*
 * Autoloader class
 */
class Autoloader
{
	public static function loader($class)
	{
		$filename = $class . '.php';
		$file = get_include_path() . PATH_SEPARATOR . $filename;
		//echo " autoloader:  " . $file . " ";
		$found = stream_resolve_include_path($filename); // use stream resolve instead of file_exist to check on the includ epath.

		//if (!file_exists($file))
		if ($found)
		{
			include $found;
		}
	}
}