<?php
namespace MauticPlugin\PersonalizeAttachmentsBundle\Integration;

use Mautic\PluginBundle\Integration\AbstractIntegration;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormBuilder;

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


    public function appendToForm(&$builder, $data, $formArea){

        if ($formArea == 'features') {
            // $name = $this->getName();
            // if ($this->factory->serviceExists('plugin.form.type.personalize.config')) {
            //     $builder->add('shareButton', 'personalize_config', [
            //         'label'    => 'Hmm',
            //     ]);
            // }
            $builder->add('choice_type', 'choice', [
                'choices' => [
                    'local'    => 'Local',
                    'icloud'   => 'Icloud',
                ],
                'label'       => 'Attachment personalization file saving type',
                'label_attr'  => ['class' => 'control-label'],
                'attr'        => ['class' => 'form-control'],
            ]);
    
            // $builder->add('text', 'text', [
            //     'label_attr' => ['class' => 'control-label'],
            //     'label'      => 'Path',
            //     'attr'       => [
            //         'class'       => 'form-control',
            //     ],
            // ]);
        }
    }
   
}