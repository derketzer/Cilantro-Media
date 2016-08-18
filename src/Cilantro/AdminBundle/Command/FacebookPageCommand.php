<?php

namespace Cilantro\AdminBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class FacebookPageCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this->setName('facebook:page')
            ->setDescription('Update all pages from facebook')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->getApplication()->getKernel()->getContainer()->get('facebook')->getPages();
    }
}