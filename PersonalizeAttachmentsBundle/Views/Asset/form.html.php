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
// $header = ($activeAsset->getId()) ? "Edit Attachments ". $activeAsset->getName() : "New Attachments";

$view['slots']->set('headerTitle', $header);

?>

<h1>form</h1>