<?php
namespace MauticPlugin\PersonalizeAttachmentsBundle\Integration;

use Mautic\PluginBundle\Integration\AbstractIntegration;

class PersonalizeAttachmentsIntegration extends AbstractIntegration
{
    const NAME = 'PersonalizeAttachments';

    public function getName(): string
    {
        return self::NAME;
    }

    public function getDisplayName(): string
    {
        return 'Personalize Attachments';
    }

    public function getIcon(): string
    {
        return 'plugins/HelloWorldBundle/Assets/images/logo.jpg';
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