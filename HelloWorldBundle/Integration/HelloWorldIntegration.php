<?php
namespace MauticPlugin\HelloWorldBundle\Integration;

use Mautic\PluginBundle\Integration\AbstractIntegration;

class HelloWorldIntegration extends AbstractIntegration
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
    public function getAuthenticationType()
    {
        // Just use none for now and I'll build in "basic" later
        return 'none';
    }


    // public function getRequiredKeyFields()
    // {
    //     return [
    //         'secret' => 'mautic.integration.gmail.secret',
    //     ];
    // }
}