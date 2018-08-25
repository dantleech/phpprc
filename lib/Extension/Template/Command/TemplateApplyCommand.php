<?php

namespace Phpprc\Extension\Template\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class TemplateApplyCommand extends Command
{
    protected function configure()
    {
        $this->setName('template:apply');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
    }
}
