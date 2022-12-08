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

        if (!$this->get('mautic.security')->isGranted('plugin:personalizeattachments:asset:view')) {
            return $this->accessDenied();
        }
        
        $permissions = $this->get('mautic.security')->isGranted([
            'plugin:personalizeattachments:asset:view',
            'plugin:personalizeattachments:asset:viewown',
            'plugin:personalizeattachments:asset:viewother',
            'plugin:personalizeattachments:asset:create',
            'plugin:personalizeattachments:asset:editown',
            'plugin:personalizeattachments:asset:editother',
            'plugin:personalizeattachments:asset:deleteown',
            'plugin:personalizeattachments:asset:deleteother',
        ], 'RETURN_ARRAY');

        $limit = $this->get('session')->get('mautic.plugin.PersonalizeAttachments.limit', $this->get('mautic.helper.core_parameters')->getParameter('default_assetlimit'));
        $start = ($page === 1) ? 0 : (($page - 1) * $limit);
        if ($start < 0) {
            $start = 0;
        }
        $search = $this->request->get('search', $this->get('session')->get('mautic.plugin.PersonalizeAttachments.filter', ''));
        $this->get('session')->set('mautic.plugin.PersonalizeAttachments.filter', $search);

        $page = $this->get('session')->set('mautic.plugin.PersonalizeAttachments.page', $page);

        $attachments = $model->getEntities(
            [
                'start'      => $start,
                'limit'      => $limit,
                'orderBy'    => "",
                'orderByDir' => "DESC",
            ]
        );
        $count = count($assets);
        if ($count && $count < ($start + 1)) {
            //the number of entities are now less then the current asset so redirect to the last asset
            if ($count === 1) {
                $lastPage = 1;
            } else {
                $lastPage = (ceil($count / $limit)) ?: 1;
            }
            $this->get('session')->set('mautic.plugin.PersonalizeAttachments.attachments', $lastPage);
            $returnUrl = $this->generateUrl('plugin_personalizeattachments_asset_index', ['page' => $lastPage]);

            return $this->postActionRedirect([
                'returnUrl'       => $returnUrl,
                'viewParameters'  => ['asset' => $lastPage],
                'contentTemplate' => 'PersonalizeAttachmentsBundle:Asset:index',
                'passthroughVars' => [
                    'activeLink'    => '#mautic_asset_index',
                    'mauticContent' => 'plugin_asset',
                ],
            ]);
        }

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
    public function newAction($entity = null)
    {
        $model = $this->getModel('personalizeattachments.asset');
        $method  = $this->request->getMethod();
        $session = $this->get('session'); 
        
        if (null == $entity) {
            $entity = $model->getEntity();
        }
        $entity->setMaxSize(Attachments::convertSizeToBytes($this->get('mautic.helper.core_parameters')->getParameter('max_size').'M')); // convert from MB to B
        
        if (!$this->get('mautic.security')->isGranted('plugin:personalizeattachments:asset:create')) {
            return $this->accessDenied();
        }

        $page = $session->get('mautic.plugin.PersonalizeAttachments.page', 1);
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
    public function editAction($objectId, $ignorePost = false)
    {
        $model = $this->getModel('personalizeattachments.asset');
        $method  = $this->request->getMethod();
        $session = $this->get('session');

        $entity = $model->getEntity($objectId);

        $action = $this->generateUrl('plugin_personalizeattachments_asset_action', ['objectAction' => 'edit']);


        //create the form
        $form = $model->createForm($entity, $this->get('form.factory'), $action);

        
        return $this->delegateView(
            array(
                'viewParameters'  => array(
                ),
                'contentTemplate' => 'PersonalizeAttachmentsBundle:Asset:form.html.php',
                'passthroughVars' => array(
                    'activeLink'    => '#plugin_personalizeattachments_index',
                    'mauticContent' => 'plugin_asset',
                    'route'         => $this->generateUrl('plugin_personalizeattachments_asset_action', [
                        'objectAction' => 'edit',
                    ]),
                )
            )
        );
    }

     
}