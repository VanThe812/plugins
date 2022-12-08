<?php

/*
 * @author      FFC_HOU
 *
 * @license     GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */

namespace MauticPlugin\PersonalizeAttachmentsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Mautic\CoreBundle\Doctrine\Mapping\ClassMetadataBuilder;
use Mautic\CoreBundle\Entity\FormEntity;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Mautic\UserBundle\Entity\User;
use Mautic\EmailBundle\Entity\Email;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Class Attachments.
 */
class Attachments extends FormEntity
{
    /**
     * @var int
     */
    private $id;

    private $name;

    private $description;

    private $paths;

    private $userId;

    private $email;
    
    private $tempName;

    private $maxSize;


    public static function loadMetadata(ORM\ClassMetadata $metadata)
    {
        $builder = new ClassMetadataBuilder($metadata);

        $builder->setTable('attachments')
            ->setCustomRepositoryClass('MauticPlugin\PersonalizeAttachmentsBundle\Entity\AttachmentsRepository')
            ->addIndex(['name'], 'attachments_name_search');

        $builder->addIdColumns('name');

        $builder->createField('paths', 'text')
            ->nullable()
            ->build();

        $builder->createManyToOne('email', Email::class)
            ->addJoinColumn('email_id', 'id', true, false, 'SET NULL')
            ->build();
    }


    //-----------------------------------------------
    public function getId()
    {
        return $this->id;
    }


    public function setName($name)
    {

        $this->name = $name;

        return $this;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setDescription($description)
    {

        $this->description = $description;

        return $this;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getUserId()
    {
        return $this->userId;
    }

    public function setUserId($userId)
    {
        $this->userId = $userId;

        return $this;
    }

    public function setPaths($paths)
    {
        $this->paths = $paths;
        return $this;
    }

    public function getPaths()
    {
        return $this->paths;
    }

    public function getEmail()
    {
        return $this->email;
    }


    public function setEMail(Email $email)
    {
        $this->email = $email;

        return $this;
    }

    public function setTempName($tempName)
    {
        $this->tempName = $tempName;

        return $this;
    }

    /**
     * Get temporary file name.
     *
     * @return string
     */
    public function getTempName()
    {
        return $this->tempName;
    }


    

}
