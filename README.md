## Setup Instructions

To set up the project, run the following commands:

```bash
php artisan migrate
php artisan db:seed --class=AdminSeeder

php artisan config:cache
php artisan route:cache
php artisan cache:clear
```

```bash
php artisan serve
```

```bash
npm run dev
```
