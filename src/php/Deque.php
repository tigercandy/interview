<?php

class Deque
{
	public $queue = [];

	// 尾部入队
	public function addLast($value)
	{
		return array_push($queue, $value);
	}

	// 尾部出队
	public function removeLast()
	{
		return array_pop($queue);
	}

	// 头部入队
	public function addHead($value)
	{
		return array_unshift($queue, $value);
	}

	// 头部出队
	public function removeHead()
	{
		return array_shift($queue);
	}

	// 清空队列
	public function removeEmpty()
	{
		return unset($queue);
	}

	// 获取队列长度
	public function getLen()
	{
		return count($queue);
	}

	// 获取队头
	public function getHead()
	{
		return reset($queue);
	}

	// 获取队尾部
	public function getTail()
	{
		return end($queue);
	}

}