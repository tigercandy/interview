package algorithm

import (
	"fmt"
	"sync"
)

func alphanumericPrinting() {
	// letter负责通知字母的goroutine打印
	// number负责通知数字的goroutine打印
	letter, number := make(chan bool), make(chan bool)
	// wait用来等待字母打印完成后退出循环
	wait := sync.WaitGroup{}

	go func() {
		i := 1
		for {
			select {
			case <-number:
				fmt.Print(i)
				i++
				fmt.Print(i)
				i++
				letter <- true
			}
		}
	}()
	wait.Add(1)
	go func(wait *sync.WaitGroup) {
		i := 'A'
		for {
			select {
			case <-letter:
				if i >= 'Z' {
					wait.Done()
					return
				}
				fmt.Print(string(i))
				i++
				fmt.Print(string(i))
				i++
				number <- true
			}
		}
	}(&wait)
	number <- true
	wait.Wait()
	fmt.Println()
}
