<?php

// 根据输入的列名找出对应的数字
function findNumByTitle($t)
{
	if (empty($t)) {
		return 0;
	}
	$num = $i = 0;
	$arr = array_flip(range('A', 'Z'));
	while (!empty($t)) {
		$pos = substr($s, -1);
		$t = substr($s, 0, strlen($t) - 1);
		$num = $num + ($arr[$pos] + 1) * pow(26, $i);
		$i++;
	}

	return $num;
}

// 根据输入的数字找出对应的列名
function findTitleByNum($n)
{
	if ($n <= 0) {
		return '';
	}
	$arr = range('A', 'Z');
	$res = '';
	while ($n != 0) {
		$n--;
		$pos = $n % 26;
		$res = $arr[$pos] . $res;

		$n = intval($n / 26);
	}

	return $res;
}

print_r(findTitleByNum(1));