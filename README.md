# My Blog app for Akaunting

[![Tests](https://github.com/akaunting/module-my-blog/workflows/Tests/badge.svg?label=tests)](https://github.com/akaunting/module-my-blog/actions)

This is an example module with beyond CRUD functions for admin and is shown in the client portal.

`my-blog` is the alias aka unique identifier of the [module](https://developer.akaunting.com/documentation/modules/).

## Installation

- Create a `MyBlog` folder into `modules` directory
- Clone the repository: `git clone https://github.com/akaunting/module-my-blog.git`
- Install dependencies: `composer install ; npm install ; npm run dev`
- [Install](https://developer.akaunting.com/documentation/modules/#67474166c92e) the module: `php artisan module:install my-blog 1`

## Features

- [x] API ([provider](Providers/Main.php#L149), [route](Routes/api.php), [controller](Http/Controllers/Api), [transformer](Transformers))
- [x] Bulk Actions ([class](BulkActions), [blade](Resources/views/posts/index.blade.php#L27), [vuejs](Resources/assets/js/my-blog.js))
- [x] Category Type ([provider](Providers/Main.php#L87), [config](Config/type.php), [model](Models/Post.php#L23))
- [x] Client Portal
- [x] ~~Contact Type~~
- [x] Console Command ([provider](Providers/Main.php#L124), [class](Console/Inspire.php))
- [x] CRUD
- [x] Dashboard ([seed](Database/Seeds/Install.php#L20))
- [x] ~~Document Type~~
- [x] Dynamic Relationships ([define](Providers/Main.php#L104), [use](Widgets/PostsByCategory.php#L18))
- [x] Email Templates ([seed](Database/Seeds/Install.php#L21), [content](Resources/lang/en-GB/email_templates.php))
- [x] Exports ([controller](Http/Controllers/Posts.php#L244), [class](Exports))
- [x] Imports ([controller](Http/Controllers/Posts.php#L117), [class](Imports))
- [x] Jobs ([bulk action](BulkActions/Posts.php#L47), [ui](Http/Controllers/Posts.php#L222), [api](Http/Controllers/Api/Posts.php#L104))
- [x] Menu ([admin](Listeners/AddToAdminMenu.php), [portal](Listeners/AddToPortalMenu.php))
- [x] Notifications ([trigger](Observers/Comment.php#L22), [class](Notifications/Comment.php))
- [x] Observers ([define](module.json#L9), [provider](Providers/Observer.php), [class](Observers/Comment.php))
- [x] Ownership (`created_by` [field](Models/Post.php#L14), [controller](Http/Controllers/Posts.php#L26), [blade](Resources/views/posts/index.blade.php#L54))
- [x] Permissions ([listener](Listeners/FinishInstallation.php#L32))
- [x] Reports ([define](module.json#L13), [report](Reports/PostSummary.php), [listener](Listeners/AddCategoriesToReport.php))
- [x] Search String ([provider](Providers/Main.php#L87), [config](Config/search-string.php#L5), [blade](Resources/views/posts/index.blade.php#L24))
- [x] Seeds ([listener](Listeners/FinishInstallation.php#L29), [seeder](Database/Seeds/Install.php))
- [x] Settings ([define](module.json#L27), [use](Http/Controllers/Posts.php#L38))
- [x] Tests ([feature](Tests/Feature))
- [x] ~~Transaction Type~~
- [x] Widgets ([define](module.json#L17))

`Contact`, `Document`, and `Transaction` types are not applicable for this module.

## Tests

The workflow runs both [Akaunting](https://github.com/akaunting/akaunting/tree/master/tests) and module test suites. They're configured to run once per week and triggered [manually](https://github.com/akaunting/module-my-blog/actions/workflows/tests.yml).
