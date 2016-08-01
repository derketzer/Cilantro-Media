<?php

namespace Cilantro\AdminBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

use Cilantro\AdminBundle\Service\YoutubeService;

class YoutubeVideoCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this->setName('youtube:video')
            ->setDescription('Update all youtube videos from all channels')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->getApplication()->getKernel()->getContainer()->get('youtube')->video();
    }
}