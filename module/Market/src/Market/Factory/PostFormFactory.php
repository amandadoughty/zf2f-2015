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
        $categories = $sm->get('application-categories');
        $form->setCategories($categories);
        // NOTE: what if ... ?
        // TODO: set input filter
        $form->setInputFilter($sm->get('market-filter-post'));
        $form->buildForm();
        // NOTE: prepare() *must* follow binding the form to an object
        //$form->prepare();        
        return $form;
    }
}