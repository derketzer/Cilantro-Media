<?php

namespace Cilantro\AdminBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class YoutubeChannelCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this->setName('youtube:channel')
            ->setDescription('Update all youtube channels')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->getApplication()->getKernel()->getContainer()->get('youtube')->channel();
    }
}