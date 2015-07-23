<?php
namespace Market\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Market\Form\PostFilter;

class PostFilterFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $sm)
    {
        $filter = new PostFilter();
        $categories = $sm->get('application-categories');
        $filter->setCategories($categories);
        // NOTE: what if ... ?
        // TODO: set input filter
        $filter->buildFilter();
        return $filter;
    }
}
