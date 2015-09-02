# Drafter PHP Binding
PHP wrapper for [drafter](https://github.com/apiaryio/drafter) API Blueprint Parser.

[travis] [versioneye] [codeclimate]

## What is drafter-php?
Drafter-php allows you to use use the [drafter](https://github.com/apiaryio/drafter) API Blueprint Parser
with your PHP application.

In a nutshell: you can convert [API Blueprint](http://apiblueprint.org/) files to 
Abstract Syntax Trees in JSON or YAML format.

[API Blueprint](http://apiblueprint.org/) is a webservice documentation language built on top of 
[Markdown](https://en.wikipedia.org/wiki/Markdown).

## Requirements
* PHP 5.4 or greater
* Drafter v0.1.9 [command line tool](https://github.com/apiaryio/drafter#drafter-command-line-tool)

## What Is What
**Drafter** is a C++ tool to parse API Blueprint.  
**Drafter-php** is a PHP wrapper around the **Drafter command line tool**.

## Installation
The recommended way to install Drafter-php is by using [composer](https://getcomposer.org):

```bash
$ composer require hmaus/drafter-php
```

This will install the PHP package with your application.  
Please keep in mind that **Drafter is not included**.

### Install Drafter Command Line Tool using Composer
The Drafter repository itself has a section on [installing drafter](https://github.com/apiaryio/drafter#install) it.

Another way of installing drafter, is using a [composer script](https://getcomposer.org/doc/articles/scripts.md).  
If you do not already have, add a `scripts` section to your root composer.json:

```json
"scripts": {
    "post-install-cmd": [
        "if ! [[ -d ext/drafter ]]; then echo \"### Installing drafter to ./ext; drafter bin to ./vendor/bin/ ###\"; fi",
        "if ! [[ -d ext/drafter ]]; then git clone --branch v0.1.9 --recursive https://github.com/apiaryio/drafter.git ext/drafter; fi",
        "if ! [[ -d vendor/bin ]]; then mkdir -p vendor/bin; fi",
        "if ! [[ -f vendor/bin/drafter ]]; then cd ext/drafter && ./configure && make drafter; fi",
        "if ! [[ -f vendor/bin/drafter ]]; then cd vendor/bin && ln -s ../../ext/drafter/bin/drafter drafter; fi"
    ]
}
```

> Note: there is an open Composer feature request for downloading binaries and 
> compiling from source: https://github.com/composer/composer/issues/4381

You would see this method used by default, when [contributing to drafter-php](CONTRIBUTING.md).
Installing Drafter using composer has only been tested on Mac OS X and Linux (Ubuntu 12).

If you have issues or questions regarding Drafter, please turn to 
the [Drafter repository](https://github.com/apiaryio/drafter).

## Usage of Drafter-php
1. Get an instance of the `\DrafterPhp\DrafterInterface` implementation, `\DrafterPhp\Drafter`
1.1 You will need to pass the path to your drafter binary to the constructor
1.2 It is recommended to solve this using a dependency injection container
2. Set the inputPath file and options on your `\DrafterPhp\Drafter` instance
2.1 Drafter-php currently does not support passing blueprint code directly to Drafter;
    it has to be stored in a file at this time
3. Run your command
    
### Examples

#### Parse your-service.apib into your-service.ast.json

```php
$drafter
    ->inputPath('your-service.apib')
    ->format('json')
    ->output('your-service.ast.json')
    ->run();
```

#### Parse your-service.apib into a PHP data structure

```php
$ast = $drafter
    ->inputPath('your-service.apib')
    ->format('json')
    ->run();
    
$phpObj = json_decode($ast);
$phpArr = json_decode($ast, true);
```

#### Parse your-service.apib into YAML format

```php
$drafter
    ->inputPath('your-service.apib')
    ->format('yaml') // optional as yaml is the default
    ->output('your-service.ast.yml')
    ->run();
```

#### Get Process before it is run

```php
$process = $drafter
    ->inputPath('your-service.apib')
    ->format('json')
    ->output('your-service.ast.json')
    ->build();

// do stuff with the process

$drafter
    ->run($process);
```

## Feature Roadmap
Do not hesitate to [contribute](https://github.com/hendrikmaus/drafter-php/blob/master/CONTRIBUTING.md).

* [] support passing raw api blueprint code, rather than always a file path

# Todo
* [] create travis config
* [] spec out readme
* [] check package into packagist
* [] code climate
* [] create a pull request on drafter repo and add this project as a binding for PHP


## License
Drafter-php is licensed under the MIT License - see the [LICENSE](https://github.com/hendrikmaus/drafter-php/blob/master/LICENSE) file for details
