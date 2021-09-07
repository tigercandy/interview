package algorithm

func stringReverse(s string) (string, bool) {
	str := []rune(s)
	l := len(str)
	if l > 5000 {
		return s, false
	}
	for i := 0; i < l/2; i++ {
		str[i], str[l-1-i] = str[l-1-i], str[i]
	}
	return string(str), true
}
