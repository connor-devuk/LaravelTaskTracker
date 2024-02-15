<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

## Requirements

> 1) PHP >= 8.1 
> 2) Ctype PHP Extension
> 3) cURL PHP Extension
> 4) DOM PHP Extension
> 5) Fileinfo PHP Extension
> 6) Filter PHP Extension
> 7) Hash PHP Extension
> 8) Mbstring PHP Extension
> 9) OpenSSL PHP Extension
> 10) PCRE PHP Extension
> 11) PDO PHP Extension
> 12) Session PHP Extension
> 13) Tokenizer PHP Extension
> 14) XML PHP Extension
> 15) A MySQL DB (https://laravel.com/docs/10.x/database#introduction)

## Install Instructions

### Initial Laravel Setup 

1) Follow the standard laravel installation procedure if this is for production you can follow this guide: https://laravel.com/docs/10.x/deployment
2) Copy your .env.example to .env and fill out the APP_NAME, APP_URL, and all the DB_ fields, and MAIL_
3) If in production also set APP_DEBUG to false
4) Don't forget to generate an application key:

```bash
php artisan key:generate
```

### Application Setup

```bash
php artisan migrate
```

```bash
npm run build
```
