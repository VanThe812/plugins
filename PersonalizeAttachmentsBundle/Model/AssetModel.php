<?php
// plugins/PersonalizeAttachmentsBundle/Model/AssetModel.php

namespace MauticPlugin\PersonalizeAttachmentsBundle\Model;

use Mautic\CoreBundle\Model\FormModel;
use MauticPlugin\PersonalizeAttachmentsBundle\Entity\Attachments;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;

class AssetModel extends FormModel
{

    /**
     * Get a specific entity or generate a new one if id is empty.
     *
     * @param $id
     *
     * @return null|Asset
     */
    public function getEntity($id = null)
    {
        if ($id === null) {
            $entity = new Attachments();
        } else {
            $entity = parent::getEntity($id);
        }

        return $entity;
    }
    /**
     * {@inheritdoc}
     *
     * @throws NotFoundHttpException
     */
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
        

        // if (!$entity->isNew()) {
        //     //increase the revision
        //     $revision = $entity->getRevision();
        //     ++$revision;
        //     $entity->setRevision($revision);
        // }

        parent::saveEntity($entity, $unlock);
    }
    public function getRepository()
    {
        return $this->em->getRepository('PersonalizeAttachmentsBundle:Attachments');
    }

}