# My Blog app for Akaunting

[![Tests](https://github.com/akaunting/module-my-blog/workflows/Tests/badge.svg?label=tests)](https://github.com/akaunting/module-my-blog/actions)

This is an example module with beyond CRUD functions for admin and is shown in the client portal.

`my-blog` is the alias aka unique identifier of the [module](https://developer.akaunting.com/documentation/modules/).

## Installation

- Create a `MyBlog` folder into `modules` directory
- Clone the repository: `git clone https://github.com/akaunting/module-my-blog.git`
- Install dependencies: `composer install ; npm install ; npm run dev`
- [Install](https://developer.akaunting.com/documentation/modules/#67474166c92e) the module: `php artisan module:install my-blog 1`

## To Do

- [ ] API
- [x] Bulk Actions
- [x] Category Type
- [x] Client Portal
- [x] ~~Contact Type~~
- [x] CRUD
- [x] ~~Document Type~~
- [ ] Email Templates
- [x] Exports
- [x] Imports
- [ ] Notifications
- [x] Jobs
- [x] Menu (Admin+Portal)
- [x] Ownership
- [x] Permissions
- [ ] Reports
- [x] Search String
- [x] Seeds
- [x] Tests
- [x] ~~Transaction Type~~
- [ ] Widgets

`Contact`, `Document`, and `Transaction` types are not applicable for this module.

## Tests

The workflow runs both [Akaunting](https://github.com/akaunting/akaunting/tree/master/tests) and module test suites. They're configured to run once per week and triggered [manually](https://github.com/akaunting/module-my-blog/actions/workflows/tests.yml).
