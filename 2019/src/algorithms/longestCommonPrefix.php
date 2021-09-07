<?php

function longestCommonPrefix($strs)
{
    if (count($strs) == 0) {
        return '';
    }
    $i = 0;
    $prefix = '';
    $s = '';
    $res = true;
    while ($i < count($strs)) {
        $s .= $strs[0][$i];

        foreach ($strs as $str) {
            $ss = substr($str, 0, $i + 1);
            if ($s != $ss) {
                $res = false;
                break;
            }
        }
        $res && $prefix = $s;
        $i++;
    }

    return $prefix;
}

$strs = ["flower", "flow", "flight"];

var_dump(longestCommonPrefix($strs));