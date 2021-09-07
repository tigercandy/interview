<?php

// php实现敏感词过滤DFA算法

class DFA
{
    private $hashMap = [];

    public function setHashMap($strWord)
    {
        $len = mb_strlen($strWord, 'utf-8');
        $hashMap = &$this->hashMap;
        for ($i = 0; $i < $len; $i++) {
            $word = mb_substr($strWord, $i, 1, 'utf-8');
            if (isset($hashMap[$word])) {
                if ($i == ($len - 1)) {
                    $hashMap[$word]['end'] = true;
                }
            } else {
                if ($i == ($len - 1)) {
                    $hashMap[$word] = [];
                    $hashMap[$word]['end'] = true;
                } else {
                    $hashMap[$word] = [];
                    $hashMap[$word]['end'] = false;
                }
            }
            $hashMap = &$hashMap[$word];
        }
    }

    public function searchWord($strWord)
    {
        $len = mb_strlen($strWord, 'utf-8');
        $arrHashMap = $this->hashMap;
        for ($i = 0; $i < $len; $i++) {
            $word = mb_substr($strWord, $i, 1, 'utf-8');
            if (!isset($arrHashMap[$word])) {
                $arrHashMap = $this->hashMap;
                continue;
            }
            if ($arrHashMap[$word]['end']) {
                return true;
            }
            $arrHashMap = $arrHashMap[$word];
        }
        return false;
    }
}

$obj = new DFA();

$obj->setHashMap('冰毒');
$obj->setHashMap('大麻');
$obj->setHashMap('傻逼');
$obj->setHashMap('坏蛋');

var_dump($obj->searchWord('张三吸食冰毒'));