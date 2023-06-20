# Projekat: Bioskop

## Opis

Bioskop je web aplikacija koja omogućava korisnicima da pregledaju repertoar bioskopa, rezervišu karte i ostavljaju komentare na filmove.

## Demo

[https://pmf.formula1.rs](https://pmf.formula1.rs)

## Setup

```
composer install
php artisan key:generate
php artisan migrate --seed
npm install && npm run build
php artisan serve
```