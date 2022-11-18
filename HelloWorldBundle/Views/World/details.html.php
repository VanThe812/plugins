<?php
//plugins/HelloWorldBundle/Views/World/details.html.php

// Check if the request is Ajax
if (!$app->getRequest()->isXmlHttpRequest()) {

    // Set tmpl for parent template
    $view['slots']->set('tmpl', 'Details');

    // Extend index.html.php as the parent
    $view->extend('HelloWorldBundle:World:index.html.php');
    // $view->render('HelloWorldBundle:World:index.html.php', array('parameter' => 'value'));

}
?>

<div>
    <!-- Desired content/markup -->
    
</div>