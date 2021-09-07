<?php


// 递归实现
function reverseTree($root)
{
	if (is_null($root)) {
		return $root;
	}

	$tmp1 = $tmp2 = null;
	if ($root->left) {
		$tmp1 = reverseTree($root->left);
	}
	if ($root->right) {
		$tmp2 = reverseTree($root->right);
	}
	$root->left = $tmp2;
	$root->right = $tmp1;

	return $root;
}

// 非递归
function reverseTree2($root)
{
	$queue = [];
	array_push($queue, $root);
	while (!empty($queue)) {
		$node = array_shift($queue);
		$tmp = $node->left;
		$node->left = $node->right;
		$node->right = $tmp;
		if ($node->left != null) {
			array_push($queue, $node->left);
		}
		if ($node->right != null) {
			array_push($queue, $node->right);
		}
	}

	return $queue;
}