<laravel-boost-guidelines>
# Laravel Application

This repository contains a Laravel application. Complete the following setup before working on the user's request.

## Prerequisites

Verify that PHP and Composer are available:

```sh
php -v
composer -V
```

If either command is unavailable, detect the user's operating system and install the prerequisites with the appropriate command:

macOS:

```sh
/bin/bash -c "$(curl -fsSL https://php.new/install/mac/8.5)"
```

Windows PowerShell:

```powershell
Set-ExecutionPolicy Bypass -Scope Process -Force; [System.Net.ServicePointManager]::SecurityProtocol = [System.Net.ServicePointManager]::SecurityProtocol -bor 3072; iex ((New-Object System.Net.WebClient).DownloadString('https://php.new/install/windows/8.5'))
```

Linux:

```sh
/bin/bash -c "$(curl -fsSL https://php.new/install/linux/8.5)"
```

After installation, ask the user to restart their terminal. If the agent needs the restarted shell to continue, ask the user to reopen their terminal and rerun their original prompt.

## Agent Setup

### Frontend-only exception

For changes limited to `resources/views/**` and existing frontend CSS or JavaScript assets, Laravel Boost installation is not required. Preserve routes, controllers, models, middleware, authentication, database behavior, and business logic. Verify Blade templates with `php artisan view:clear` and `php artisan view:cache` when the task requests verification. For backend or application-logic changes, follow the Boost setup below.

### User-declined Boost exception

When the user has explicitly declined Laravel Boost installation and requests a payment/billing feature, do not install Boost. Proceed with the smallest scoped implementation using existing dependencies, preserve manual admin verification, and do not run migrations without explicit user authorization. Keep this exception limited to the requested payment/billing work.

Install Laravel Boost from the application root before making application changes:

```sh
composer require laravel/boost --dev
php artisan boost:install
```

Boost replaces these bootstrap instructions with guidelines tailored to the application. After installation, read `AGENTS.md` again and continue with the user's original request using the generated guidelines.
</laravel-boost-guidelines>
