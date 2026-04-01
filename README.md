# doctrine-mongodb-bug-reproducer-tracking-policy
Bug reproducer: [doctrine-mongodb] DEFERRED_EXPLICIT tracking policy is partially ignored

**Steps to reproduce**

- `composer install`
- Configure your MongoDB connection in `.env.local`
- Database and test fixture setup: `bin/console app:test:init`
- Reproduce:
  - `bin/console app:test:reproduce`
  - Expected: The document in `WithExplicitTracking` was **not modified**
  - Result: The document in `WithExplicitTracking` **has been modified**
