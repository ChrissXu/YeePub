package xQuit

import (
	"runtime/debug"
	"fmt"
)

func TryRecover() {
	if err := recover(); err != nil {
		by := debug.Stack()
		fmt.Println("occured crash!!!!!!\nmsg:\n%v\nstack:\n%s", err, string(by))
	}
}
