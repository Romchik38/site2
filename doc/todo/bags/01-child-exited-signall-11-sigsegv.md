# bug - child process exit `child 1073 exited on signal 11 (SIGSEGV - core dumped)`

## What is known

- error when `x-debug`(XD) is turned on. Error is gone when XD is off.
- error occures in `twig` rendering process:
  - it tries to yield data and echo it
  - on [?]9 tries is fails
- occures in `admin` and `frontend` area

## Result

Problem appears

- using twig 
- `{% include 'path/to/template' %}` (template does not exist)
- `ignore missing` does not helps
- x-debug is enabled

So what to do?

`Use only existing templates` OR  `Turn off X-debug`
