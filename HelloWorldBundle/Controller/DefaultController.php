<?php
// plugins/HelloWorldBundle/Controller/DefaultController.php

namespace MauticPlugin\HelloWorldBundle\Controller;

use Mautic\CoreBundle\Controller\FormController;

class DefaultController extends FormController
{
    /**
     * Display the world view
     *
     * @param string $world
     *
     * @return JsonResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function worldAction($world = 'earth')
    {
        /** @var \MauticPlugin\HelloWorldBundle\Model\WorldModel $model */
        // $model = $this->getModel('helloworld.world');
        // echo "<pre>";
        // print_r($model);
        // echo "</pre>";
        // exit;

        // Retrieve details about the world
        // $worldDetails = $model->getWorldDetails($world);

        return $this->delegateView(
            array(
                //data truyen qua view
                //2 bien ko dc phep dat:$view, $app 
                'viewParameters'  => array(
                    'world'   => $world,
                    'details' => $world
                ),
                'contentTemplate' => 'HelloWorldBundle:World:details.html.php',
                'passthroughVars' => array(
                    'activeLink'    => 'plugin_helloworld_world',
                    'route'         => $this->generateUrl('plugin_helloworld_world', array('world' => $world)),
                    'mauticContent' => 'helloWorldDetails'
                )
            )
        );
    }
    public function adminAction() {
        // $config = $this->mergeConfigToFeatureSettings();
        
        echo "<pre>";
        print_r("hi admin");
        echo "</pre>";
        exit;
    }
    /**
     * Contact form
     *
     * @return JsonResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function contactAction()
    {
        // Create the form object
        $form = $this->get('form.factory')->create('helloworld_contact');

        // Handle form submission if POST        
        if ($this->request->getMethod() == 'POST') {
            $flashes = array();

            // isFormCancelled() checks if the cancel button was clicked
            if ($cancelled = $this->isFormCancelled($form)) {

                // isFormValid() will bind the request to the form object and validate the data
                if ($valid = $this->isFormValid($form)) {

                    /** @var \MauticPlugin\HelloWorldBundle\Model\ContactModel $model */
                    $model = $this->getModel('helloworld.contact');

                    // Send the email
                    $model->sendContactEmail($form->getData());

                    // Set success flash message
                    $flashes[] = array(
                        'type'    => 'notice',
                        'msg'     => 'plugin.helloworld.notice.thank_you',
                        'msgVars' => array(
                            '%name%' => $form['name']->getData()
                        )
                    );
                }
            }

            if ($cancelled || $valid) {
                // Redirect to /hello/world

                return $this->postActionRedirect(
                    array(
                        'returnUrl'       => $this->generateUrl('plugin_helloworld_world'),
                        'contentTemplate' => 'HelloWorldBundle:Default:world',
                        'flashes'         => $flashes
                    )
                );
            } // Otherwise show the form again with validation error messages
        }

        // Display the form
        return $this->delegateView(
            array(
                'viewParameters'  => array(
                    'form' => $form->createView()
                ),
                'contentTemplate' => 'HelloWorldBundle:Contact:form.html.php',
                'passthroughVars' => array(
                    'activeLink' => 'plugin_helloworld_contact',
                    'route'      => $this->generateUrl('plugin_helloworld_contact')
                )
            )
        );
    }
}