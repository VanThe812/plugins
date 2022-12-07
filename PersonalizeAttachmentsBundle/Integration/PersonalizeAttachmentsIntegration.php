<?php
namespace MauticPlugin\PersonalizeAttachmentsBundle\Integration;

use Mautic\PluginBundle\Integration\AbstractIntegration;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use OpenCloud\Rackspace;

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
        return 'plugins/PersonalizeAttachmentsBundle/Assets/images/logo.png';
    }
    public function getAuthenticationType()
    {
        // Just use none for now and I'll build in "basic" later
        return 'none';
    }

}