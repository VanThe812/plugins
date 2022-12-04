<?php


// Check if the request is Ajax
if (!$app->getRequest()->isXmlHttpRequest()) {
    
    $view->extend('MauticCoreBundle:Default:content.html.php');
    echo $view['assets']->includeScript('plugins/PersonalizeAttachmentsBundle/Assets/js/asset.js');
    echo $view['assets']->includeStylesheet('plugins/PersonalizeAttachmentsBundle/Assets/css/asset.css');
    $header = (!empty($tam)) ? "Edit Attachments": "New Attachments";
    $view['slots']->set('headerTitle', $header);
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
                <div class="col-md-6">
                    <div class="col-md-12 pl-0">
                        <div class="row">
					        <div class="form-group col-xs-12 ">
						        <?php echo $view['form']->label($form['tempName']); ?>
						        <?php echo $view['form']->widget($form['tempName']); ?>
						        <?php echo $view['form']->errors($form['tempName']); ?>
						        <div class="help-block mdropzone-error"></div>
						        <div id="file-container">
                                    <input type="file" name="plugin_attachment_files[]" onchange="getAllFile()" multiple id="groupFile">
                                    <h4 id="countFile"></h4>
                                </div>
					        </div>
				        </div>
					</div>
                </div>
                <div class="col-md-6">
                    <div class="row">
                        <div class="form-group">
                            <label for="" class="control-laber">Review</label>
                            <span id="displayFile"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 bg-white height-auto">
        <div class="pr-lg pl-lg pt-md pb-md">
			<?php
                echo $view['form']->row($form['list']);
            ?>
		</div>
    </div>
</div>
<?php echo $view['form']->end($form); ?>