<?php

namespace Phpprc\Tests\Acceptance;

use Behat\Gherkin\Node\PyStringNode;
use Behat\Behat\Context\Context;
use PHPUnit\Framework\Assert;
use Phpactor\TestUtils\Workspace;
use Phpprc\Extension\Core\Console\Application;
use Phpprc\Phpprc;
use Symfony\Component\Console\Input\StringInput;
use Symfony\Component\Console\Output\BufferedOutput;

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
        $this->workspace = Workspace::create(__DIR__ . '/../Workspace');
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
        $input = new StringInput($args);
        $output = new BufferedOutput();
        $application = (new Phpprc())->container($this->workspace->path('/'))->get(Application::class);
        $application->setAutoExit(false);
        $application->setCatchExceptions(false);
        $application->run($input, $output);
    }

    /**
     * @Then file :arg1 should exist with contents:
     */
    public function fileShouldExistWithContents($arg1, PyStringNode $string)
    {
        Assert::assertEquals((string) $string, $this->workspace->getContents($arg1));
    }
}
