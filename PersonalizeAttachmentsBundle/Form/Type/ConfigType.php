<?php


namespace MauticPlugin\PersonalizeAttachmentsBundle\Form\Type;

// use Mautic\LeadBundle\Model\FieldModel;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class ConfigType extends AbstractType
{


    public function buildForm(FormBuilderInterface $builder)
    {
        $builder->add('choice_type', 'choice', [
            'choices' => [
                'local' => 'Local',
                'icloud'   => 'Icloud',
            ],
            'label'       => 'Attachment personalization file saving type',
            'label_attr'  => ['class' => 'control-label'],
            'attr'        => ['class' => 'form-control'],
        ]);

        $builder->add('text', 'text', [
            'label_attr' => ['class' => 'control-label'],
            'label'      => 'Path',
            'attr'       => [
                'class'       => 'form-control',
            ],
        ]);

       
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'person_config';
    }
}
