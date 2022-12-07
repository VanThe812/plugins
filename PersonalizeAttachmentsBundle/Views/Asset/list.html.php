<?php

if ($tmpl == 'index') {
    $view->extend('PersonalizeAttachmentsBundle:Asset:index.html.php');
}
?>
<?php if (count($items)): ?>
    <div class="table-responsive">
        <table class="table table-hover table-striped table-bordered asset-list" id="attachmentsTable">
            <thead>
                <tr>
                    <?php
                    echo $view->render(
                        'MauticCoreBundle:Helper:tableheader.html.php',
                        [
                            'checkall'        => 'true',
                            'target'          => '#attachmentsTable',
                            'langVar'         => 'asset.asset',
                            'route'           => 'plugin_personalizeattachments_asset_action',
                            'templateButtons' => [
                                'delete' => $permissions['plugin:personalizeattachments:asset:deleteown'],
                            ],
                        ]
                    );
                    echo $view->render(
                        'MauticCoreBundle:Helper:tableheader.html.php',
                        [
                            'sessionVar' => 'attachments',
                            'orderBy'    => 'name',
                            'text'       => 'mautic.core.name',
                            'class'      => '',
                            'default'    => true,
                        ]
                    );
                    echo $view->render(
                        'MauticCoreBundle:Helper:tableheader.html.php',
                        [
                            'sessionVar' => 'attachments',
                            'orderBy'    => 'segmentId',
                            'text'       => 'mautic.core.filter.lists',
                            'class'      => '',
                            'default'    => true,
                        ]
                    );
                    echo $view->render(
                        'MauticCoreBundle:Helper:tableheader.html.php',
                        [
                            'sessionVar' => 'attachments',
                            'orderBy'    => 'count',
                            'text'       => 'Number of files',
                            'class'      => '',
                            'default'    => true,
                        ]
                    );
                    echo $view->render(
                        'MauticCoreBundle:Helper:tableheader.html.php',
                        [
                            'sessionVar' => 'attachments',
                            'orderBy'    => 'a.id',
                            'text'       => 'mautic.core.id',
                            'class'      => 'visible-md visible-lg col-asset-id',
                        ]
                    );
                    ?>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($items as $k => $item): ?>
                    <tr>
                        <td>
                            <?php 
                            echo $view->render(
                                'MauticCoreBundle:Helper:list_actions.html.php',
                                [
                                    'item'            => $item,
                                    'templateButtons' => [
                                        'edit' => $security->hasEntityAccess(
                                            $permissions['plugin:personalizeattachments:asset:editown'],
                                            $permissions['plugin:personalizeattachments:asset:editother'],
                                            $item->getCreatedBy()
                                        ),
                                        'delete' => $security->hasEntityAccess(
                                            $permissions['plugin:personalizeattachments:asset:deleteown'],
                                            $permissions['plugin:personalizeattachments:asset:deleteother'],
                                            $item->getCreatedBy()
                                        ),
                                    ],
                                    'route'     => 'plugin_personalizeattachments_asset_action',
                                    'langVar'       => 'asset.asset',
                                   
                                ]
                            );
                            ?>
                        </td>
                        <td>
                            <div>
                                <?php 
                                echo $view->render(
                                    'MauticCoreBundle:Helper:publishstatus_icon.html.php',
                                    [
                                        'item'  => $item,
                                        'model' => 'personalizeattachments.asset',
                                    ]
                                );
                                ?>
                                <a href="<?php echo $view['router']->path(
                                        'plugin_personalizeattachments_asset_action',
                                        ['objectAction' => 'view', 'objectId' => $item->getId()]
                                    ); ?>"
                                    data-toggle="ajax">
                                    <?php echo $item->getName(); ?>
                                </a>
                            </div>
                            <?php if ($description = $item->getDescription()): ?>
                            <div class="text-muted mt-4">
                                <small><?php echo $description; ?></small>
                            </div>
                            <?php endif; ?>
                        </td>
                        <td  class="visible-md visible-lg">
                            
                        </td>
                        <td class="visible-md visible-lg"><?php echo $item->getCountAttachment(); ?></td>
                        <td class="visible-md visible-lg"><?php echo $item->getId(); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="panel-footer">
        <?php echo $view->render(
            'MauticCoreBundle:Helper:pagination.html.php',
            [
                'totalItems' => count($items),
                'page'       => $page,
                'limit'      => $limit,
                'menuLinkId' => 'plugin_personalizeattachments_asset_index',
                'baseUrl'    => $view['router']->path('plugin_personalizeattachments_asset_index'),
                'sessionVar' => 'attachments',
            ]
        ); ?>
    </div>
<?php else: ?>
<?php echo $view->render('MauticCoreBundle:Helper:noresults.html.php', ['tip' => 'Content tip..........']); ?>
<?php endif; ?>