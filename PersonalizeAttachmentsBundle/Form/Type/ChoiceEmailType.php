<?php

/*
 * @author      FFC_HOU
 *
 * @license     GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */

namespace MauticPlugin\PersonalizeAttachmentsBundle\Form\Type;

// use Mautic\LeadBundle\Model\FieldModel;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

use Mautic\CoreBundle\Factory\MauticFactory;

class ChoiceEmailType extends AbstractType
{
    public function __construct(MauticFactory $factory)
    {
        $emails = $factory->getModel('email')->getRepository()->getEntities();
        foreach ($emails as $email ) {
            $this->emailChoices[$email->getId()] = $email->getName();
        }
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'choice_type_email';
    }
}
