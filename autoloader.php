<?php
/**
 * Copyright 2014-18 Bryan Selner
 *
 * Licensed under the Apache License, Version 2.0 (the "License"); you may
 * not use this file except in compliance with the License. You may obtain
 * a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS, WITHOUT
 * WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied. See the
 * License for the specific language governing permissions and limitations
 * under the License.
 */

define("JOBSCOOPER_PLUGINS_DIR_ROOT", dirname(dirname(__FILE__)));
define("JOBSCOOPER_PLUGINS_DIR_PHPBASED", JOBSCOOPER_PLUGINS_DIR_ROOT . DIRECTORY_SEPARATOR ."php-based/");
define("JOBSCOOPER_PLUGINS_DIR_JSONBASED", JOBSCOOPER_PLUGINS_DIR_ROOT . DIRECTORY_SEPARATOR ."json-based/");

if ( ! function_exists('glob_recursive'))
{
	// Does not support flag GLOB_BRACE
	function glob_recursive($pattern, $flags = 0)
	{
		$files = glob($pattern, $flags);
		foreach (glob(dirname($pattern).'/*', GLOB_ONLYDIR|GLOB_NOSORT) as $dir)
		{
			$files = array_merge($files, glob_recursive($dir.'/'.basename($pattern), $flags));
		}
		return $files;
	}
}


$files = glob_recursive(JOBSCOOPER_PLUGINS_DIR_PHPBASED . '*.php');
foreach ($files as $file) {
	require_once($file);
}
