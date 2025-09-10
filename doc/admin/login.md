# Admin Login

- login
- user data
- authorization

## Login

To access the administrative part of the site, use the link `/login/admin`. You don't have access yet, so the system treats you as a regular visitor.

For the `username field`, use the `user's name`. The website system doesn't have other authentication types. If needed, they can be added by making changes to the code.

After checking the submitted data, you will be redirected to the admin panel page at `/admin`.

## User data

User data is stored in the `admin_users` database table. There are already several users here that you can use to log in:

|username    | password       |rigths |
|------------|----------------|-------|
| admin      | randoM_0       | full  |
| admin2     | randoM_1       | write |
| admin_read | UW%XV_a$gx^sp6 | read  |

You can create as many users as you want. To do this, you need to manually add data to the `admin_users` table. The database stores a `hash`. To verify it, `password_verify` function is used.

## Authorization

All added `admin users` automatically get access to `view all` parts of the site except `Manage users`.
Roles are distributed using the `admin_roles` and `admin_users_with_roles` database tables.

The following roles are available by default:

- ADMIN_ROOT
- ADMIN_WRITE_ALL

User with `ADMIN_WRITE_ALL` can send all post request except `Manage users` in the bootom part of the admin pannel.

User with `ADMIN_ROOT` can do all the same and can visit `Manage users`. It should be noted that `Manage users` is a placeholder. This page does nothing.

Read more about [authorization](./authorization.md)
