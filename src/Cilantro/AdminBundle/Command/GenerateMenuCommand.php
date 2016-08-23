<?php

namespace Cilantro\AdminBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

use Cilantro\AdminBundle\Service\YoutubeService;

class GenerateMenuCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this->setName('menu:generate')
            ->setDescription('Generate the menu')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->getApplication()->getKernel()->getContainer()->get('menu')->generate();
    }
}