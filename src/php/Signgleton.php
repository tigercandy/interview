<?php

// 单例模式

class DB
{
    private static $_instance;

    private function __construct()
    {
    }

    private function __clone()
    {
    }

    public static function getInstance()
    {
        if (!self::$_instance instanceof self) {
            self::$_instance = new self;
        }

        return self::$_instance;
    }
}