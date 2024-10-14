# Laravel Scaleway Mailer

**Laravel Scaleway Mailer** is a Laravel package that provides a mail transport driver for Scaleway Transactional Email, allowing you to easily send emails via the Scaleway API within your Laravel application.

## Installation

### 1. Requirements

- Laravel 8.x, 9.x, 10.x or 11.x
- PHP 8.0 or higher

### 2. Install via Composer

Add this package to your Laravel project via Composer:

```bash
composer require ashfieldjumper/laravel-scaleway-mailer
```

### 3. Configuration
After installation, the service provider will be automatically loaded by Laravel thanks to autoloading. Next, add your Scaleway API key and other required configurations to your .env file:
```env
SCW_SECRET_KEY=your-scaleway-secret-key
SCW_PROJECT_ID=your-scaleway-project-id
SCALEWAY_EMAIL_REGION=fr-par

MAIL_FROM_ADDRESS=your-email@example.com
MAIL_FROM_NAME="Your Application Name"
```

### 4. Modify Mail Configuration

```php
'mailers' => [
    'scaleway' => [
        'transport' => 'scaleway',
        'secret_key' => env('SCW_SECRET_KEY'),
        'project_id' => env('SCW_PROJECT_ID'),
        'region' => env('SCALEWAY_EMAIL_REGION', 'fr-par'),
    ],
// other mailers...
],
```
Also, set the default MAIL_MAILER to scaleway in your .env file:
```env
MAIL_MAILER=scaleway
```

## Issues and Contributions

If you find a bug or want to suggest a new feature, feel free to create an issue in the [GitHub repository](https://github.com/ashfieldjumper/laravel-scaleway-mailer/issues).

Contributions are always welcome. Feel free to submit a pull request!

## License

This package is licensed under the MIT license. Please see the `LICENSE` file for more information.