### Package installation:
```
composer clear-cache
composer install
```

### Database setting:
```
cp .env.example .env
php artisan key:generate
```

### Configure packages and migrations:
```
php artisan migrate
php artisan passport:install --uuids -q
php artisan db:seed
php artisan db:seed --class UsersSeeder
```

### Tests:
```
php artisan test
```

### Users from seeders:

#### User:
```
login: user@mail.com
password: userpassword
```

#### Admin:
```
login: admin@mail.com
password: adminpassword
```

### Add user from user role to admin role (optional command):
```
php artisan app:add-user-to-admin-role {userId}
```
