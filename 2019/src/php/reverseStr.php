<?php

function reverseStr($str)
{
	$newStr = '';
	$arr = str_split($str);
	for ($i = count($arr) - 1; $i >= 0; $i--) {
		$newStr .= $arr[$i];
	}

	return $newStr;
}

print_r(reverseStr("abcdefg"));