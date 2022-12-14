<?php

/*
 * @author      FFC_HOU
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
use MauticPlugin\PersonalizeAttachmentsBundle\Form\Type\ChoiceEmailType;
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
        // $builder->addEventSubscriber(new CleanFormSubscriber(['description' => 'html']));
        // $builder->addEventSubscriber(new FormExitSubscriber('asset.asset', $options));

        $maxUploadSize = "6";
        $builder->add('tempName', 'hidden', [
            'label'      => "Upload multiple files (max filesize allowed = $maxUploadSize MB)",
            'label_attr' => ['class' => 'control-label'],
            'required'   => false,
        ]);

        //lay id 
        // $transformer = new IdToEntityModelTransformer($this->em, 'MauticLeadBundle:LeadList', 'id', true);

        $transformer = new IdToEntityModelTransformer($this->em, 'MauticEmailBundle:Email');
        
        $builder->add(
            'email_id',
            'leadlist_choices',
            [
                'label'       => 'Email',
                'label_attr'  => ['class' => 'control-label'],
                'attr'        => ['class' => 'form-control'],
                'empty_value' => '',
                'required'    => true,
            ]
        );
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

    // /**
    //  * @param OptionsResolverInterface $resolver
    //  */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(['data_class' => 'MauticPlugin\PersonalizeAttachmentsBundle\Entity\Attachments']);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'plugin_asset';
    }
}
