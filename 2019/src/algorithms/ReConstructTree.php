<?php

class BinaryTree
{
	public $data;
	public $left;
	public $right;

	public function __construct($data)
	{
		$this->data = $data;
	}
}

// 已知二叉树的先根、中根遍历结果，还原二叉树
function reConstruct($pre, $vin)
{
	while ($pre && $vin) {
		$tree = new BinaryTree($pre[0]);
		$index = array_search($pre[0], $vin);
		$tree->left = reConstruct(array_slice($pre, 1, $index), array_slice($vin, 0, $index));
		$tree->right = reConstruct(array_slice($pre, $index + 1), array_slice($vin, $index + 1));
		return $tree;
	}
}


$pre = ['A', 'B', 'D', 'H', 'E', 'C', 'F', 'G'];
$vin = ['H', 'D', 'B', 'E', 'A', 'F', 'C', 'G'];


var_dump(reConstruct($pre, $vin));