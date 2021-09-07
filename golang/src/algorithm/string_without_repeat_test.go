package algorithm

import "testing"

const s = "abcdefghij"

func TestStringWithoutRepeat1(t *testing.T) {
	flag := stringWithoutRepeat1(s)
	if flag {
		t.Log("没有重复")
	} else {
		t.Log("重复了")
	}
}

func TestStringWithoutRepeat2(t *testing.T) {
	flag := stringWithoutRepeat2(s)
	if flag {
		t.Log("没有重复")
	} else {
		t.Log("重复了")
	}
}
