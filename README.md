# Drafter PHP Wrapper
PHP wrapper for [Drafter](https://github.com/apiaryio/drafter) API Blueprint Parser harness.

[![Minimum PHP Version](https://img.shields.io/badge/php-%3E%3D%205.6-8892BF.svg)](https://php.net/)
[![codecov.io](http://codecov.io/github/hendrikmaus/drafter-php/coverage.svg?branch=master)](http://codecov.io/github/hendrikmaus/drafter-php?branch=master)
<a href="https://codeclimate.com/github/hendrikmaus/drafter-php/maintainability"><img src="https://api.codeclimate.com/v1/badges/f999a508bd1bf8f0cbf7/maintainability" /></a>

## What is Drafter-php?
Drafter-php allows you to use use the [drafter](https://github.com/apiaryio/drafter) API Blueprint Parser harness
with your PHP application.

In a nutshell: you can convert [API Blueprint](http://apiblueprint.org/) files to parse result.

[API Blueprint](http://apiblueprint.org/) is a webservice documentation language built on top of 
[Markdown](https://en.wikipedia.org/wiki/Markdown).

## Requirements
* PHP 5.6 or greater
* Drafter [command line tool](https://github.com/apiaryio/drafter#drafter-command-line-tool)

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
Head over to [hmaus/drafter-installer](https://github.com/hendrikmaus/drafter-installer).

## Usage of Drafter-php
1. Get an instance of the `\DrafterPhp\DrafterInterface` implementation, `\DrafterPhp\Drafter`
1.1 You will need to pass the path to your drafter binary to the constructor
1.2 It is recommended to solve this using a dependency injection container
2. Set the input file and options on your `\DrafterPhp\Drafter` instance
2.1 Drafter-php currently does not support passing blueprint code directly to Drafter;
    it has to be stored in a file at this time
3. Run your command
    
### Input / Output Examples

> Note: drafter-php does not assert the structure of the output.
> If you see differences in the examples to your actual output, please refer to the official drafter docs.

Given this api blueprint source:

```apib
# GET /message
+ Response 200 (text/plain)

        Hello World!
```

The result will look similar (json refract):

```json
{
  "element": "parseResult",
  "content": [
    {
      "element": "category",
      "meta": {
        "classes": [
          "api"
        ],
        "title": ""
      },
      "content": [
        {
          "element": "category",
          "meta": {
            "classes": [
              "resourceGroup"
            ],
            "title": ""
          },
          "content": [
            {
              "element": "resource",
              "meta": {
                "title": ""
              },
              "attributes": {
                "href": "/message"
              },
              "content": [
                {
                  "element": "transition",
                  "meta": {
                    "title": ""
                  },
                  "content": [
                    {
                      "element": "httpTransaction",
                      "content": [
                        {
                          "element": "httpRequest",
                          "attributes": {
                            "method": "GET"
                          },
                          "content": []
                        },
                        {
                          "element": "httpResponse",
                          "attributes": {
                            "statusCode": "200",
                            "headers": {
                              "element": "httpHeaders",
                              "content": [
                                {
                                  "element": "member",
                                  "content": {
                                    "key": {
                                      "element": "string",
                                      "content": "Content-Type"
                                    },
                                    "value": {
                                      "element": "string",
                                      "content": "text/plain"
                                    }
                                  }
                                }
                              ]
                            }
                          },
                          "content": [
                            {
                              "element": "asset",
                              "meta": {
                                "classes": [
                                  "messageBody"
                                ]
                              },
                              "attributes": {
                                "contentType": "text/plain"
                              },
                              "content": "Hello World!\n"
                            }
                          ]
                        }
                      ]
                    }
                  ]
                }
              ]
            }
          ]
        }
      ]
    }
  ]
}
```

### Code Examples

> Found something wrong? Feel free to [contribute](https://github.com/hendrikmaus/drafter-php/blob/master/CONTRIBUTING.md)

#### Make sure it works
To make sure it works, we'll ask Drafter for the current version.

```php
$version = $drafter
    ->version()
    ->run();

// Reset options on the command
$drafter->resetOptions();
```
`$version` should now contain a string like `v1.0.0`.
 If something is wrong, an exception will have been thrown most likely.
 
 > Keep in mind that Drafter-php is designed to keep its state,
 > run `\DrafterPhp\DrafterInterface::resetOptions` to get rid of the version option you just set
 > for the next call on the instance.

#### Parse your-service.apib into your-service.refract.json
Make sure your input path is correct and readable, and your output path is writable.

```php
$drafter
    ->input('your-service.apib')
    ->format('json')
    ->type('refract')
    ->output('your-service.refract.json')
    ->run();
```

#### Parse your-service.apib into your-service.ast.json
Make sure your input path is correct and readable, and your output path is writable.

```php
$drafter
    ->input('your-service.apib')
    ->format('json')
    ->output('your-service.ast.json')
    ->run();
```

#### Parse your-service.apib into a PHP data structure

```php
$refract = $drafter
    ->input('your-service.apib')
    ->format('json')
    ->run();
    
$phpObj = json_decode($refract);
$phpArr = json_decode($refract, true);
```

#### Parse your-service.apib into YAML format

```php
$drafter
    ->input('your-service.apib')
    ->format('yaml') // optional as yaml is the default
    ->output('your-service.ast.yml')
    ->run();
```

#### Get Process before it is run

```php
$process = $drafter
    ->input('your-service.apib')
    ->format('json')
    ->output('your-service.refract.json')
    ->build();

// do stuff with the process

$drafter
    ->run($process);
```

## Feature Roadmap
Do not hesitate to [contribute](https://github.com/hendrikmaus/drafter-php/blob/master/CONTRIBUTING.md).

* [ ] support passing raw api blueprint code into `\DrafterPhp\DrafterInterface::input`, rather than always a file path

## License
Drafter-php is licensed under the MIT License - see the 
[LICENSE](https://github.com/hendrikmaus/drafter-php/blob/master/LICENSE) file for details
