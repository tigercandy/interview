<?php

function getListFirstCommonNode($pHead1, $pHead2)
{
	if ($pHead1 == null || $pHead2 == null) {
		return null;
	}
	$arr1 = $arr2 = [];
	while ($pHead1 != null) {
		$arr1[] = $pHead1;
		$pHead1 = $pHead1->next;
	}
	while ($pHead2 != null) {
		$arr2[] = $pHead2;
		$pHead2 = $pHead2->next;
	}
	$firstCommonNode = null;
	while (!empty($arr1) && !empty($arr2)) {
		$pNode1 = array_pop($arr1);
		$pNode2 = array_pop($arr2);
		if ($pNode1 == $pNode2) {
			$firstCommonNode = $pNode1;
		} else {
			break;
		}
	}

	return $firstCommonNode;
}