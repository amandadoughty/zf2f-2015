<?php
namespace Market\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Market\Form\PostFilter;

class PostFilterFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $sm)
    {
        $categories = $sm->get('categories'); 
        $filter = new PostFilter();
        $filter->setCategories($categories);
        $filter->buildFilter();
        return $filter;
    }
}