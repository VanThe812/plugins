<?php

/*
 * @copyright   2014 Mautic Contributors. All rights reserved
 * @author      Mautic
 *
 * @link        http://mautic.org
 *
 * @license     GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */
$view->extend('MauticCoreBundle:Default:content.html.php');
$view['slots']->set('mauticContent', 'plugin_asset');
$view['slots']->set('headerTitle', $activeAsset->getName());

$view['slots']->set(
    'actions',
    $view->render(
        'MauticCoreBundle:Helper:page_actions.html.php',
        [
            'item'            => $activeAsset,
            'templateButtons' => [
                'edit' => $security->hasEntityAccess(
                    $permissions['plugin:personalizeattachments:asset:editown'],
                    $permissions['plugin:personalizeattachments:asset:editother'],
                    $activeAsset->getCreatedBy()
                ),
                'delete' => $security->hasEntityAccess(
                    $permissions['plugin:personalizeattachments:asset:deleteown'],
                    $permissions['plugin:personalizeattachments:asset:deleteother'],
                    $activeAsset->getCreatedBy()
                ),
                // 'close' => $security->hasEntityAccess(
                //     $permissions['plugin:personalizeattachments:asset:view'],
                //     $permissions['plugin:personalizeattachments:asset:viewown'],
                //     $permissions['plugin:personalizeattachments:asset:viewother'],
                //     $activeAsset->getCreatedBy()
                // ),
            ],
            'route' => 'plugin_personalizeattachments_asset_action',
            'langVar'    => 'asset.asset',
        ]
    )
);

// $view['slots']->set(
//     'publishStatus',
//     $view->render('MauticCoreBundle:Helper:publishstatus_badge.html.php', ['entity' => $activeAsset])
// );

?>
<div class="box-layout">
            <!-- left section -->
            <div class="col-md-9 bg-white height-auto">
            <div class="bg-auto">
            <!-- asset detail header -->
            <div class="pr-md pl-md pt-lg pb-lg">
                <div class="box-layout">
                    <div class="col-xs-10 va-m">
                        <div class="text-white dark-sm mb-0"><?php $activeAsset->getDescription() ?></div>
                    </div>
                </div>
            </div>

        </div>