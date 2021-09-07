<?php
/*
				  A
			B                  C
		D              E     F            G
	H
*/
class BinaryTree
{
	public $data;
	public $left;
	public $right;
}

$a = new BinaryTree();
$b = new BinaryTree();
$c = new BinaryTree();
$d = new BinaryTree();
$e = new BinaryTree();
$f = new BinaryTree();
$g = new BinaryTree();
$h = new BinaryTree();

$a->data = 'A';
$b->data = 'B';
$c->data = 'C';
$d->data = 'D';
$e->data = 'E';
$f->data = 'F';
$g->data = 'G';
$h->data = 'H';

$a->left = $b;
$a->right = $c;
$b->left = $d;
$b->right = $e;
$c->left = $f;
$c->right = $g;
$d->left = $h;

// 先根遍历
function preLoop($root)
{
	$stack = [];
	array_push($stack, $root);
	while (!empty($stack)) {
		$center_node = array_pop($stack);
		echo $center_node->data;
		if ($center_node->right != null) {
			array_push($stack, $center_node->right);
		}
		if ($center_node->left != null) {
			array_push($stack, $center_node->left);
		}
	}
}

// 中根遍历
function inLoop($root)
{
	$stack = [];
	$center_node = $root;
	while (!empty($stack) || $center_node != null) {
		while ($center_node != null) {
			array_push($stack, $center_node);
			$center_node = $center_node->left;
		}
		$center_node = array_pop($stack);
		echo $center_node->data;
		$center_node = $center_node->right;
	}
}

// 后根遍历
function tailLoop($root)
{
	$stack = $outStack = [];
	array_push($stack, $root);
	while (!empty($stack)) {
		$center_node = array_pop($stack);
		array_push($outStack, $center_node);
		if ($center_node->left != null) {
			array_push($stack, $center_node->left);
		}
		if ($center_node->right != null) {
			array_push($stack, $center_node->right);
		}
	}
	while (!empty($outStack)) {
		$center_node = array_pop($outStack);
		echo $center_node->data;
	}
}

// 二叉树的左视角
function leftNode($root)
{
	$stack[] = $root;
	$return = [];
	while (!empty($stack)) {
		$leftNode = array_shift($stack);
		if ($leftNode->right != null) {
			$stack[] = $leftNode->right;
		}
		if ($leftNode->left != null) {
			$stack[] = $leftNode->left;
		}
		$return[] = $leftNode->data;
	}
	return $return;
}

// 深度遍历
function loopTreeFromTopToBottom($root)
{
	$return = [];
	if (is_null($root)) {
		return $root;
	}
	array_push($return, $root->data);
	inQueue($root, $return);
	return $return;
}

function inQueue($root, &$return)
{
	if (is_null($root)) {
		return $return;
	}
	$left = $right = null;
	if ($root->left) {
		$left = $root->left;
		array_push($return, $left->data);
	}
	if ($root->right) {
		$right = $root->right;
		array_push($return, $right->data);
	}
	inQueue($left, $return);
	inQueue($right, $return);
}

// 反转二叉树
// 递归
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
	while(!empty($queue)) {
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

	return $root;
}

preLoop($a);
var_dump('-----------');
inLoop($a);

//print_r(leftNode($a));

//print_r(loopTreeFromTopToBottom($a));

//print_r(reverseTree2($a));


