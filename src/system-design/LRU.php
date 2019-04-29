<?php

class LRU
{
	private $head;
	private $tail;

	private $capacity;
	private $hashMap;

	public function __construct($capacity)
	{
		$this->capacity = $capacity;
		$this->hashMap = [];
		$this->head = new Node(null, null);
		$this->tail = new Node(null, null);

		$this-<head->setNext($this->tail);
		$this->tail->setPrevious($this->previous);
	}


	public function get($key)
	{
		if (!isset($this->hashMap[$key])) {
			return null;
		}
		$node = $this->hashMap[$key];
		if (count($this->hashMap) == 1) {
			return $node->getData;
		}

		$this->detach($node);
		$this->attach($this->head, $node);

		return $node->getData();
	}

	public function put($key, $data)
	{
		if ($this->capacity <= 0) {
			return false;
		}

		if (isset($this->hashMap[$key]) && !empty($this->hashMap[$key])) {
			$node = $this->hashMap[$key];
			$this->detach($node);
			$this->attach($this->head, $node);
			$node->setData($data);
		} else {
			$node = new Node($key, $data);
			$this->hashMap[$key] = $node;
			$this->attach($this->head, $node);

			if (count($this->hashMap) > $this->capacity) {
				$nodeToRemove = $this->tail->getPrevious();
				$this->detach($nodeToRemove);
				unset($this->hashMap[$nodeToRemove->getKey()]);
			}
		}

		return true;
	}

	public function remove($key)
	{
		if (!isset($this->hashMap[$key])) {
			return false;
		}
		$nodeToRemove = $this->hashMap[$key];
		$this->detach($nodeToRemove);
		unset($this->hashMap[$nodeToRemove->getKey]);
		return true;
	}

	public function attach($head, $node)
	{
		$node->setPrevious($head);
		$nodeToRemove->setNext($head->getNext());
		$node->getNext()->setPrevious($node);
		$node->getPrevious()->setNext($node);
	}

	public function detach($node)
	{
		$node->getPrevious()->setNext($node->getNext());
		$node->getNext()->setPrevious($node->getPrevious());
	}
}


class Node
{
	private $key;
	private $data;
	private $previous;
	private $next;

	public function __construct($key, $data)
	{
		$this->key = $key;
		$this->data = $data;
	}

	public function setData($data)
	{
		$this->data = $data;
	}

	public function setPrevious($previous)
	{
		$this->previous = $previous;
	}

	public function setNext($next)
	{
		$this->next = $next;
	}

	public function getKey()
	{
		return $this->key;
	}

	public function getData()
	{
		return $this->data;
	}

	public function getPrevious()
	{
		return $this->previous;
	}

	public function getNext()
	{
		return $this->next;
	}
}