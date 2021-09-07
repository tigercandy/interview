<?php

// 质数
function prime($n)
{
	$prime = [2];
	for ($i = 3; $i < $n; $i += 2) {
		$sqrt = intval(sqrt($i));
		for ($j = 3; $j <= $sqrt; $j += 2) {
			if ($i % $j == 0) {
				break;
			}
		}
		if ($j > $sqrt) {
			array_push($prime, $i);
		}
	}

	return $prime;
}

print_r(prime(100));