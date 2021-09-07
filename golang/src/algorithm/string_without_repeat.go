package algorithm

import "strings"

func stringWithoutRepeat1(s string) bool {
	if strings.Count(s, "") > 3000 {
		return false
	}
	for _, v := range s {
		if v > 127 {
			return false
		}
		if strings.Count(s, string(v)) > 1 {
			return false
		}
	}

	return true
}

func stringWithoutRepeat2(s string) bool {
	if strings.Count(s, "") > 3000 {
		return false
	}
	for k, v := range s {
		if v > 127 {
			return false
		}
		if strings.Index(s, string(v)) != k {
			return false
		}
	}

	return true
}
