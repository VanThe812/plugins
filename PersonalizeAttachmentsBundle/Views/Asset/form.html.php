<?php
// plugins/PersonalizeAttachmentsBundle/Views/Asset/form.html.php
/*
 * @author      FFC_HOU
 *
 * @license     GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */

    $view->extend('MauticCoreBundle:Default:content.html.php');
    echo $view['assets']->includeScript('plugins/PersonalizeAttachmentsBundle/Assets/js/asset.js');
    echo $view['assets']->includeStylesheet('plugins/PersonalizeAttachmentsBundle/Assets/css/asset.css');
    $header = ($activeAsset->getId()) ? "Edit Attachments ". $activeAsset->getName() : "New Attachments";
    $view['slots']->set('headerTitle', $header);

?>

<script>
	<?php echo 'CountAttachment = '.$activeAsset->getCountAttachment().';'; ?>
	<?php echo 'AttachmentsName = "'.$activeAsset->getAttachmentsName().'";';  ?>
</script>
<?php echo $view['form']->start($form);  ?>
<!-- start: box layout -->
<div class="box-layout ">
    <!-- container -->
    <div class="col-md-9 bg-auto height-auto bdr-r">
        <div class="pa-md">
            <div class="row">
                <div class="col-md-6">
                    <div class="col-md-12 pl-0">
                        <div class="row">
					        <div class="form-group col-xs-12 ">
						        <?php echo $view['form']->label($form['tempName']);  ?>
						        <?php echo $view['form']->widget($form['tempName']);  ?>
						        <?php echo $view['form']->errors($form['tempName']);  ?>
						        <div class="help-block mdropzone-error"></div>
						        <div id="file-container">
                                    <input type="file" name="plugin_attachment_files[]" onchange="getAllFile()" multiple id="groupFile">
                                    <h4 id="countFile">Drop the file here or click to browse and select the file.</h4>
                                    
                                </div>
					        </div>
				        </div>
					</div>
                    <div class="col-md-12 pl-20">
                        <div class="row">
                            <div class="form-group">
                                <label for="" class="control-laber">Review</label>
                                <span id="displayFile"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="col-md-12 pl-0">
                        <div class="row">
					        <div class="form-group col-xs-12 ">
						        <?php echo $view['form']->row($form['name']);  ?>
					        </div>
				        </div>
					</div>
                    <div class="col-md-12 pl-0">
                        <div class="row">
					        <div class="form-group col-xs-12 ">
						        <?php echo $view['form']->row($form['description']);  ?>
					        </div>
				        </div>
					</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 bg-white height-auto">
        <div class="pr-lg pl-lg pt-md pb-md">
			<?php
                echo $view['form']->row($form['segmentId']);
                echo $view['form']->row($form['isPublished']);
            ?>
		</div>
    </div>
</div>
<?php echo $view['form']->end($form); ?>