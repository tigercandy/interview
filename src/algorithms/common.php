<?php

// 判断两个有序数组是否有公共元素

function common($arr1, $arr2)
{
	$len1 = count($arr1);
	$len2 = count($arr2);
	$common = [];
	$i = $j = 0;
	while ($i < $len1 && $j < $len2) {
		if ($arr1[$i] > $arr2[$j]) {
			$j++;
		} elseif ($arr1[$i] < $arr2[$j]) {
			$i++;
		} else {
			array_push($common, $arr1[$i]);
			$i++;
			$j++;
		}
	}

	return $common;
}