# csrf

**No `csrf_token` in a POST request, no talk.** This means, that all POST request must be send with this kind of token inside.

## Protected

- `Auth` POST action recieves login form data from `Login` and `Login Admin` actions
- `Admin Imagecache Clear`

## Not protected

Some actions do not protected, because they are recieved data from forms, placed in the header or footer. These action must be simple and do not change app *state*.

- `Logout` POST actions

## How it works

There is a *request middleware* `CsrfMiddleware` executing before a target action. The request will be declined if `csrf_token` did not provided with post data.

To make a request successfull, action, which resposable to generate a `<fomr>`, must:

- generate a `csrf_token` with `CsrfTokenGeneratorUseRandomBytes` or somthing else
- place token inside `<form>` as `<input type="hidden">` tag.
- add token to `Session` with `csrf_token` key

[!] for admin use `admin_csrf_token`
