<?php

namespace Phpprc\Extension\Template\Command;

use Phpprc\Extension\Template\Service\TemplateApply;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class TemplateApplyCommand extends Command
{
    /**
     * @var TemplateApply
     */
    private $apply;

    public function __construct(TemplateApply $apply)
    {
        parent::__construct();
        $this->apply = $apply;
    }

    protected function configure()
    {
        $this->setName('template:apply');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->apply->apply();
    }
}
