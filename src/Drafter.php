<?php
/**
 * Access to the drafter binary.
 *
 * This component will provide a PHP interface to the drafter binary.
 *
 * ```php
 * $ast = $drafter
 *  ->input('blueprint.apib')
 *  ->format('json')
 *  ->output('ast.json')
 *  ->run();
 * ```
 *
 * Once drafter is configured, the object instance will not reset its
 * arguments and options.
 * So running `$drafter->run()` again immediately, will return the very same result.
 *
 * This behaviour allows you to re-use a drafter instance without minimal config change per call.
 *
 * More about the internals of this wrapper:
 * Output of `drafter --help`:
 *
 * ```
 * usage: drafter [options] ... <input file>
 *
 * API Blueprint Parser
 * If called without <input file>, 'drafter' will listen on stdin.
 *
 * options:
 * -o, --output          save output Parse Result into file (string [=])
 * -f, --format          output format of the Parse Result (yaml|json) (string [=yaml])
 * -t, --type            type of the Parse Result (refract|ast) (string [=refract])
 * -s, --sourcemap       export sourcemap in the Parse Result
 * -h, --help            display this help message
 * -v, --version         print Drafter version
 * -l, --validate        validate input only, do not output Parse Result
 * -u, --use-line-num    use line and row number instead of character index when printing annotation
 * ```
 *
 * @author    hmaus
 * @since     2015-08-28
 * @copyright 2015 (c) Hendrik Maus
 * @package   DrafterPhp
 */

namespace Hmaus\DrafterPhp;

use Symfony\Component\Process\Process;

class Drafter implements DrafterInterface
{
    /**
     * @var string
     */
    private $binary;

    /**
     * Collect options, e.g. output, format etc.
     *
     * Format:
     *   '--option-name' => 'option value'
     *   '--output'      => 'path/to/output/file'
     *
     * @var string[]
     */
    private $options = [];

    /**
     * Input file path to pass into drafter as argument.
     *
     * @var string
     */
    private $input;

    /**
     * Create a drafter wrapper by passing the path to your drafter bin.
     *
     * Hint:
     *  You can usually reflect this with your dependency injection container.
     *
     * @param string $binPath Path to the drafter binary
     */
    public function __construct($binPath)
    {
        $this->binary = $binPath;
    }

    public function input($path)
    {
        $this->input = $path;

        return $this;
    }

    public function output($path)
    {
        $this->options['--output'] = $path;

        return $this;
    }

    public function format($format)
    {
        $this->options['--format'] = $format;

        return $this;
    }

    public function sourcemap()
    {
        $this->options['--sourcemap'] = '';

        return $this;
    }

    public function version()
    {
        $this->options['--version'] = '';

        return $this;
    }

    public function validate()
    {
        $this->options['--validate'] = '';

        return $this;
    }

    public function useLineNum()
    {
        $this->options['--use-line-num'] = '';

        return $this;
    }

    public function build()
    {
        $this->validateOptionsAndArguments();

        $process = Process::fromShellCommandline(
            $this->getProcessCommand()
        );

        return $process;
    }

    public function run(Process $process = null)
    {
        if (null === $process) {
            $process = $this->build();
        }

        $process->run();

        if ($process->getExitCode() !== 0) {
            throw new \Exception($process->getErrorOutput());
        }

        return $process->getOutput();
    }

    public function getOptions()
    {
        return $this->options;
    }

    public function resetOptions()
    {
        $this->options = [];

        return $this;
    }

    public function getBinary()
    {
        return $this->binary;
    }

    public function setBinary($binary)
    {
        $this->binary = $binary;

        return $this;
    }

    public function getInput()
    {
        return $this->input;
    }

    public function resetInput()
    {
        $this->input = null;

        return $this;
    }

    /**
     * Check the configuration of the object prior to executing the process.
     *
     * As we do not support listening to stdin, drafter must not be called
     * without an input argument.
     *
     * If the version is requested, we do not require
     * the input argument as it will be ignored by drafter anyway.
     *
     * @throws \Exception
     */
    private function validateOptionsAndArguments()
    {
        if ($this->isVersionOptionSet()) {
            return;
        }

        if (!$this->input) {
            throw new \Exception("Input argument missing");
        }
    }

    /**
     * Helper to find out if the --version option was set.
     *
     * @return bool
     */
    private function isVersionOptionSet()
    {
        return array_key_exists('--version', $this->options);
    }

    /**
     * Get command to pass it into the process.
     *
     * The method will append the input file path argument to the end, like
     * described in the `drafter --help` output.
     *
     * @return string
     */
    private function getProcessCommand()
    {
        $options   = $this->transformOptions();
        $options[] = escapeshellarg($this->input);

        $command = escapeshellarg($this->binary) . ' ' . implode(' ', $options);

        return $command;
    }

    /**
     * Return options prepared to be passed into the Process.
     *
     * E.g.: ["--output" => "path/to/file"] -> ["--output=path/to/file"]
     *
     * The original format is an associative array, where the key is the
     * option name and the value is the respective value.
     * The process will want those as single strings to escape them
     * for the command line. Hence, we have to turn ["--output" => "path/to/file"]
     * into ["--output=path/to/file"].
     *
     * @return \string[]
     */
    private function transformOptions()
    {
        $processOptions = [];

        foreach ($this->options as $key => $value) {
            $option = $key;

            if ($value) {
                $option .= '=' . escapeshellarg($value);
            }

            $processOptions[] = $option;
        }

        return $processOptions;
    }
}
