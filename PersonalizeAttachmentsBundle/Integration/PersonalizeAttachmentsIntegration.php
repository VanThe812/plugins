<?php

/*
 * @author      FFC_HOU
 *
 * @license     GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */

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
    public function appendToForm(&$builder, $data, $formArea) {
        if ($formArea == 'features') {
            $builder->add('choice_type', 'choice', [
                'choices' => [
                    'local'    => 'System',
                    'icloud'   => 'Cloud',
                ],
                'label'       => 'Attachment personalization file saving type',
                'label_attr'  => ['class' => 'control-label'],
                'attr'        => ['class' => 'form-control'], 
            ]);
        }
    }   

}