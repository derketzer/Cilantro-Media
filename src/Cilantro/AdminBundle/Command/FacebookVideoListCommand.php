<?php

namespace Cilantro\AdminBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class FacebookVideoListCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this->setName('facebook:videoList')
            ->setDescription('Update all videos list from facebook')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->getApplication()->getKernel()->getContainer()->get('facebook')->getVideoList();
    }
}