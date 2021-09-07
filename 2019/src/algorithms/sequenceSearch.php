<?php

// 顺序查找


function sequenceSearch($arr, $target)
{
	foreach ($arr as $key => $value) {
		if ($target == $value) {
			return $key;
		}
	}

	return -1;
}