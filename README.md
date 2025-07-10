<p align="center">
    <a href="https://laravel.com" target="_blank">
        <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo">
    </a>
</p>

<p align="center">
    <a href="https://github.com/laravel/framework/actions">
        <img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status">
    </a>
    <a href="https://packagist.org/packages/laravel/framework">
        <img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads">
    </a>
    <a href="https://packagist.org/packages/laravel/framework">
        <img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version">
    </a>
    <a href="https://packagist.org/packages/laravel/framework">
        <img src="https://img.shields.io/packagist/l/laravel/framework" alt="License">
    </a>
</p>

---

# GM Mode — WWE Booking Manager 🎮

**GM Mode** est une application Laravel + Vue/Inertia inspirée du mode GM de WWE 2K24. Elle permet de gérer une fédération de catch avec :

- Gestion de brands (RAW, SmackDown, etc.)
- Roster de workers (catcheurs/catcheuses)
- Alignements, popularité, styles de lutte
- Système de classement et simulation de performances

---

## ⚙️ Technologies

- Laravel 12.x
- Inertia.js + Vue 3
- Breeze (authentification)
- Tailwind CSS
- Pest (tests)
- Docker via Laravel Sail

---

## 🚀 Installation

```bash
git clone https://github.com/ton-utilisateur/gm-mode.git
cd gm-mode
./vendor/bin/sail up -d
./vendor/bin/sail artisan migrate --seed

./vendor/bin/sail test
