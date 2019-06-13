<?php

function threeSum($arrs, $m)
{
    $count = count($arrs);
    if ($count < 3) {
        return [];
    }
    sort($arrs);
    $res = [];
    for ($i = 0; $i < $count - 2; $i++) {
        if ($i > 0 && $arrs[$i] == $arrs[$i - 1]) {
            continue;
        }
        $target = $m - $arrs[$i];
        $j = $i + 1;
        $k = $count - 1;
        while ($j < $k) {
            if ($arrs[$j] + $arrs[$k] == $target) {
                $res[] = [$arrs[$i], $arrs[$j], $arrs[$k]];
                while ($j < $k && $arrs[$j] == $arrs[$j + 1]) {
                    ++$j;
                }
                while ($j < $k && $arrs[$k] == $arrs[$k - 1]) {
                    --$k;
                }
                ++$j;
                --$k;
            } elseif ($arrs[$j] + $arrs[$k] < $target) {
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