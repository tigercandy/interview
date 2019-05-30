<?php
// 数组中只出现一次的元素

// 方法一
function onlyOne($arr) {
    $res = 0;
    for ($i = 0; $i < count($arr); $i++) {
        $res ^= $arr[$i];
    }
    
   return $res;
}

// 方法二
function onlyOne2($arr) {
    $m = array_count_values($arr);
    foreach ($m as $k => $v) {
      if ($v == 1) {
        return $k;
      }
    }
    return 0;
}
