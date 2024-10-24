# Server error controller

[Server error controller](https://github.com/Romchik38/site2/blob/main/app/code/Controllers/ServerError/DefaultAction.php):

1. Action tries to show nice result about error. It uses main site design with menu, logo, footer, etc ...
2. Variant 1 - all is fine and action sends a response back to server
3. Variant 2 - an error occures

## 3. Variant 2 - an error occures

1. Action tries to load static html file (if it path was provided)
2. Otherwise forwards the error

### 3.1 tries to load static html file (if it path was provided)

- read a file by given path and sends data back
- throw an error when something wrong

All errors on this stages are catched by server. In that case frontend will receive a plane text message - see [7. Variant - controller not works](./01-how-it-works.md)
