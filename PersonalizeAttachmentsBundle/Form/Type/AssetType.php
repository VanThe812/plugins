<?php

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
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * Class AssetType.
 */
class AssetType extends AbstractType
{
   
    protected $em;

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
        $builder->addEventSubscriber(new CleanFormSubscriber(['description' => 'html']));
        // $builder->addEventSubscriber(new FormExitSubscriber('asset.asset', $options));

        $maxUploadSize = "";
        $builder->add('tempName', 'text', [
            'label'      => "Upload a file (max filesize allowed = $maxUploadSize MB)",
            'label_attr' => ['class' => 'control-label'],
            'required'   => false,
        ]);


      

        // $builder->add('remotePath', 'text', [
        //     'label'      => 'mautic.asset.asset.form.remotePath',
        //     'label_attr' => ['class' => 'control-label'],
        //     'attr'       => ['class' => 'form-control'],
        //     'required'   => false,
        // ]);


        // $transformer = new IdToEntityModelTransformer($this->em, 'MauticLeadBundle:LeadList', 'id', true);
        // $builder->add(
        //     $builder->create(
        //         'lists',
        //         'leadlist_choices',
        //         [
        //             'label'      => 'Contact segment',
        //             'label_attr' => ['class' => 'control-label'],
        //             'attr'       => [
        //                 'class'        => 'form-control',
        //                 'data-show-on' => '{"emailform_segmentTranslationParent":[""]}',
        //             ],
        //             'multiple' => true,
        //             'expanded' => false,
        //             'required' => true,
        //         ]
        //     )
        //         // ->addModelTransformer($transformer)
        // );


   

        $builder->add('tempId', 'hidden', [
            'required' => false,
        ]);

        $builder->add('buttons', 'form_buttons', []);

        if (!empty($options['action'])) {
            $builder->setAction($options['action']);
        }
    }

    // /**
    //  * @param OptionsResolverInterface $resolver
    //  */
    // public function setDefaultOptions(OptionsResolverInterface $resolver)
    // {
    //     $resolver->setDefaults(['data_class' => 'MauticPlugin\PersonalizeAttachmentsBundle\Entity\Asset']);
    // }

    /**
     * @return string
     */
    public function getName()
    {
        return 'plugin_asset';
    }
}
