# csrf

**No `csrf_token` in a POST request, no talk.** This means, that all POST request must be send with this kind of token inside.

## Protected

- `Auth` POST action recieves login form data from `Login` and `Login Admin` actions

## Not protected

Some actions do not protected, because they are recieved data from forms, placed in the header or footer. These action must be simple and do not change app *state*.

- `Logout` POST actions
