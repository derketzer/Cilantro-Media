<?php

namespace Cilantro\AdminBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class FacebookVideoCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this->setName('facebook:video')
            ->setDescription('Update all videos from facebook')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->getApplication()->getKernel()->getContainer()->get('facebook')->getVideos();
    }
}