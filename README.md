# All-in-One Translations Manager for Laravel

[![Latest Version on Packagist](https://img.shields.io/packagist/v/elegantly/laravel-translator.svg?style=flat-square)](https://packagist.org/packages/elegantly/laravel-translator)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/elegantengineeringtech/laravel-translator/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/elegantengineeringtech/laravel-translator/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/elegantengineeringtech/laravel-translator/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/elegantengineeringtech/laravel-translator/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/elegantly/laravel-translator.svg?style=flat-square)](https://packagist.org/packages/elegantly/laravel-translator)

![Laravel Translator](https://repository-images.githubusercontent.com/816339762/eefcad09-87ad-484e-bcc4-5759303dc4b6)

Easily manage all your Laravel translation strings with powerful features:

-   **Translate** strings into other languages using DeepL, OpenAI, or any custom service.
-   **Proofread** translations to fix grammar and syntax automatically (via OpenAI or a custom service).
-   **Find missing** translation strings across locales.
-   **Detect unused** translation keys in your codebase.
-   **Sort** your translations in natural order.

## Try Laratranslate – A Powerful UI for Managing Translations

[![Laratranslate](https://elegantengineering.tech/assets/laratranslate/opengraph.jpg)](https://elegantengineering.tech/laratranslate/)

---

## Installation

Install the package via Composer:

```bash
composer require elegantly/laravel-translator --dev
```

Then, add the following line to your `.gitignore` file:

```
.translator.cache
```

Next, publish the configuration file:

```bash
php artisan vendor:publish --tag="translator-config"
```

---

## Configuring the Driver

This package uses a driver-based architecture. By default, it supports two standard drivers: PHP and JSON.
You can also create custom drivers for alternative storage methods, such as a database.

Set the default driver in the configuration file:

```php
use Elegantly\Translator\Drivers\PhpDriver;

return [
    /**
     * Possible values: 'php', 'json', or a class-string implementing Driver.
     */
    'driver' => PhpDriver::class,

    //...
];
```

---

## Sorting and Formatting

### CLI Commands

Sort translations with the default driver:

```bash
php artisan translator:sort
```

Specify a driver for sorting:

```bash
php artisan translator:sort --driver=json
```

### Using Code

Sort translations programmatically with the default driver:

```php
use Elegantly\Translator\Facades\Translator;

Translator::sortTranslations(locale: 'fr');
```

Or specify a driver:

```php
Translator::driver('json')->sortTranslations(locale: 'fr');
```

---

## Automatic Translation

Before translating, you need to configure a translation service. The package supports:

-   **OpenAI**
-   **DeepL**

Custom translation services can also be implemented.

### Configuring OpenAI

Define your OpenAI credentials in the configuration file or via environment variables:

```php
return [
    // ...

    'services' => [
        'openai' => [
            'key' => env('OPENAI_API_KEY'),
            'organization' => env('OPENAI_ORGANIZATION'),
            'request_timeout' => env('OPENAI_REQUEST_TIMEOUT'),
        ],
    ],

    // ...
];
```

### Configuring DeepL

Add your DeepL API key to the configuration file or environment variables:

```php
return [
    // ...

    'services' => [
        // ...
        'deepl' => [
            'key' => env('DEEPL_KEY'),
        ],
    ],

    // ...
];
```

### CLI Translation

Translate missing French translations:

```bash
php artisan translator:missing en fr --translate
```

Translate using a specific driver:

```bash
php artisan translator:missing en fr --translate --driver=json
```

Add a new locale with translations:

```bash
php artisan translator:add-locale fr en --translate
```

### Programmatic Translation

Translate translations programmatically with the default driver:

```php
Translator::translateTranslations(
    source: 'en',
    target: 'fr',
    keys: ['validation.title', ...]
);
```

Specify a driver for translation:

```php
Translator::driver('json')->translateTranslations(
    source: 'en',
    target: 'fr',
    keys: ['My Title', ...]
);
```

---

## Proofreading Translations

Proofreading corrects grammar and syntax.

Currently, OpenAI is the only built-in service, but you can implement custom services.

### CLI Proofreading

```bash
php artisan translator:proofread
```

### Programmatic Proofreading

Proofread translations with the default driver:

```php
Translator::proofreadTranslations(
    locale: 'fr',
    keys: ['auth.email', ...]
);
```

Specify a driver:

```php
Translator::driver('json')->proofreadTranslations(
    locale: 'fr',
    keys: ['My Title', ...]
);
```

---

## Finding Missing Translations

Identify keys defined in one locale but missing in another.

### CLI Usage

```bash
php artisan translator:missing en fr
```

### Programmatic Usage

```php
Translator::getMissingTranslations(source: 'en', target: 'fr');
```

---

## Detecting Undefined Translations

Undefined translations are keys found in your codebase but missing in the translation files.

### CLI Usage

```bash
php artisan translator:undefined en
```

### Programmatic Usage

```php
Translator::getUndefinedTranslations(locale: 'en');
```

---

## Detecting Dead Translations

Dead translations are keys defined in your files but unused in your codebase.

### CLI Usage

```bash
php artisan translator:dead fr
```

### Programmatic Usage

```php
Translator::getDeadTranslations(locale: 'fr');
```

---

## Code Scanner Configuration

### Included Paths

Specify paths to scan for translation keys. By default, both `.php` and `.blade.php` files are supported.

```php
return [
    'searchcode' => [
        'paths' => [
            app_path(), // Scan /app directory
            resource_path(), // Scan /resource directory
        ],
    ],
];
```

### Excluded Paths

Exclude irrelevant paths for optimized scanning, such as test files or unrelated directories.

### Ignored Translation Keys

Ignore specific translation keys, e.g., keys used dynamically with string interpolation:

```php
return [
    'searchcode' => [
        'ignored_translations' => [
            'countries', // Ignore keys starting with 'countries'.
        ],
    ],
];
```

---

## Testing

Run tests using:

```bash
composer test
```

---

## Changelog

For recent updates, see the [CHANGELOG](CHANGELOG.md).

---

## Contributing

Check the [CONTRIBUTING](CONTRIBUTING.md) guide for details.

---

## Security Vulnerabilities

Report security vulnerabilities via GitHub or email.

---

## Credits

-   [Quentin Gabriele](https://github.com/QuentinGab)
-   [All Contributors](../../contributors)

---

## License

This package is licensed under the MIT License. See the [License File](LICENSE.md) for more details.
