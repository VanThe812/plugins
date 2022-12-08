<?php 
    use Mautic\CoreBundle\EventListener\CommonSubscriber;
    use Symfony\Component\DependencyInjection\ContainerInterface;
    use Mautic\EmailBundle\Event\EmailSendEvent;
    use Mautic\EmailBundle\EmailEvents;
    use Mautic\EmailBundle\Entity\Email;

    class  EmailSubscriber extends CommonSubscriber{
        public static function getSubscribedEvents(){
            return array(
                EmailEvents::EMAIL_ON_SEND    => array('onChangeName',0),
                EmailEvents::EMAIL_POST_DELETE=> array('onChangeName',0),
            );
        }
        public function onChangeName(EmailEvents $event){
            $email = $event -> getEmail();
            mkdir("media/files/thu",0777);
        }
    }

?>