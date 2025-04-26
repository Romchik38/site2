# Todo

## Current

- admin user
  - app refactor check password
  - domain refactor roles
  - domain tests
  
- repositories must *catch* `InvalidArgimentException` error on entity creation and *throws* Repository error, because this is a problem of the database consistency.

- Package qossmic/deptrac is abandoned, you should avoid using it. Use deptrac/deptrac instead.

- make public
- php 8.4

## Next

- move to server
  - `Romchik38\Server\Models\Sql\SearchCriteria\Limit`
  - `Romchik38\Server\Models\Sql\SearchCriteria\Offset`
  - `Romchik38\Server\Models\Sql\SearchCriteria\OrderBy`
  - TwigView
  - Image storage
  