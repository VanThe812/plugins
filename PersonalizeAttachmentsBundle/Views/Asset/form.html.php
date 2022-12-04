<?php


// Check if the request is Ajax
if (!$app->getRequest()->isXmlHttpRequest()) {
    
    $view->extend('MauticCoreBundle:Default:content.html.php');
    $view['slots']->set('headerTitle', 'New Attachments');
    // $view['slots']->set('mauticContent', 'plugin_asset');
    
}
?>

<?php echo $view['form']->start($form); ?>
<!-- start: box layout -->
<div class="box-layout">
    <!-- container -->
    <div class="col-md-9 bg-auto height-auto bdr-r">
        <div class="pa-md">
            <div class="row">
                <div class="col-md-12">
                    <div class="col-md-7 pl-0">
						<?php echo $view['form']->row($form['tempName']); ?>
					</div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php echo $view['form']->end($form); ?>