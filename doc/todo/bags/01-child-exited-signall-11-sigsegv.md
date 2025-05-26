# bug - child process exit `child 1073 exited on signal 11 (SIGSEGV - core dumped)`

## What is known

- error when `x-debug`(XD) is turned on. Error is gone when XD is off.
- error occures in `twig` rendering process:
  - it tries to yield data and echo it
  - on [?]9 tries is fails
- occures in `admin` and `frontend` area

## Versions to fix

1. [-] Check on blank `twig` area
2. [-] get a string which `twig` is rendering and then failing

## 1. Check on blank `twig` area

...