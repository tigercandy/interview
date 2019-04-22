<?php

// 遍历目录下的文件及文件夹

function loopDir($dir)
{
	$files = [];
	if (@$handle = opendir($dir)) {
		$file = readdir($handle);
		while (($file = readdir($handle)) !=== false) {
			if ($file != '.' && $file != '..') {
				if (is_dir($file)) {
					$files[$file] = loopDir($file);
				} else {
					$files[] = $file;
				}
			}
		}
	}
	closedir($handle);
	return $files;
}