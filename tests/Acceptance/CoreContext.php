<?php

namespace Phpprc\Tests\Acceptance;

use Behat\Gherkin\Node\PyStringNode;
use Behat\Behat\Tester\Exception\PendingException;
use Behat\Behat\Context\Context;
use Phpactor\TestUtils\Workspace;
use RuntimeException;
use Symfony\Component\Process\Process;

class CoreContext implements Context
{
    /**
     * @var Workspace
     */
    private $workspace;

    /**
     * @BeforeScenario
     */
    public function __construct()
    {
        $this->workspace = Workspace::create(__DIR__ . '/Workspace');
        $this->workspace->reset();
    }

    /**
     * @Given the file :path:
     */
    public function theFileExists($path, PyStringNode $string)
    {
        $this->workspace->put($path, (string) $string);
    }

    /**
     * @Given the following config:
     */
    public function theFollowingConfig(PyStringNode $string)
    {
        $this->workspace->put('phpprc.json', (string) $string);
    }

    /**
     * @When I execute :args
     */
    public function iExecute($args)
    {
        $process = new Process(__DIR__ . '/../../bin/phpprc ' . $args);
        $process->setWorkingDirectory($this->workspace->path('/'));
        $process->run();

        if ($process->getExitCode() !== 0) {
            throw new RuntimeException(sprintf(
                'Phpprc did not exit with 0 code, got "%s":%s%s',
                $process->getExitCode(),
                PHP_EOL,
                $process->getErrorOutput()
            ));
        }
    }

    /**
     * @Then file :arg1 should exist with contents:
     */
    public function fileShouldExistWithContents($arg1, PyStringNode $string)
    {
        throw new PendingException();
    }
}
