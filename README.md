# Translator

Translator is a dynamic translation file generator for laravel framework based on key and values;

# Installation
```shell
composer require pointdeb/translator
```

# Usages
## SaveToFile

```php

<?php

use Pointdeb\Translator\Translation;

$datas = [
    "home.cover.greeting" => [
        "en" => "Hello world",
        "fr" => "Salut les gens",
        "mg" => "Salama tompoko"
    ],
];

$outputPath = '/your/path/';

foreach($datas as $key => $data) {
  $result = Translation::saveToFile($key, $data, $outputPath);
}

// result /your/path/en/home.php 
/** 
 * <?php
 * $contents = [];
 * $contents['cover']['greeting'] = "Hello world";
 * $contents['cover']['getstarted'] = "Get Started";
 * return $contents;
 */
```
## GetFromExcel
```php
use Pointdeb\Translator\Translation;

$excel = '/path/to/your.xlsx';
$result = Translation::getFromExcel($excel);

/**
 * [
 *      'key' => [
 *          'en' => 'value',
 *          'fr' => 'valeur'            
 *      ]
 * ] 
 * 
*/
```

## SaveToFileFromExcel (merge of GetFromExcel and SaveToFile)
```php
use Pointdeb\Translator\Translation;

$outputPath = '/your/path/';
$excel = '/path/to/your.xlsx';

$result = Translation::saveToFileFromExcel($excel, $outputPath);

// result /your/path/en/home.php 
/** 
 * <?php
 * $contents = [];
 * $contents['cover']['greeting'] = "Hello world";
 * $contents['cover']['getstarted'] = "Get Started";
 * return $contents;
 */
```

# Tests

```shell
phpunit
```


Made with love :smile: and comming soon with awesome stuff, [@Pointdeb](https://github.com/pointeb)