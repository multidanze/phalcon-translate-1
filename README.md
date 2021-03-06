# Phalcon Translate Service
[![Code Coverage](https://scrutinizer-ci.com/g/stanislav-web/phalcon-translate/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/stanislav-web/phalcon-translate/?branch=master) [![Total Downloads](https://poser.pugx.org/stanislav-web/phalcon-translate/downloads.svg)](https://packagist.org/packages/stanislav-web/phalcon-translate) [![License](https://poser.pugx.org/stanislav-web/phalcon-translate/license.svg)](https://packagist.org/packages/stanislav-web/phalcon-translate) [![Latest Stable Version](https://poser.pugx.org/stanislav-web/phalcon-translate/v/stable.svg)](https://packagist.org/packages/stanislav-web/phalcon-translate)

Phalcon Translate Service. Simple way to translate your costom part of templates :-)

## Changelog
- 1.3.1 [FIX] Default language use
- 1.3 [FIX] Support for Phalcon 2.x // [Minor fix] Translate Adapter Native offsetGet is not work on 2.0
- 1.2 [FIX, FEATURE] The ability to reuse a set of translations in various services
- 1.1 Added setDefault() method to watch undefined languages

## Compatible
- PSR-1, PSR-2, PSR-4 Standards

## System requirements
- PHP 5.4.x >
- Phalcon extension 1.3.x, 2.x

## Install
First update your dependencies through composer. Add to your composer.json:
```python
"require": {
    "stanislav-web/phalcon-translate": "1.*"
}
```
```python
php composer.phar install
```
OR
```python
php composer.phar require stanislav-web/phalcon-translate 1.*
```
_(Do not forget to include the composer autoloader)_

Or manual require in your loader service
```php
    $loader->registerNamespaces([
        'Translate\Translator' => 'path to src'
    ]);
```    
You can create an injectable service
```php
    $this->di['translate'] = function() {
        return new Translate\Translator();
    };
```
## Usage

#### recomended configuration for translate directory (as example)
```
/app/languages/{LANG}/{PART}.php

LANG meant "ru", "en", "de"
PART meant "menu", "header", "footer"
```
#### files for translation
```php
<?php
return [
    'MY ACCOUNT'    =>  'My Account',
    'LOGIN'         =>  'Log in',
    'LOGOUT'        =>  'Log out',
    'WELCOME'       =>  'Welcome, %s! We glad to see you! You are %d',
];
```
#### configuration and use
```php
    // get translate service
    $translate = $this->di->get('translate');
    
     // forward slash must be...  // lang can get from headers or cookies
    $translate->setTranslatePath('/app/Modules/Frontend/languages/')->setLanguage('en');
    
    // 1.1-stable Added setDefault() method to watch undefined languages
    $translate->setDefault('en');
    
    // so now you have a directory for "English".. 
    // Next you need to choise a part of translate.
    // I do something like this
    
    $this->view->setVars('t', $translate);
    
    // ... in my view or layout i get a part of translate
    
    echo $t->assign('menu')->translate('MY ACCOUNT'); // My Account
    
    // or use otherwise
    $this->partial('sidebar', ['t' => $t->assign('sidebar')]);
    echo $t->translate('LOGIN');
    
    // translate by template variable
    printf($t->translate('WELLCOME'), 'User', 100); // Output: Welcome,User! We glad to see you! You are 100
```

##[Issues](https://github.com/stanislav-web/phalcon-translate/issues "Issues")
