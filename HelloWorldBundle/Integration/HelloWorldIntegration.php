<?php
namespace MauticPlugin\HelloWorldBundle\Integration;

use MauticPlugin\IntegrationsBundle\Integration\BasicIntegration;
use MauticPlugin\IntegrationsBundle\Integration\Interfaces\BasicInterface;
use MauticPlugin\IntegrationsBundle\Integration\Interfaces\IntegrationInterface;

class HelloWorldIntegration extends BasicIntegration
{
    const NAME = 'HelloWorld';

    public function getName(): string
    {
        return self::NAME;
    }

    public function getDisplayName(): string
    {
        return 'Hello World';
    }

    public function getIcon(): string
    {
        return 'plugins/HelloWorldBundle/Assets/images/earth.png';
    }
}