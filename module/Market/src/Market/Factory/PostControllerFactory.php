<?php
namespace Market\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Market\Controller\PostController;

class PostControllerFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $sm = $serviceLocator->getServiceLocator();
        $controller = new PostController();
        $categories = $sm->get('application-categories');
        $controller->setCategories($categories);
        // inject form into controller
        $controller->setPostForm($sm->get('market-form-post'));
        return $controller;
    }
}
