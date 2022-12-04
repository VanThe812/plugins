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
        $entity->setMaxSize(Attachments::convertSizeToBytes($this->get('mautic.helper.core_parameters')->getParameter('max_size').'M')); // convert from MB to B
        
        if (!$this->get('mautic.security')->isGranted('plugin:personalizeattachments:asset:create')) {
            return $this->accessDenied();
        }

        $action = $this->generateUrl('plugin_personalizeattachments_asset_action', ['objectAction' => 'new']);

        //create the form
        $form = $model->createForm($entity, $this->get('form.factory'), $action);

        ///Check for a submitted form and process it
        if ($method == 'POST') {
            $valid = false;
            if (!$cancelled = $this->isFormCancelled($form))  {
                if ($valid = $this->isFormValid($form)) {
                    $list_id = $_POST['plugin_asset']['list'];
                    if($list_id!=null){
                        $this->upload($list_id);
                        $model->saveEntity($entity);
                    }
                }
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
                    // 'activeAsset'      => $entity,
                    "tam"   => '1',
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
    function upload($id) {
        if(!file_exists("media/files/attachments")) {
            mkdir("media/files/attachments", 0777);
        }
        $target_dir = "media/files/attachments/".$id;
        if(!file_exists($target_dir)) {
            mkdir($target_dir, 0777);
        }
        $list_file = $this->reArrayFiles($_FILES['plugin_attachment_files']);
        
        foreach ($list_file as $file) {
            $target_file = $target_dir."/" . $file['name'];
            if (file_exists($target_file)) {
                unlink($target_file);
            }
            if (move_uploaded_file($file['tmp_name'], $target_file)) {
                echo "The file ". htmlspecialchars( basename( $file["name"])). " has been uploaded.";
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }
    }
}