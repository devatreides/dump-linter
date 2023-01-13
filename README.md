<p align="center"><a href="https://github.com/tombenevides" target="_blank"><img src="https://banners.beyondco.de/Dump%20Linter.png?theme=light&packageManager=composer+require&packageName=tombenevides%2Fdump-linter&pattern=architect&style=style_1&description=Custom+PHP-CS-Fixer+rule+to+remove+dump+statements&md=1&showWatermark=0&fontSize=100px&images=sparkles" width="650"></a></p>

<p align="center">
  <a href="https://github.com/tombenevides/dump-linter/actions"><img alt="Total Downloads" src="https://github.com/tombenevides/dump-linter/actions/workflows/tests.yml/badge.svg?branch=main"></a>
  <a href="https://github.com/tombenevides/dump-linter/issues"><img alt="Issues Open" src="https://img.shields.io/github/issues/tombenevides/dump-linter"></a>
  <a href="https://packagist.org/packages/tombenevides/dump-linter"><img alt="Total Downloads" src="https://img.shields.io/packagist/dt/tombenevides/dump-linter"></a>
  <a href="https://packagist.org/packages/tombenevides/dump-linter"><img alt="Latest Version" src="https://img.shields.io/packagist/v/tombenevides/dump-linter"></a>
  <a href="https://packagist.org/packages/tombenevides/dump-linter"><img alt="License" src="https://img.shields.io/packagist/l/tombenevides/dump-linter"></a>
</p>

---

Sometimes you are debugging and end up deploying with your code a `dump`or a `var_dump` (if you're a Laravel dev, the infamous `dd`) and that could be annoying, so **Dump Linter** is a package that complements [PHP-CS-Fixer](https://github.com/PHP-CS-Fixer/PHP-CS-Fixer), providing a rule to remove dump statements from the source code.

> ❗ IMPORTANT:  the rule is considered risky by PHP-CS-Fixer metrics because technically `dump`/`var_dump` are not errors or bad writing, so be careful and use this rule if you're completely sure that you don't want them in the codebase.

## REQUIREMENTS

> **[PHP 8.1+](https://www.php.net/releases/)**
>
> **[PHP-CS-Fixer 3](https://github.com/PHP-CS-Fixer/PHP-CS-Fixer)**

## HOW TO INSTALL

To install the package, jus use [composer](https://getcomposer.org):

```bash
composer require tombenevides/dump-linter
```

## HOW TO USE


### Configuring PHP-CS-Fixer

After installing, you need to edit the `.php-cs-fixer.dist.php` file (or the file that you're chose), adding the custom rule using `registerCustomFixers()` function and then set the rule, as you can see below:

```php
$config = new PhpCsFixer\Config();

return $config
    ->registerCustomFixers([
        new \Tombenevides\DumpLinter\DumpRemovalFixer()
    ])
    ->setRules([
        '@PSR12' => true,
        'Tombenevides/dump_removal' => true,
        ...
    ])
```

More info or questions about PHP-CS-Fixer configuration file, just check [this link](https://github.com/PHP-CS-Fixer/PHP-CS-Fixer/blob/master/doc/config.rst).

### Running the linter with custom rule

Since this is a risky rule, the default command `php-cs-fixer fix -v` will not work. Therefore, to allow the rule to make the expected changes, you need to give the linter permission to perform risky actions. You do this by adding the `--allow risky=yes` flag.

## LICENSE

**Dump Linter** is a software under the [MIT License](LICENSE)

## UPDATES

👋 Follow the author [@devatreides](https://twitter.com/tongedev) on Twitter to know more about the last updates and other projects. Say Hi!
