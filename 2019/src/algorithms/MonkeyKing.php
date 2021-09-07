<?php

// 猴子选大王，约瑟夫环

function monkeyKing($n, $m)
{
	$arr = [1, $n];
	$i = 0;
	while (count($arr) > 1) {
		$i++;
		$survice = array_shift($arr);
		if ($i % $m != 0) {
			array_push($arr, $survice);
		}
	}
	return $arr[0];
}