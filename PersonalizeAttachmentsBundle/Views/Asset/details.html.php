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
$view['slots']->set('headerTitle', "Hiii");

// $view['slots']->set(
//     'actions',
//     $view->render(
//         'MauticCoreBundle:Helper:page_actions.html.php',
//         [
//             'item'            => $activeAsset,
//             'templateButtons' => [
//                 'edit' => $security->hasEntityAccess(
//                     $permissions['plugin:personalizeattachments:asset:editown'],
//                     $activeAsset->getCreatedBy()
//                 ),
//                 'clone'  => $permissions['plugin:personalizeattachments:asset:create'],
//                 'delete' => $security->hasEntityAccess(
//                     $permissions['plugin:personalizeattachments:asset:deleteown'],
//                     $activeAsset->getCreatedBy()
//                 ),
//                 'close' => $security->hasEntityAccess(
//                     $permissions['plugin:personalizeattachments:asset:viewown'],
//                     $permissions['plugin:personalizeattachments:asset:viewother'],
//                     $activeAsset->getCreatedBy()
//                 ),
//             ],
//             'route' => 'plugin_personalizeattachments_asset_action',
//             'langVar'    => 'asset.asset',
//             'nameGetter' => 'getName',
//         ]
//     )
// );

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
                        <div class="text-white dark-sm mb-0">123</div>
                    </div>
                </div>
            </div>
            <h1>hiii</h1>
            
            <!--/ asset detail header -->
            <!-- asset detail collapseable -->
            <div class="collapse" id="asset-details">
                <div class="pr-md pl-md pb-md">
                    <div class="panel shd-none mb-0">
                        <table class="table table-bordered table-striped mb-0">
                            <tbody>
                            <?php echo $view->render(
                                'MauticCoreBundle:Helper:details.html.php',
                                ['entity' => $activeAsset]
                            ); ?>
                            <tr>
                                <td width="20%"><span class="fw-b"><?php echo $view['translator']->trans(
                                            'mautic.asset.asset.size'
                                        ); ?></span></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td width="20%"><span class="fw-b"><?php echo $view['translator']->trans(
                                            'mautic.asset.asset.path.relative'
                                        ); ?></span></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td width="20%"><span class="fw-b"><?php echo $view['translator']->trans(
                                            'mautic.asset.filename.original'
                                        ); ?></span></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td width="20%"><span class="fw-b"><?php echo $view['translator']->trans(
                                            'mautic.asset.filename.'.$location
                                        ); ?></span></td>
                                <td></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!--/ asset detail collapseable -->
        </div>