<?php

$arr = [1, 2, 3];

foreach ($arr as &$v) {
	
}

var_dump($arr);

foreach ($arr as $v) {
	# code...
}

var_dump($arr);