<?php

// 消消乐816

function glops($str)
{
	$l = strlen($str);
	while ($l >= 3) {
		$pos = strpos($str, '816');
		if ($pos || $pos === 0) {
			$str = substr_replace($str, "", $pos, 3);
		} else {
			break;
		}
	}
	return $str;
}

function removeStr($str) {
    $pat = '/816/';
    $res = preg_replace($pat, '', $str);
    return preg_match($pat, $res) ? removeStr($res) : $res;
}

$str = '818166816';

var_dump(removeStr($str));