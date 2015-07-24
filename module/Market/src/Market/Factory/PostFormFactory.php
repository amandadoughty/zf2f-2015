<?php
namespace Market\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Market\Form\PostForm;

class PostFormFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $sm)
    {
        $form = new PostForm();
        $form->setCategories($sm->get('application-categories'));
        $form->setExpireDays($sm->get('market-expire-days'));
        $form->setCities($sm->get('market-cities'));
        $form->setCaptchaOptions($sm->get('market-captcha-options'));
        // TODO: set input filter
        $form->setInputFilter($sm->get('market-filter-post'));
        $form->buildForm();
        // NOTE: prepare() *must* follow binding the form to an object
        //$form->prepare();        
        return $form;
    }
}
