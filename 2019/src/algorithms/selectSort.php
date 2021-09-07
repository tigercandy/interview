<?php

// 选择排序
// 每次从待排序的数组中选择一个最大/最小的元素，放在序列的起始位置，直到全部待排序的数据元素排完。

function selectSort($arr)
{
	$len = count($arr);
	for ($i = 0; $i < $len - 1; $i++) {
		$p = $i;
		for ($j = $i + 1; $j < $len; $j++) {
			if ($arr[$p] > $arr[$j]) {
				$p = $j;
			}
		}
		if ($p != $i) {
			$tmp = $arr[$p];
			$arr[$p] = $arr[$i];
			$arr[$i] = $tmp;
		}
	}
	return $arr;
}

$arr = [1, 32, 23, 11, 89, 90, 54, 87, 0, 33];

print_r(selectSort($arr));