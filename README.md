# Drafter PHP Wrapper
PHP wrapper for [Drafter](https://github.com/apiaryio/drafter) API Blueprint Parser harness.

[![Minimum PHP Version](https://img.shields.io/badge/php-%3E%3D%205.6-8892BF.svg)](https://php.net/)
[![Build Status](https://travis-ci.org/hendrikmaus/drafter-php.svg?branch=master)](https://travis-ci.org/hendrikmaus/drafter-php)
[![codecov.io](http://codecov.io/github/hendrikmaus/drafter-php/coverage.svg?branch=master)](http://codecov.io/github/hendrikmaus/drafter-php?branch=master)
[![Dependency Status](https://www.versioneye.com/user/projects/55e7ed98211c6b00190007d2/badge.svg?style=flat)](https://www.versioneye.com/user/projects/55e7ed98211c6b00190007d2) 
[![Code Climate](https://img.shields.io/codeclimate/github/kabisaict/flow.svg)](https://codeclimate.com/github/hendrikmaus/drafter-php)

## What is Drafter-php?
Drafter-php allows you to use use the [drafter](https://github.com/apiaryio/drafter) API Blueprint Parser harness
with your PHP application.

In a nutshell: you can convert [API Blueprint](http://apiblueprint.org/) files to 
[refract] Abstract Syntax Trees in JSON or YAML format.

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
The Drafter repository itself has a section on [installing drafter](https://github.com/apiaryio/drafter#install) it.

Another way of installing Drafter, is using a [composer script](https://getcomposer.org/doc/articles/scripts.md).  
If you do not already have, add a `scripts` section to your root composer.json:

```json
"scripts": {
    "post-install-cmd": [
        "if ! [[ -d ext/drafter ]]; then echo \"### Installing drafter to ./ext; drafter bin to ./vendor/bin/ ###\"; fi",
        "if ! [[ -d ext/drafter ]]; then git clone --branch v2.2.0 --recursive https://github.com/apiaryio/drafter.git ext/drafter; fi",
        "if ! [[ -d vendor/bin ]]; then mkdir -p vendor/bin; fi",
        "if ! [[ -f vendor/bin/drafter ]]; then cd ext/drafter && ./configure && make drafter; fi",
        "if ! [[ -f vendor/bin/drafter ]]; then cd vendor/bin && ln -s ../../ext/drafter/bin/drafter drafter; fi"
    ]
}
```

> Note: the above example checks out a specific given tag `v2.2.0`

Now run `composer install`; it should start building drafter within an `ext/` folder in your project root.
If you want the script to put drafter somewhere else, modify every occurrence of `ext/drafter` to another one.

> Note: there is an open Composer feature request for downloading binaries and 
> compiling from source: https://github.com/composer/composer/issues/4381

You would see this method used by default, when [contributing to drafter-php](CONTRIBUTING.md).
Installing Drafter using composer has only been tested on **Mac OS X and Linux (Ubuntu 12)**.

If you have issues or questions regarding Drafter, please turn to 
the [Drafter repository](https://github.com/apiaryio/drafter).

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

The result will look similar (json format):

```json
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
                            "classes": "messageBody"
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
```

Setting the type option to 'ast', results in this abstract syntax tree:

> type 'refract' is the default since since drafter v1.0.0

```json
{
  "_version": "4.0",
  "metadata": [],
  "name": "",
  "description": "",
  "element": "category",
  "resourceGroups": [
    {
      "name": "",
      "description": "",
      "resources": [
        {
          "element": "resource",
          "name": "",
          "description": "",
          "uriTemplate": "/message",
          "model": {},
          "parameters": [],
          "actions": [
            {
              "name": "",
              "description": "",
              "method": "GET",
              "parameters": [],
              "attributes": {
                "relation": "",
                "uriTemplate": ""
              },
              "content": [],
              "examples": [
                {
                  "name": "",
                  "description": "",
                  "requests": [],
                  "responses": [
                    {
                      "name": "200",
                      "description": "",
                      "headers": [
                        {
                          "name": "Content-Type",
                          "value": "text/plain"
                        }
                      ],
                      "body": "Hello World!\n",
                      "schema": "",
                      "content": [
                        {
                          "element": "asset",
                          "attributes": {
                            "role": "bodyExample"
                          },
                          "content": "Hello World!\n"
                        }
                      ]
                    }
                  ]
                }
              ]
            }
          ],
          "content": []
        }
      ]
    }
  ],
  "content": [
    {
      "element": "category",
      "content": [
        {
          "element": "resource",
          "name": "",
          "description": "",
          "uriTemplate": "/message",
          "model": {},
          "parameters": [],
          "actions": [
            {
              "name": "",
              "description": "",
              "method": "GET",
              "parameters": [],
              "attributes": {
                "relation": "",
                "uriTemplate": ""
              },
              "content": [],
              "examples": [
                {
                  "name": "",
                  "description": "",
                  "requests": [],
                  "responses": [
                    {
                      "name": "200",
                      "description": "",
                      "headers": [
                        {
                          "name": "Content-Type",
                          "value": "text/plain"
                        }
                      ],
                      "body": "Hello World!\n",
                      "schema": "",
                      "content": [
                        {
                          "element": "asset",
                          "attributes": {
                            "role": "bodyExample"
                          },
                          "content": "Hello World!\n"
                        }
                      ]
                    }
                  ]
                }
              ]
            }
          ],
          "content": []
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
