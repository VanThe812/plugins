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


    // public function getRequiredKeyFields()
    // {
    //     return [
    //         'add' => 'Địa chỉ lưu',
    //     ];
    // }
    public function appendToForm(&$builder, $data, $formArea){
        // $builder->add(
        //     'sandbox',
        //     'choice',
        //     [
        //         'choices' => [
        //             'sandbox' => 'Day la mot o checkbox',
        //         ],
        //         'expanded'    => true,
        //         'multiple'    => true,
        //         'label'       => 'Hãy chọn',
        //         'label_attr'  => ['class' => 'control-label'],
        //         'empty_value' => false,
        //         'required'    => false,
        //         'attr'        => [
        //             'onclick' => 'Mautic.postForm(mQuery(\'form[name="integration_details"]\'),\'\');',
        //         ],
        //     ]
        // );
        if ($formArea != 'features') {
            $builder->add(
                'type',
                'choice',
                [
                    'choices'    => [
                        'localhost'     => 'Localhost',
                    ],
                    'label'      => 'File đính kèm sẽ lưu ở',
                    'label_attr' => [
                        'class'       => 'control-label',
                        'data-toggle' => 'tooltip',
                        'title'       => 'Chọn ....',
                    ],
                    'multiple'   => false,
                    'required'   => true,
                ]
            );
        }
    }
   
}