# Laravel MakeView

Laravel MakeView is a Laravel Package that allows to generate views via an artisan command.

## Installation

Use composer to install MakeView.

```bash
composer require lanciweb/laravel-make-view
```

## Usage


### Single view: 
Use the commands below and the dot notation to easily create the blade files for your views:

```bash
php artisan make:view home
# creates 'home.blade.php' in the 'resources/views' folder.
```

```bash
php artisan make:view guests.home
# creates 'home.blade.php' in the 'resources/views/guests' folder. 
# The folder is created if it does not exists yet.
```

```bash
php artisan make:view backoffice.admin.home
# creates 'home.blade.php' in the 'resources/views/backoffice/admin' folder. 
# All folders are created if they do not exist yet.
```

### Crud Option:
Use the CRUD option to immeiately create the folder and the conventional resource views:

```bash
php artisan make:view posts --crud
# creates 'index.blade.php', 'show.blade.php`, `create.blade.php' and `edit.blade.php'
# in the 'resources/views/posts' folder.
```

```bash
php artisan make:view posts -c
# shorthand for the same result as above
```

```bash
php artisan make:view admin.posts -c
# creates 'index.blade.php', 'show.blade.php`, `create.blade.php' and `edit.blade.php'
# in the 'resources/views/admin/posts' folder.
```


## License

[MIT](./LICENSE.md)
