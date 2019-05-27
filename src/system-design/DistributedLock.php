<?php

/**
基于Redis实现分布式锁
*/

$lockKey = 'LOCK:' . $program; // 设置锁key
$lockExpire = 10; // 锁的有效期

// 获取缓存信息
$result = $redis->get($lockKey);
// 判断缓存中是否有数据
if (empty($result)) {
	$status = true;
	while ($status) {
		// 设置锁值为当前时间+有效期
		$lockValue = time() + $lockExpire;
		/**
		创建锁
		*/
		$lock = $redis->setnx($lockKey, $lockValue);

		if (!empty($lock) || ($redis->get($lockKey) < time() && $redis->getSet($lockKey, $lockValue) < time())) {
			$redis->expire($lockKey, $lockExpire);
			if ($redis->ttl($lockKey)) {
				$redis->del($lockKey);
				$status = false;
			}
		} else {
			// TODO

			// 等待2s后尝试重新操作
			sleep(2);
		}
	}
}