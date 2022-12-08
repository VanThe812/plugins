<?php
// plugins/PersonalizeAttachmentsBundle/Controller/AssetController.php

/*
 * @author      FFC_HOU
 *
 * @license     GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */

namespace MauticPlugin\PersonalizeAttachmentsBundle\Controller;

use Mautic\CoreBundle\Controller\FormController;

class AssetController extends FormController
{

    public function indexAction($page = 1) 
    {
        $model = $this->getModel('personalizeattachments.asset');

        
        $tmpl = 'index';
        return $this->delegateView(
            array(
                'viewParameters'  => array(
                    'model'       => $model,
                    'tmpl'        => $tmpl,
                ),
                'contentTemplate' => 'PersonalizeAttachmentsBundle:Asset:list.html.php',
                'passthroughVars' => array(
                    'activeLink'    => '#plugin_personalizeattachments_asset_index',
                    'mauticContent' => 'plugin_asset',
                    'route'         => $this->generateUrl('plugin_personalizeattachments_asset_index', [
                        'page' => $page,
                    ]),
                )
            )
        );
    }
    public function viewAction($objectId) 
    {
        $model = $this->getModel('personalizeattachments.asset');


        return $this->delegateView(
            array(
                'viewParameters'  => array(
                ),
                'contentTemplate' => 'PersonalizeAttachmentsBundle:Asset:default.html.php',
                'passthroughVars' => array(
                    'activeLink'    => '#plugin_personalizeattachments_asset_index',
                    'mauticContent' => 'plugin_asset',
                    'route'         => $this->generateUrl('plugin_personalizeattachments_asset_action', [
                        'objectAction' => 'new',
                    ]),
                )
            )
        );
    }
}