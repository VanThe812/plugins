<?php


// Check if the request is Ajax
if (!$app->getRequest()->isXmlHttpRequest()) {
    
    $view->extend('MauticCoreBundle:Default:content.html.php');
    $view['slots']->set('headerTitle', 'Attachments');
    $view['slots']->set('mauticContent', 'plugin_asset');
    $view['slots']->set(
        'actions',
        $view->render(
            'MauticCoreBundle:Helper:page_actions.html.php',
            [
                'templateButtons' => [
                    'new' => $permissions['plugin:personalizeattachments:asset:create'],
                ],
                'route' => 'plugin_personalizeattachments_asset_action',
                'langVar'   => 'asset.asset',
            ]
        )
    );
}
?>
<div class="panel panel-default bdr-t-wdh-0 mb-0">
    <?php echo $view->render('MauticCoreBundle:Helper:list_toolbar.html.php', [
        'searchValue' => "",
        'action'      => $currentRoute,
        'searchHelp'  => 'heeee',
    ]); ?>
    <div class="page-list">
        
    </div>
</div>
