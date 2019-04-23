<?php

// 希尔排序
// 将待排序数组分割成指定步长的若干子序列，然后分别对子序列进行排序（直接排序）。

function shellSort($arr)
{
	$len = count($arr);
	$k = floor($len / 2);
	while ($k > 0) {
		for ($i = 0; $i < $k; $i++) {
			for ($j = $i; $j < $len, ($j + $k) < $len; $j = $j + $k) {
				if ($arr[$j] > $arr[$j + $k]) {
					$tmp = $arr[$j + $k];
					$arr[$j + $k] = $arr[$j];
					$arr[$j] = $tmp;
				}
			}
		}
		$k = floor($k / 2);
	}
	return $arr;
}

$arr = [1, 32, 23, 11, 89, 90, 54, 87, 0, 33];

print_r(shellSort($arr));