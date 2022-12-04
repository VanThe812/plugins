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

    // /**
    //  * @var null|\DateTime
    //  */
    private $time;

    /**
     * @var string
     */
    private $path;

    /**
     * @var int
     */
    private $size;

    /**
     * @var File
     */
    private $file;

    /**
     * Holds upload directory.
     */
    private $uploadDir;

    /**
     * Holds max size of uploaded file.
     */
    private $maxSize;

    /**
     * Temporary location when asset file is beeing updated.
     * We need to keep the old file till we are sure the new
     * one is stored correctly.
     */
    private $temp;

    /**
     * Temporary ID used for file upload and validations
     * before the actual ID is known.
     */
    private $tempId;
    
    /**
     * Temporary file name used for file upload and validations
     * before the actual ID is known.
     */
    private $tempName;

    
    //-----------------------------------------------
    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }


    public function setTime($time)
    {

        $this->time = $time;

        return $this;
    }

    /**
     * Get publishDown.
     *
     * @return \DateTime
     */
    public function getTime()
    {
        return $this->time;
    }

    /**
     * Set path.
     *
     * @param string $path
     *
     * @return Attachments
     */
    public function setPath($path)
    {
        $this->isChanged('path', $path);
        $this->path = $path;

        return $this;
    }

    /**
     * Get path.
     *
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @param mixed $size
     *
     * @return Attachments
     */
    public function setSize($size)
    {
        $this->size = $size;

        return $this;
    }

    /**
     * Sets file.
     *
     * @param File $file
     */
    public function setFile(File $file = null)
    {
        $this->file = $file;

        // check if we have an old asset path
        if (isset($this->path)) {
            // store the old name to delete after the update
            $this->temp = $this->path;
            $this->path = null;
        }
    }

    /**
     * Get file.
     *
     * @return UploadedFile
     */
    public function getFile()
    {
        // if file is not set, try to find it at temp folder
        if ($this->isLocal() && empty($this->file)) {
            $tempFile = $this->loadFile(true);

            if ($tempFile) {
                $this->setFile($tempFile);
            }
        }

        return $this->file;
    }

    /**
     * Returns absolute path to upload dir.
     *
     * @return string
     */
    protected function getUploadDir()
    {
        if ($this->uploadDir) {
            return $this->uploadDir;
        }

        return 'media/files';
    }

    /**
     * Set uploadDir.
     *
     * @param string $uploadDir
     *
     * @return Attachments
     */
    public function setUploadDir($uploadDir)
    {
        $this->uploadDir = $uploadDir;

        return $this;
    }
/**
     * Returns maximal uploadable size in bytes.
     * If not set, 6000000 is default.
     *
     * @return string
     */
    protected function getMaxSize()
    {
        if ($this->maxSize) {
            return $this->maxSize;
        }

        return 6000000;
    }

    /**
     * Set max size.
     *
     * @param string $maxSize
     *
     * @return Attachments
     */
    public function setMaxSize($maxSize)
    {
        $this->maxSize = $maxSize;

        return $this;
    }
    
    /**
     * Set temporary file name.
     *
     * @param string $tempName
     *
     * @return Attachments
     */
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

    /**
     * Set temporary ID.
     *
     * @param string $tempId
     *
     * @return Attachments
     */
    public function setTempId($tempId)
    {
        $this->tempId = $tempId;

        return $this;
    }

    /**
     * Get temporary ID.
     *
     * @return string
     */
    public function getTempId()
    {
        return $this->tempId;
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
    /**
     * @param ORM\ClassMetadata $metadata
     */
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

        $builder->createManyToOne('user', User::class)
            ->addJoinColumn('created_by', 'id', true, false, 'SET NULL')
            ->build();

        $builder->createField('path', 'string')
            ->nullable()
            ->build();

        $builder->createField('size', 'integer')
            ->nullable()
            ->build();
        $builder->createManyToOne('leadlist', LeadList::class)
            ->addJoinColumn('lead_lists_id', 'id', true, false, 'SET NULL')
            ->build();
    }
    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('text', new Assert\Length(
            [
                'max' => 280,
            ]
        ));
    }
}
