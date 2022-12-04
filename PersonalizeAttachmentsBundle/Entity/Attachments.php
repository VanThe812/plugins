<?php

/*
 * @copyright   2014 Mautic Contributors. All rights reserved
 * @author      Mautic
 *
 * @link        http://mautic.org
 *
 * @license     GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */

namespace MauticPlugin\PersonalizeAttachmentsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Mautic\CoreBundle\Doctrine\Mapping\ClassMetadataBuilder;
use Mautic\CoreBundle\Entity\FormEntity;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Mautic\UserBundle\Entity\User;
use Mautic\LeadBundle\Entity\LeadList;
/**
 * Class Asset.
 */
class Attachments extends FormEntity
{
    /**
     * @var int
     */
    private $id;

    private $time;

    private $name;

    private $description;

    private $path;

    private $size;

    private $files;

    /**
     * Holds max size of uploaded file.
     */
    private $maxSize;



    public static function loadMetadata(ORM\ClassMetadata $metadata)
    {
        $builder = new ClassMetadataBuilder($metadata);

        $builder->setTable('attachments')
            ->setCustomRepositoryClass('MauticPlugin\PersonalizeAttachmentsBundle\Entity\AttachmentsRepository')
            ->addIndex(['path'], 'attachments_path_search');

        $builder->addIdColumns();

        $builder->createField('time', 'string')
            ->nullable()
            ->build();

        $builder->createManyToOne('user', 'Mautic\UserBundle\Entity\User')
            ->addJoinColumn('created_by', 'id', true, false, 'SET NULL')
            ->build();

        $builder->createField('path', 'string')
            ->nullable()
            ->build();

        $builder->createField('size', 'integer')
            ->nullable()
            ->build();
        $builder->createManyToOne('list', 'Mautic\LeadBundle\Entity\LeadList')
            ->addJoinColumn('list_id', 'id', true, false, 'SET NULL')
            ->build();
    }


    //-----------------------------------------------
    public function getId()
    {
        return $this->id;
    }

    public function setTime($time)
    {

        $this->time = $time;

        return $this;
    }

    public function getTime()
    {
        return $this->time;
    }

    // public function setName($name)
    // {

    //     $this->name = $name;

    //     return $this;
    // }

    // public function getName()
    // {
    //     return $this->name;
    // }

    // public function setDescription($description)
    // {

    //     $this->description = $description;

    //     return $this;
    // }

    // public function getDescription()
    // {
    //     return $this->description;
    // }

    // public function getUserId()
    // {
    //     return $this->userId;
    // }

    // public function setUserId($userId)
    // {
    //     $this->userId = $userId;

    //     return $this;
    // }

    // public function getListId()
    // {
    //     return $this->listId;
    // }

    // public function setListId($listId)
    // {
    //     $this->listId = $listId;

    //     return $this;
    // }

    public function setPath($path)
    {
        $this->isChanged('path', $path);
        $this->path = $path;

        return $this;
    }

    public function getPath()
    {
        return $this->path;
    }

    public function setSize($size)
    {
        $this->size = $size;

        return $this;
    }

    public function setFiles($files)
    {
        $this->files = $files;

        return $this;
    }
    public function getFiles()
    {
        return $this->files;
    }

    protected function getMaxSize()
    {
        if ($this->maxSize) {
            return $this->maxSize;
        }

        return 6000000;
    }

    public function setMaxSize($maxSize)
    {
        $this->maxSize = $maxSize;

        return $this;
    }




    /**
     * Borrowed from Symfony\Component\HttpFoundation\File\UploadedFile::getMaxFilesize.
     *
     * @param $size
     *
     * @return int|string
     */
    public static function convertSizeToBytes($size)
    {
        if ('' === $size) {
            return PHP_INT_MAX;
        }

        $max = ltrim($size, '+');
        if (0 === strpos($max, '0x')) {
            $max = intval($max, 16);
        } elseif (0 === strpos($max, '0')) {
            $max = intval($max, 8);
        } else {
            $max = intval($max);
        }

        switch (strtolower(substr($size, -1))) {
            case 't':
                $max *= 1024;
            case 'g':
                $max *= 1024;
            case 'm':
                $max *= 1024;
            case 'k':
                $max *= 1024;
        }

        return $max;
    }


    public function upload($id, $list_file)
    {
        if(!file_exists("media/files/attachments")) {
            mkdir("media/files/attachments", 0777);
        }
        $target_dir = "media/files/attachments/".$id;
        if(!file_exists($target_dir)) {
            mkdir($target_dir, 0777);
        }
        // $list_file = $this->getFiles();
                    
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
