<?php

// 观察者模式

interface Subject
{
	public function register(Observer $Observer);
	public function notice();
}

interface Observer
{
	public function watch();
}


class Action implements Subject
{
	public $_observers = [];

	public function register(Observer $Observer)
	{
		$this->_observers[] = $Observer;
	}

	public function notice()
	{
		foreach ($this->_observers as $_observer) {
			$_observer->watch();
		}
	}
}

class Cat implements Observer
{
	public function watch()
	{
		echo __METHOD__ . " WATCH TV \n";
	}
}

class Dog implements Observer
{
	public function watch()
	{
		echo __METHOD__ . " WATCH TV \n";
	}

	public function eat()
	{
		echo __METHOD__ . " EAT \n";
	}
}


$action = new Action();

$action->register(new Cat());
$action->register(new Dog());

$action->notice();

/*Cat::watch WATCH TV
Dog::watch WATCH TV*/