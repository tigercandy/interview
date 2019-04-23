<?php
/*
				  A
			B           C
		D       E    F      G
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

preLoop($a);