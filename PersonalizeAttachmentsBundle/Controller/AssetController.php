<?php
// plugins/PersonalizeAttachmentsBundle/Controller/AssetController.php

namespace MauticPlugin\PersonalizeAttachmentsBundle\Controller;

use MauticPlugin\PersonalizeAttachmentsBundle\Entity\Attachments;
// use MauticPlugin\PersonalizeAttachmentsBundle\Model\AssetModel;
use Mautic\CoreBundle\Controller\FormController;
// use Symfony\Component\DependencyInjection\ContainerInterface;

class AssetController extends FormController
{

    public function indexAction($page = 1) 
    {

        if (!$this->get('mautic.security')->isGranted('plugin:personalizeattachments:asset:view')) {
            return $this->accessDenied();
        }
        $permissions = $this->get('mautic.security')->isGranted([
            'plugin:personalizeattachments:asset:view',
            'plugin:personalizeattachments:asset:create',
            'plugin:personalizeattachments:asset:editown',
            'plugin:personalizeattachments:asset:deleteown',
        ], 'RETURN_ARRAY');

        return $this->delegateView(
            array(
                'viewParameters'  => array(
                    'permissions' => $permissions,
                ),
                'contentTemplate' => 'PersonalizeAttachmentsBundle:Asset:index.html.php',
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
    public function newAction($entity = null)
    {
        //call model
        $model = $this->getModel('personalizeattachments.asset');
        $method  = $this->request->getMethod();
        $session = $this->get('session');

        if (null == $entity) {
            $entity = $model->getEntity();
        }
        $entity->setMaxSize(Asset::convertSizeToBytes($this->get('mautic.helper.core_parameters')->getParameter('max_size').'M')); // convert from MB to B
        
        if (!$this->get('mautic.security')->isGranted('plugin:personalizeattachments:asset:create')) {
            return $this->accessDenied();
        }

        $action = $this->generateUrl('plugin_personalizeattachments_asset_action', ['objectAction' => 'new']);

        //create the form
        $form = $model->createForm($entity, $this->get('form.factory'), $action);



        return $this->delegateView(
            array(
                'viewParameters'  => array(
                    'form'             => $form->createView(),
                    'activeAsset'      => $entity,
                ),
                'contentTemplate' => 'PersonalizeAttachmentsBundle:Asset:form.html.php',
                'passthroughVars' => array(
                    'activeLink'    => '#plugin_personalizeattachments_index',
                    'mauticContent' => 'plugin_asset',
                    'route'         => $this->generateUrl('plugin_personalizeattachments_asset_action', [
                        'objectAction' => 'new',
                    ]),
                )
            )
        );
    }

}