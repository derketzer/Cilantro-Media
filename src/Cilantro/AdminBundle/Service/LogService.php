<?php

namespace Cilantro\AdminBundle\Service;

use Doctrine\Bundle\DoctrineBundle\Registry as Doctrine;
use Monolog\Handler\SlackHandler;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Symfony\Component\DependencyInjection\Container;

class LogService
{
    private $container;
    private $logger;
    private $logLevel = Logger::INFO;
    private $slackChannel = '#cilantromedia';
    private $logService = 'slack';

    public function __construct(Container $container, $logService='')
    {
        $this->container = $container;

        $this->logger = new Logger('cilantromedia');

        if(!empty($logService))
            $this->logService = $logService;
    }

    public function init()
    {
        if($this->logService == 'slack') {
            $this->initSlackHandler();
        }else if($this->logService == 'log'){
            $this->logger->pushHandler(new StreamHandler($this->container->get('kernel')->getLogDir().'/telegram.log', Logger::DEBUG));
        }
    }

    public function infoMessage($message='')
    {
        if(!empty($message)){
            $this->logger->info($message);
        }
    }

    public function errorMessage($message='')
    {
        if(!empty($message)){
            $this->logger->error($message);
        }
    }

    private function initSlackHandler()
    {
        try {
            $slack = new SlackHandler($this->container->getParameter('slack_token'), $this->slackChannel, 'Cilantro Media');
            $slack->setLevel($this->logLevel);

            $this->logger->pushHandler($slack);
        }catch(\Exception $e){
            echo 'Error trying to initialize the slack handler!';
        }
    }

    public function setSlackChannel($channel)
    {
        if(!empty($channel))
            $this->slackChannel = $channel;
    }

    public function setLogService($logService='')
    {
        if(!empty($logService))
            $this->logService = $logService;
    }
}