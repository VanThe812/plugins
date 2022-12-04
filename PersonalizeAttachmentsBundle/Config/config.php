<?php
// plugins/PersonalizeAttachmentsBundle/Config/config.php

return array(
    'name'        => 'Personalize attachments',
    'description' => 'Personalize attachments for Marketing Automation Mautic software.',
    'author'      => 'FFC_HOU',
    'version'     => '1.0.3',
    'routes'   => array(
        'main' => [
            //url  ma yeu cau phai login moi co the vao(se them /s/ va url)
            'plugin_personalizeattachments_asset_index' => array(
                'path'       => '/attachments/{page}',
                'controller' => 'PersonalizeAttachmentsBundle:Asset:index',
            ),
            'plugin_personalizeattachments_asset_action' => [
                'path'       => '/attachments/{objectAction}/{objectId}',
                'controller' => 'PersonalizeAttachmentsBundle:Asset:execute',
            ],
        ],
    ),
    'menu'     => array(
        'main' => array(
            'Attachment' => [
                'route'    => 'plugin_personalizeattachments_asset_index',
                'parent'   => 'mautic.core.channels',
                'access'   => 'plugin:personalizeattachments:asset:view',
                'priority' => 0,
            ],
            
        ),
       
    ),
    'services'    => array(
     
        'integrations' => [
            'personalizeattachments.integration.helloworld' => [
                'class' => \MauticPlugin\PersonalizeAttachmentsBundle\Integration\PersonalizeAttachmentsIntegration::class,
                'tags'  => [
                    'mautic.basic_integration',
                ],
            ],
            
        ],
        'forms' => [
            'plugin.form.type.asset' => [
                'class'     => 'MauticPlugin\PersonalizeAttachmentsBundle\Form\Type\AssetType',
                'arguments' => [
                    'translator',
                    'mautic.helper.theme',
                    'mautic.asset.model.asset',
                ],
                'alias' => 'plugin_asset',
            ],
            'plugin.form.type.personalize.config' => [
                'class' => 'MauticPlugin\MauticSocialBundle\Form\Type\ConfigType',
                'alias' => 'person_config',
            ],
        ],
        'models' => [
            'mautic.personalizeattachments.model.asset' => [
                'class'     => MauticPlugin\PersonalizeAttachmentsBundle\Model\AssetModel::class,
                'arguments' => [
                ],
            ],
        ],
        // 'events' => array(
        //     'plugin.attachments.leadbundle.subscriber' => array(
        //         'class' => 'MauticPlugin\PersonalizeAttachmentsBundle\EventListener\LeadSubscriber',
        //         'arguments'=> [
        //             'service_container',
        //         ]
        //     )
        // ),
    ),

);