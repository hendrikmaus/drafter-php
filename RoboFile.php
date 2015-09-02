<?php
/**
 * @author    hmaus
 * @since     2015-08-28
 * @copyright 2015 (c) Hendrik Maus
 * @license   All rights reserved.
 * @package   DrafterPhp
 */

class RoboFile extends \Robo\Tasks
{
    /**
     * Watch `src` and `tests` -> run tests whenever there is a change
     */
    public function watch()
    {
        $this->test();

        $this
            ->taskWatch()
            ->monitor(
                ['src', 'tests'],
                function () {
                    $this->test();
                }
            )
            ->run();
    }

    /**
     * Run drafter php test suite
     */
    public function test()
    {
        $this
            ->taskPHPUnit('vendor/bin/phpunit')
            ->configFile('phpunit.xml')
            ->run();
    }
}
