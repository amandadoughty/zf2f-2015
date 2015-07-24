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
        $filter->setExpireDays($sm->get('market-expire-days'));
        $filter->setCities($sm->get('market-cities'));
        $filter->buildFilter();
        return $filter;
    }
}
