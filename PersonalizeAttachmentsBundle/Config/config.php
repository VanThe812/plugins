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
        //url  ma yeu cau phai login moi co the vao(se them /s/ va url)
        
    ),
    'menu'     => array(
        
       
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
    ),

);