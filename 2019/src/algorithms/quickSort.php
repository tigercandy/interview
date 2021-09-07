<?php

// 快速排序
// 将待排序的数组分割成两部分，其中一部分的数据都比另外一部分的数据小，然后再按照此方法继续分割这两部分数据进行快速排序，整个排序过程可以递归完成。

function quickSort($arr)
{
	$len = count($arr);
	if ($len <= 1) {
		return $arr;
	}
	$base = $arr[0];
	$left = $right = [];
	for ($i = 1; $i < $len; $i++) {
		if ($base > $arr[$i]) {
			$left[] = $arr[$i];
		} else {
			$right[] = $arr[$i];
		}
	}

	$left = quickSort($left);
	$right = quickSort($right);
	return array_merge($left, [$base], $right);
}