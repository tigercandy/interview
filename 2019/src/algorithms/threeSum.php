<?php

function threeSum($arr, $m)
{
    $count = count($arr);
    if ($count < 3) {
        return [];
    }
    sort($arr);
    $res = [];
    for ($i = 0; $i < $count - 2; $i++) {
        if ($i > 0 && $arr[$i] == $arr[$i - 1]) {
            continue;
        }
        $target = $m - $arr[$i];
        $j = $i + 1;
        $k = $count - 1;
        while ($j < $k) {
            if ($arr[$j] + $arr[$k] == $target) {
                $res[] = [$arr[$i], $arr[$j], $arr[$k]];
                while ($j < $k && $arr[$j] == $arr[$j + 1]) {
                    ++$j;
                }
                while ($j < $k && $arr[$k] == $arr[$k - 1]) {
                    --$k;
                }
                ++$j;
                --$k;
            } elseif ($arr[$j] + $arr[$k] < $target) {
                ++$j;
            } else {
                --$k;
            }
        }
    }
    return $res;
}

$arr = [0, 14, 10, 3, 7, 5, 9, 8, 1, 2];

var_dump(threeSum($arr, 15));