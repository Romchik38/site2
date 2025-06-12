# Todo

## Current

- update server
- refactor twig from include to extends

- after update to new server v
  - `RequestHandlerTrait`
    - remove from `server` folder
    - remove `use` from some action, which use it
  - refactor not found controller to request handler
    - move not found controller to not found handler
    - change in bootstrap (router)
    - test how it works
  - check sipemap - must form encoded urls (LinkTree)

## Next

- return check "vendor/bin/deptrac"

- move to server
  - TwigView
  - Image storage

- monitoring
