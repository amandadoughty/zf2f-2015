<?php
namespace Application\Service;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class ControllerServiceFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $sm)
    {
        $service = new ControllerService();
        $service->setTest($sm->get('application-service-test'));
        return $service;
    }
}