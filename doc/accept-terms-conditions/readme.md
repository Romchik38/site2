# Accept terms and conditions popup

When a `visitor` first enters, the system suggests `accepting the terms and conditions`. This behavior is common for most resources on the Internet. Currently, the window will appear until the consent button is pressed. This, as well as the appearance, can be changed if needed.

Components responsible for the terms acceptance block:

- [Visitor application service](./../../app/code/Application/Visitor)
- [Http api endpoint](./../../app/code/Infrastructure/Http/Actions/POST/Api/Userinfo/DefaultAction.php)
- [Javascript components](./../../public/http/media/js/frontend/userinfo)

## How it works

### Javascript components

On `each page visit`, a `javaScript component` executes and checks the [data available](./../../public/http/media/js/frontend/visitor/visitorData.js) on the page to see if the visitor has accepted the terms. If they have not, a `message` about accepting the terms `is displayed`. If the user clicks the "accept" button, the JavaScript code `makes a request` to the API to confirm this. If the user `declines`, the acceptance message `will be shown on every subsequent visit` to any page of the site.

### Http api endpoint

The HTTP action uses the `application service` to mark that the visitor has accepted the terms. It calls the `acceptTerms` command as a function.

### Visitor application service

The `application service` works with a `visitor model` to mark the acceptance of the terms.
