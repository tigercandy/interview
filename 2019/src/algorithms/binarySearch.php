<?php

// 二分查找
// 前提必须是有序的

function binarySearch($arr, $low, $top, $target)
{
	while ( $low <= $top) {
		$mid = floor(($low + $top) / 2);
		if ($arr[$mid] == $target) {
			return $arr[$mid];
		} elseif ($arr[$mid] < $target) {
			$low = $mid + 1;
		} else {
			$top = $mid - 1;
		}
	}

	return -1;
}

// 递归
function binarySearch2($arr, $low, $top, $target)
{
	if ($low <= $top) {
		$mid = floor(($low + $top) / 2);
		if ($arr[$mid] == $target) {
			return $arr[$mid];
		} elseif ($arr[$mid] < $target) {
			return binarySearch2($arr, $mid + 1, $top, $target);
		} else {
			return binarySearch2($arr, $low, $mid - 1, $target);
		}
	}

	return -1;
}