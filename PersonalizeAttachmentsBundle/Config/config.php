<?php
// plugins/PersonalizeAttachmentsBundle/Config/config.php

/*
 * @author      FFC_HOU
 *
 * @license     GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */

return array(
    'name'        => 'Personalize attachments',
    'description' => 'Personalize attachments for Marketing Automation Mautic software.',
    'author'      => 'FFC_HOU',
    'version'     => '1.0.0',
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
     
        'models' => [
            'mautic.personalizeattachments.model.asset' => [
                'class'     => MauticPlugin\PersonalizeAttachmentsBundle\Model\AssetModel::class,
                'arguments' => [
                ],
            ],
        ],
        
        'integrations' => [
            'personalizeattachments.integration.helloworld' => [
                'class' => \MauticPlugin\PersonalizeAttachmentsBundle\Integration\PersonalizeAttachmentsIntegration::class,
                'tags'  => [
                    'mautic.basic_integration',
                ],
            ],
            
        ],
    ),

);