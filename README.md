# Brush - Image Manipulation Library

Just include Brush and use it with your Laravel project. You can decrease the size of your images and insert watermark.

### Requirements

- Brush works with PHP 5.6 or above.

### Installation

```bash
$ composer require gguney/brush
```

### Usage
Add package's service provider to your config/app.php

```php
...
        GGuney\Brush\BrushServiceProvider::class,
...
```

Then write this line on cmd.
```bash
$ php artisan vendor:publish
```

This will publish brush.php config file to your app's config folder. So you can change views just by changing this config file.

### Author

Gökhan Güney - <gokhanguneygg@gmail.com><br />

### License

Brush is licensed under the MIT License - see the `LICENSE` file for details
