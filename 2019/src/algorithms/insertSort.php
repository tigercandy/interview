<?php

// 插入排序
// 每次从无序列表中取出第一个元素，把它插入到有序列表的合适位置，使有序列表仍然有序。

function insertSort($arr)
{
	$len = count($arr);
	for ($i = 1; $i < $len; $i++) {
		$tmp = $arr[$i];
		for ($j = $i - 1; $j >= 0; $j--) {
			if ($tmp < $arr[$j]) {
				$arr[$j + 1] = $arr[$j];
				$arr[$j] = $tmp;
			} else {
				break;
			}
		}
	}

	return $arr;
}

$arr = [1, 32, 23, 11, 89, 90, 54, 87, 0, 33];

print_r(insertSort($arr));