<?php 
// plugins/PersonalizeAttachmentsBundle/Views/Asset/index.html.php

/*
 * @author      FFC_HOU
 *
 * @license     GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */

    $view->extend('MauticCoreBundle:Default:content.html.php');
    $view['slots']->set('headerTitle', 'Attachments');
    $view['slots']->set('mauticContent', 'plugin_asset');
    $view['slots']->set(
        'actions',
        $view->render(
            'MauticCoreBundle:Helper:page_actions.html.php',
            [
                'item'            => $activeAsset,
                'templateButtons' => [
                    'new' => $permissions['plugin:personalizeattachments:asset:create'],

                ],  
                'route' => 'plugin_personalizeattachments_asset_action',
                'langVar'   => 'asset.asset',
            ]
        )
    );    
?>
<div class="panel panel-default bdr-t-wdh-0 mb-0">
    <?php echo $view->render('MauticCoreBundle:Helper:list_toolbar.html.php', [
        'searchValue' => "",
        'action'      => $currentRoute,
        'searchHelp'  => 'heeee',
    ]); ?>
    <div class="page-list">
        <?php $view['slots']->output('_content'); ?>
    </div>
</div>
