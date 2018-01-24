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

namespace JobScooperPlugins;

class PluginsLoader
{
	public $dirRoot = null;
	public $dirPhpBased = null;
	public $dirJsonBased = null;

	function __construct()
	{
		$this->dirRoot = dirname(dirname(__FILE__) . DIRECTORY_SEPARATOR . "src");
		$this->dirPhpBased = "{$this->dirRoot}/php-based";
		$this->dirJsonBased = "{$this->dirRoot}/json-based";
	}

	function loadPhpBasedPlugins()
	{
		// need to load the ATS platforms first since sites can depend on them

		foreach(array("ats-platforms", "job-sites") as $subdir)
		{
			$dirpath = join(DIRECTORY_SEPARATOR, array($this->dirPhpBased, $subdir, '*.php'));
			$files = $this->glob_recursive($dirpath);
			foreach ($files as $file) {
				require_once($file);
			}
		}
	}

	// Does not support flag GLOB_BRACE
	private function glob_recursive($pattern, $flags = 0)
	{
		$files = glob($pattern, $flags);
		foreach (glob(dirname($pattern).'/*', GLOB_ONLYDIR|GLOB_NOSORT) as $dir)
		{
			$files = array_merge($files, $this->glob_recursive($dir.'/'.basename($pattern), $flags));
		}
		return $files;
	}
}


$loader = new PluginsLoader();
$loader->loadPhpBasedPlugins();