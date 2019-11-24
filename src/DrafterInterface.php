<?php
/**
 * @author    hmaus
 * @since     2015-08-28
 * @copyright 2015 (c) Hendrik Maus
 * @package   DrafterPhp
 */

namespace Hmaus\DrafterPhp;

use Symfony\Component\Process\Process;

interface DrafterInterface
{
    /**
     * Set path to process by Drafter.
     *
     * @param string $path input apib file path, e.g. /your-service/docs/your-service.apib
     * @return $this
     */
    public function input($path);

    /**
     * Set output path.
     *
     * Drafter will write the abstract syntax tree to this location.
     * Make sure it is writable beforehand.
     *
     * Help:
     *   -o, --output save output AST into file (string [=])
     *
     * @param string $path output path
     * @return $this
     */
    public function output($path);

    /**
     * Set format option.
     *
     * Available formats:
     *   * yaml (default)
     *   * json
     *
     * Help:
     *   -f, --format output AST format (string [=yaml])
     *
     * @param string $format output format to set, e.g. 'json'
     * @return $this
     */
    public function format($format);

    /**
     * Set sourcemap argument.
     *
     * Drafter will export sourcemap in the Parse Result
     *
     * Help:
     *   -s, --sourcemap export sourcemap in the Parse Result
     *
     * @return $this
     */
    public function sourcemap();

    /**
     * Get drafter version.
     *
     * Note: Drafter will add a line break to the end of the string,
     * the return value will actually be "v0.1.9\n"
     *
     * Help:
     *   -v, --version print Drafter version
     *
     * @return $this
     */
    public function version();

    /**
     * Set validate option.
     *
     * Help:
     *   -l, --validate validate input only, do not print AST
     *
     * @return $this
     */
    public function validate();

    /**
     * Set use line number option.
     *
     * Help:
     *   -u, --use-line-num use line and row number instead of character index when printing annotation
     *
     * @return $this
     */
    public function useLineNum();

    /**
     * Build the process and return it without running it.
     *
     * The method will be called by `\DrafterPhp\DrafterInterface::run`
     * You can use it, to inspect the process before it is run.
     *
     * To run the process, pass it to `\DrafterPhp\DrafterInterface::run`,
     * the method will do exception handling for you and will return the result.
     *
     * @return Process
     */
    public function build();

    /**
     * Run Drafter command.
     *
     * todo the return value of this method behaves differently depending on the options passed to drafter
     *  i.e. if we do not set the --output option, the method will return the result as a string;
     *  if we provide it, the method will return null
     *  this needs to be taken into account for tests and documentation.
     *
     * @return string
     * @param Process $process (optional) the process obj if you fetched it from `\DrafterPhp\DrafterInterface::build`
     *                         Otherwise, the method will build the process on its own using the aforementioned method.
     * @throws \Exception
     */
    public function run(Process $process = null);

    /**
     * Get the raw associative options array.
     *
     * E.g.:
     * ```php
     * ['--output' => 'path', '--format' => 'json']
     * ```
     *
     * @return string[]
     */
    public function getOptions();

    /**
     * Reset the argument list to not keep any state.
     *
     * @return $this;
     */
    public function resetOptions();

    /**
     * Get the binary path that was set.
     *
     * @return string
     */
    public function getBinary();

    /**
     * Set the path to the Drafter binary.
     * This method will neither check if the binary exists, nor will it do any other validation.
     *
     * @param string $binary
     * @return $this
     */
    public function setBinary($binary);

    /**
     * Get input file path.
     *
     * @return string[]
     */
    public function getInput();

    /**
     * Reset input file path.
     *
     * @return $this
     */
    public function resetInput();
}
