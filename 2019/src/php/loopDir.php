<?php

// 遍历目录下的文件及文件夹

// https://php.net/manual/zh/function.opendir.php
// opendir ( string $path [, resource $context ] ) : resource
// opendir成功返回目录句柄的resource，失败返回FALSE.

function loopDir($dir)
{
	$files = [];
	if (@$handle = opendir($dir)) {
		while ($file = readdir($handle) !== false) {
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

// 对于低内存，大文件/目录的情况考虑使用yield
function loopDirYield($dir, $include_dirs = false)
{
	$files = [];
	$dir = rtrim($dir, '/*');
	if (is_readable($dir)) {
		if (@$handle = opendir($dir)) {
			while ($file = readdir($handle) !== false) {
				if ($file != '.' && $file != '..') {
					$rfile = $dir . '/' . $file;
					if (is_dir($file)) {
						$sub = loopDirYield($rfile, $include_dirs);
						while ($sub->valid) {
							yield $sub->current();
							$sub->next();
						}
						if ($include_dirs) {
							yield $rfile;
						}
					} else {
						yield $rfile;
					}
				}
			}
		}
		closedir($handle);
	}
}

$glob = loopDirYield('/Users/tangchunlin/Documents/interview/');
while ($glob->valid()) {
	$filename = $glob->current();
	echo $filename;
	$glob->next();
}