<?php 

use Mautic\CoreBundle\EventListener\CommonSubscriber;
use Symfony\Component\DependencyInjection\ContainerInterface;

class LeadSubscriber extends CommonSubscriber
{
    private $container;

    public function __construct(ContainerInterface $container){
        $this->container = $container;
    }
}