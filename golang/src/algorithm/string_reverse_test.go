package algorithm

import "testing"

var st = "ABCEDFG"

func TestStringReverse(t *testing.T) {
	str, flag := stringReverse(st)
	if !flag {
		t.Errorf("operate failed, invalid params")
	} else {
		t.Logf("result: %s", str)
	}
}
