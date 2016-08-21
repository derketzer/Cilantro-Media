<?php

namespace Cilantro\AdminBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class YoutubeVideoTagCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this->setName('youtube:videoTag')
            ->setDescription('Update all youtube videos from all channels')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->getApplication()->getKernel()->getContainer()->get('youtube')->videoTags();
    }
}