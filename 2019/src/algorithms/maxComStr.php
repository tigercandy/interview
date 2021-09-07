<?php

// 最小公共子序列/最长公共子串

function maxComStr($str1, $str2)
{
	$c = [];
	$len1 = strlen($str1);
	$len2 = strlen($str2);
	for ($i = 0; $i < $len1; $i++) {
		for ($j = 0; $j < $len2; $j++) {
			$n = ($i - 1 >= 0 && $j - 1 >= 0) ? $c[$i-1][$j-1] : 0;
			$n = ($str1[$i] == $str2[$j]) ? $n + 1 : 0;
			$c[$i][$j] = $n;
		}
	}
	foreach ($c as $k => $v) {
		$max = max($v);
		foreach ($v as $key => $value) {
			if ($value == $max && $max > 0) {
				$cdStr[$max] = substr($str2, $key - $max + 1, $max);
			}
		}
	}
	ksort($cdStr);
	print_r(end($cdStr));
}

$str1 = "abcdehijlkhdojhdluehdkls";
$str2 = "abcdelkdhijduidjeuehlkfsop";

maxComStr($str1, $str2);