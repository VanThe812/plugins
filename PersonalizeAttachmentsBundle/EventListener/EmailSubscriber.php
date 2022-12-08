<?php 

/*
 * @author      FFC_HOU
 *
 * @license     GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */

namespace MauticPlugin\PersonalizeAttachmentsBundle\EventListener;

use Mautic\CoreBundle\EventListener\CommonSubscriber;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Mautic\ConfigBundle\ConfigEvents;
use Mautic\ConfigBundle\Event\ConfigBuilderEvent;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class EmailSubscriber extends CommonSubscriber
{
    public static function getSubscribedEvents()
    {
        return array(
            ConfigEvents::CONFIG_ON_GENERATE     => array('onConfigGenerate', 0),
            // ConfigEvents::CONFIG_PRE_SAVE     => array('onChangeName', 0),
        );
    }
    public function onConfigGenerate(ConfigBuilderEvent $event) {
        $event->addForm(
            [
                'formAlias' => 'choice_type_email',
                'formType'  => ConfigType::class,

            ]
        );
    }
}

?>