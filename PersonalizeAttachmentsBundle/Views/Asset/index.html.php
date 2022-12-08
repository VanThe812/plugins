<?php 
// plugins/PersonalizeAttachmentsBundle/Views/Asset/index.html.php

/*
 * @author      FFC_HOU
 *
 * @license     GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */

    $view->extend('MauticCoreBundle:Default:content.html.php');
    $view['slots']->set('headerTitle', 'Attachments');

    
?>
<h1>Index</h1>
<?php $view['slots']->output('_content'); ?>