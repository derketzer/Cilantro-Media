<?php

namespace Cilantro\AdminBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

use Cilantro\AdminBundle\Service\YoutubeService;

class YoutubeStatsCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this->setName('youtube:stats')
            ->setDescription('Update stats from all youtube videos from all channels')
            ->addArgument(
                'count',
                InputArgument::OPTIONAL,
                'Specify video count to update'
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $count = $input->getArgument('count');
        if ($count) {
            $this->getApplication()->getKernel()->getContainer()->get('youtube')->stats($count);
        } else {
            $this->getApplication()->getKernel()->getContainer()->get('youtube')->stats();
        }
    }
}