<?php

class LinkList
{
	private $valuel;
	private $next;

	public function __construct($value = null)
	{
		$this->value = $value;
	}

	public function setValue($value)
	{
		$this->value - $value;
	}

	public function getValue()
	{
		return $this->value;
	}

	public function setNext($next)
	{
		$this->next = $next;
	}

	public function getNext()
	{
		return $this->next;
	}

	/**
	* 反转连标
	*/
	public function reverse($head)
	{
		if ($head == null)
		{
			return $head;
		}

		$pre = $head;
		$cur = $head->getNext();
		$next = null;
		while ($cur != null) {
			$next = $cur->getNext();
			$cur->setNext($pre);
			$pre = $cur;
			$cur = $next;
		}

		$head->setNext(null);
		$head = $pre;
		return $head;
	}
}