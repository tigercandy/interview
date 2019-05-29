<?php
/**
* 两个有序链表合并成一个有序链表
*/
class MergeLinkList
{
	public $val;
}

function mergeList($pHead1, $pHead2)
{
	if ($pHead1 == null) {
		return $pHead2;
	}
	if ($pHead2 == null) {
		return $pHead1;
	}
	$reHead = new MergeLinkList();

	if ($pHead1->val < $pHead2->val) {
		$reHead = $pHead1;
		$pHead1 = $pHead1->next;
	} else {
		$reHead = $pHead2;
		$pHead2 = $pHead2->next;
	}

	$p = $reHead;
	while ($pHead1 && $pHead2) {
		if ($pHead1->val <= $pHead2->val) {
			$p->next = $pHead1;
			$pHead1 = $pHead1->next;
		} else {
			$p->next = $pHead2;
			$pHead2 = $pHead2->next;
		}
		$p = $p->next;
	}
	if ($pHead1 != NULL) {
		$p->next = $pHead1;
	}
	if ($pHead2 != NULL) {
		$p->next = $pHead2;
	}

	return $reHead;
}