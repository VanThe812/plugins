<?php
 
// plugins/PersonalizeAttachmentsBundle/Form/Type/AssetType.php

/*
 * @copyright   2014 Mautic Contributors. All rights reserved
 * @author      Mautic
 *
 * @link        http://mautic.org
 *
 * @license     GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */

namespace MauticPlugin\PersonalizeAttachmentsBundle\Form\Type;

use Doctrine\ORM\EntityManager;
use Mautic\CoreBundle\Form\DataTransformer\IdToEntityModelTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Translation\TranslatorInterface;
use Mautic\CoreBundle\Translation\Translator;
/**
 * Class AssetType.
 */

class AssetType extends AbstractType
{
    private $em;

    /**
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em)
    {
        
        $this->em = $em;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $maxUploadSize = "6";
        $builder->add('tempName', 'hidden', [
            'label'       => "Upload multiple files (max filesize allowed = $maxUploadSize MB)",
            'label_attr'  => ['class' => 'control-label'],
            'required'    => false,
        ]);

        // $transformer = new IdToEntityModelTransformer($this->em, 'MauticLeadBundle:LeadList', 'id', true);
        
        // $builder->add(
        //     'segmentId',
        //     'leadlist_choices',
        //     [
        //         'label'       => 'Contact segment',
        //         'label_attr'  => ['class' => 'control-label'],
        //         'attr'        => ['class' => 'form-control'],
        //         'empty_value' => '',
        //         'required'    => true,
        //     ]
        // );
        $builder->add(
            'name',
            'text',
            [
                'label'       => 'Name',
                'label_attr'  => ['class' => 'control-label'],
                'attr'        => ['class' => 'form-control'],
                'required'    => true,
            ]
        );
        $builder->add('description', 'textarea', [
            'label'      => 'mautic.core.description',
            'label_attr' => ['class' => 'control-label'],
            'attr'       => ['class' => 'form-control editor'],
            'required'   => false,
        ]);
        $builder->add('isPublished', 'yesno_button_group');
   

        $builder->add('buttons', 'form_buttons', []);

        if (!empty($options['action'])) {
            $builder->setAction($options['action']);
        }
    }
}