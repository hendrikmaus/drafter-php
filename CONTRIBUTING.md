# Contributing to Dafter PHP

Please note that this project is released with a
[Contributor Code of Conduct](http://contributor-covenant.org/version/1/2/0/).
By participating in this project you agree to abide by its terms.

## Reporting Issues

Before you report any issue, please make sure that you actually deal with an issue of drafter-php
and not drafter itself.

You can most likely verify this by running the command you are dealing with manually against your drafter
binary.

You can access the command that drafter-php will execute, by not executing `\DrafterPhp\DrafterInterface::run`
right away; you can call `\DrafterPhp\DrafterInterface::build` instead to receive the Process instance.
Call `\Symfony\Component\Process\Process::getCommandLine` on the process instance to get the exact command line
that drafter-php would run.

E.g.:

```php
$process = $drafter
 ->input('blueprint.apib')
 ->format('json')
 ->output('ast.json')
 ->build();
 
 $command = $process->getCommandLine();
```

## Installation from Source

Prior to contributing to drafter-php, you must be able to run the test suite.
To achieve this, you need to acquire the drafter-php source code and install drafter itself:

1. Run `git clone https://github.com/hendrikmaus/drafter-php.git`
2. Get [composer](https://getcomposer.org/)
3. `cd drafter-php && composer install`

Composer will take care of installing all required dependencies, including drafter.
Watch the command output to spot errors.

To quickly verify that drafter was successfully compiled and installed, run `vendor/bin/drafter --help`
when in the drafter-php directory.

Drafter-php uses [robo](http://robo.li/) for a task runner.  
You can execute the test suite by running `vendor/bin/robo test` or `vendor/bin/phpunit`
when inside the drafter-php directory.

> You can install [robo](http://robo.li/) globally for convenience,
> to just run `robo test`

Robo also allows you to watch files during development. Run `robo watch` when inside the drafter-php
directory and leave that window open. Change a file in `src` or `test` to see the test suite auto-run.

Feel free to add useful tasks to the `RoboFile.php` in the project root.

## Contributing policy

Fork the project, create a feature branch, and send us a pull request.

To ensure a consistent code base, you should make sure the code follows
the [PSR-2 Coding Standards](http://www.php-fig.org/psr/psr-2/). You can also
run [php-cs-fixer](https://github.com/FriendsOfPHP/PHP-CS-Fixer) with the
configuration file that can be found in the project root directory.

If you would like to help, take a look at the [list of open issues](https://github.com/hendrikmaus/drafter-php/issues).
