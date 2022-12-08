<?php
// plugins/PersonalizeAttachmentsBundle/Model/AssetModel.php

namespace MauticPlugin\PersonalizeAttachmentsBundle\Model;

use Mautic\CoreBundle\Model\FormModel;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;

class AssetModel extends FormModel
{

    public function getEntity($id = null)
    {
        if ($id === null) {
            $entity = new Attachments();
        } else {
            $entity = parent::getEntity($id);
        }

        return $entity;
    }

    public function createForm($entity, $formFactory, $action = null, $options = [])
    {
        if (!$entity instanceof Attachments) {
            throw new MethodNotAllowedHttpException(['Attachments']);
        }

        if (!empty($action)) {
            $options['action'] = $action;
        }

        return $formFactory->create('plugin_asset', $entity, $options);
    }
    public function saveEntity($entity, $unlock = true)
    {

        parent::saveEntity($entity, $unlock);
    }

}