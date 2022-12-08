<?php
// plugins/PersonalizeAttachmentsBundle/Controller/AssetController.php


/*
 * @author      FFC_HOU
 *
 * @license     GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */

namespace MauticPlugin\PersonalizeAttachmentsBundle\Controller;

use MauticPlugin\PersonalizeAttachmentsBundle\Entity\Attachments;
// use MauticPlugin\PersonalizeAttachmentsBundle\Model\AssetModel;
use Mautic\CoreBundle\Controller\FormController;
// use Symfony\Component\DependencyInjection\ContainerInterface;

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

        // $filter = ['string' => $search, 'force' => []];

        // if (!$permissions['plugin:personalizeattachments:asset:viewother']) {
        //     $filter['force'][] =
        //         ['column' => 'a.createdBy', 'expr' => 'eq', 'value' => $this->user->getId()];
        // }

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

        $page = $this->get('session')->set('mautic.plugin.PersonalizeAttachments.page', $page);

        return $this->delegateView(
            array(
                'viewParameters'  => array(
                    'permissions' => $permissions,
                    'searchValue' => $search,
                    'items'       => $attachments,
                    'limit'       => $limit,
                    'model'       => $model,
                    'tmpl'        => $tmpl,
                    'page'        => $page,
                    'security'    => $this->get('mautic.security'),
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
    public function newAction($entity = null)
    {
        //call model
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

        ///Check for a submitted form and process it
        if ($method == 'POST') {
            $valid = false;
            if (!$cancelled = $this->isFormCancelled($form))  {
                if ($valid = $this->isFormValid($form)) {
                    $list_id = $entity->getEmailId();
                    if($list_id!=null){
                        $list_file = $this->reArrayFiles($_FILES['plugin_attachment_files']);
                        $paths = $this->getPaths($files_name);
                        $entity->setPath($paths);
                        $model->saveEntity($entity);

                        $res = $this->upload($entity->getId(), $list_file);

                    
                        $this->addFlash('mautic.core.notice.created', [
                            '%name%'      => $entity->getName(),
                            '%menu_link%' => 'plugin_personalizeattachments_asset_index',
                            '%url%'       => $this->generateUrl('plugin_personalizeattachments_asset_action', [
                                'objectAction' => 'edit',
                                'objectId'     => $entity->getId(),
                            ]),
                        ]);
                        if (!$form->get('buttons')->get('save')->isClicked()) {
                            //return edit view so that all the session stuff is loaded
                            return $this->editAction($entity->getId(), true);
                        }
                    }
                }
            }else {
                $viewParameters = ['page' => $page];
                $returnUrl      = $this->generateUrl('plugin_personalizeattachments_asset_index', $viewParameters);
                $template       = 'PersonalizeAttachmentsBundle:Asset:index';
            }
            if ($cancelled || ($valid && $form->get('buttons')->get('save')->isClicked())) {
                return $this->postActionRedirect([
                    'returnUrl'       => $returnUrl,
                    'viewParameters'  => $viewParameters,
                    'contentTemplate' => $template,
                    'passthroughVars' => [
                        'activeLink'    => 'plugin_personalizeattachments_asset_index',
                        'mauticContent' => 'plugin_asset',
                    ],
                ]);
            }
        }

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
    public function editAction($objectId, $ignorePost = false) {

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
                    'form'             => $form->createView(),
                    'activeAsset'      => $entity,
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
    public function viewAction($objectId) {
        $model = $this->getModel('personalizeattachments.asset');
        $session = $this->get('session');
        $security    = $this->get('mautic.security');
        $entity = $model->getEntity($objectId);

        return $this->delegateView(
            array(
                'viewParameters'  => array(
                    'activeAsset'      => $entity,
                    'permissions' => $security->isGranted([
                        'plugin:personalizeattachments:asset:view',
                        'plugin:personalizeattachments:asset:viewown',
                        'plugin:personalizeattachments:asset:viewother',
                        'plugin:personalizeattachments:asset:create',
                        'plugin:personalizeattachments:asset:editown',
                        'plugin:personalizeattachments:asset:editother',
                        'plugin:personalizeattachments:asset:deleteown',
                        'plugin:personalizeattachments:asset:deleteother',
                    ], 'RETURN_ARRAY'),
                    'security' => $security
                ),
                'contentTemplate' => 'PersonalizeAttachmentsBundle:Asset:details.html.php',
                'passthroughVars' => array(
                    'activeLink'    => '#plugin_personalizeattachments_index',
                    'mauticContent' => 'plugin_asset',
                )
            )
        );
    }
    function reArrayFiles(&$file_post) {

        $file_ary = array();
        $file_count = count($file_post['name']);
        $file_keys = array_keys($file_post);
    
        for ($i=0; $i<$file_count; $i++) {
            foreach ($file_keys as $key) {
                $file_ary[$i][$key] = $file_post[$key][$i];
            }
        }
    
        return $file_ary;
    }
    function getPaths($list_file) {
        $files_name = "";
        foreach ($list_file as $file) {
            $files_name .= $file['name'].",";
        }
        return $files_name;
    }
    function upload($id, $list_file) {
        if(!file_exists("media/files/attachments")) {
            mkdir("media/files/attachments", 0777);
        }
        $target_dir = "media/files/attachments/".$id;
        if(!file_exists($target_dir)) {
            mkdir($target_dir, 0777);
        }
        
        $files_name = "";
        foreach ($list_file as $file) {
            $target_file = $target_dir."/" . $file['name'];
            
            if (file_exists($target_file)) {
                unlink($target_file);
            }
            if (move_uploaded_file($file['tmp_name'], $target_file)) {
                $files_name .= $file['name'].",";
            }
        }

        return $files_name;
    }
}