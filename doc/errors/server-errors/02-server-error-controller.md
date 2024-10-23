# Server error controller

[Server error controller](https://github.com/Romchik38/site2/blob/main/app/code/Controllers/ServerError/DefaultAction.php):

1. Tries to show nice result about error. It uses main site design with menu, logo, footre, etc ...
2. Variant 1 - all is fine and controller send a response back
3. Variant 2 - an error occures

## 3. Variant 2 - an error occures

1. tries to load static html file (if it path was provided)
2. or forwards the error

### 3.1 tries to load static html file (if it path was provided)

- read a file by given path and sends data back
- throw an error when something wrong

All errors on this stages are catched by server. In that case frontend will receive a plane text message from [7. Variant - controller not works](./01-how-it-works.md)
