<?php


// Check if the request is Ajax
if (!$app->getRequest()->isXmlHttpRequest()) {

    // Set tmpl for parent template
    $tmpl = $view['slots']->set('tmpl', 'Bien');
    $view->extend('MauticCoreBundle:Default:content.html.php');
    
}
?>

<div>
    <h1>Xin chao index</h1>
    <span><?php echo $bien ?></span>
</div>