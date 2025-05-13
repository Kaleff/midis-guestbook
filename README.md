# GuestBook application built on PHP, Laravel, Inertia.js, Vue, Tailwind CSS, PostgreSQL.

This is the project that allows to work with guest book comments and interact with guests.
# Launching laravel application

> [!NOTE]
> I've used Laravel Sail approach for building an application Dockerized.
> To run laravel sail you need to utilise MAC, LINUX or Windows with WSL2 and a docker engine running.
> In case you are using Windows WSL2, make sure to mount this project repository in WSL2 and run from there.
> Further info is available here: https://laravel.com/docs/11.x/sail

1) Clone the repo

```
git clone https://github.com/Kaleff/midis-guestbook.git
cd midis-guestbook
```
2) Copy, configure the .env.example file and rename the copy to .env
```
cp .env.example .env
```

3) Run the composer installation in the project directory

```
composer install
```

4) Generate APP_KEY for .env file

```
php artisan key:generate
```


5) Run the application using SAIL, make sure the docker engine is running

```
./vendor/bin/sail up
```

6) Run the migrations and seeders, 
```
./vendor/bin/sail artisan migrate:fresh -seed
```
7) This will create an admin user
```
[
  'name' => 'admin',
  'email' => 'admin@gmail.com',
  'password' => bcrypt('root'),
]
```

8) Build front-end
```
npm run build
```
9) Make sure that the project is running at
```
http:/localhost/
```
10) The mailpit service to restore forgotten passwords is running default on
```
http://localhost:8025/
```
11) If you have deleted all the admins just run the seeder again:
```
./vendor/bin/sail artisan db -seed
```
12) If there are problems with accessing the stored images run
```
./vendor/bin/sail artisan storage:link
```
13) To run backup creation use:
```
./vendor/bin/sail artisan backupdb
and
./vendor/bin/sail artisan schedule:work
```
for a scheduled worker, that creates back-ups everyday at 00:00

> [!NOTE]
> This is a product of fast time delivery, this project was made in 12-14 hours, thus, it lacks many moments I usually would like implement due to time shortage:

> Reusable Vue components

> Better structure utilizing resources, services and repositories

> Click captcha

> Better front-end data-flow
