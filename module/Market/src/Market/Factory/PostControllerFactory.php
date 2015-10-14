<?php
namespace Market\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Market\Controller\PostController;

class PostControllerFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $sl)
    {
        $sm = $sl->getServiceLocator();
        $categories = $sm->get('categories'); 
        $controller = new PostController();
        $controller->setCategories($categories);
        $controller->setPostForm($sm->get('market-post-form'));
        return $controller;
    }
}