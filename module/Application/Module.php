<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application;

use DateTime;
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\ModuleManager\ModuleManager;

class Module
{
    public function init(ModuleManager $mm)
    {
        $eventManager = $mm->getEventManager();
        $shared = $eventManager->getSharedManager();
        //$shared->attach('*', '*', array($this, 'test'), 10);
    }
    
    public function onBootstrap(MvcEvent $e)
    {
        $eventManager        = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
        $eventManager->attach(MvcEvent::EVENT_DISPATCH, [$this,'onDispatch'], 100);
        $eventManager->attach(MvcEvent::EVENT_DISPATCH_ERROR, [$this,'onError'], 1000);
        //$eventManager->attach('*', [$this,'onTest'], 100);
    }

    public function onError(MvcEvent $e)
    {
        $response = $e->getResponse();
        $response->setContent('Have a great day');
        return $response;
    }
    
    public function onDispatch(MvcEvent $e)
    {
        $svcMgr = $e->getApplication()->getServiceManager();
        $viewModel = $e->getViewModel();
        $viewModel->setVariable('categories', $svcMgr->get('application-categories'));
    }
    
    public function test($e)
    {
        printf('<br>%20s : %20s : %5d', 
        $e->getName(), 
        get_class($e->getTarget()),
        count($e->getParams()));
    }
    
    public function onTest($e)
    {
        printf('<br>%20s : %20s : %5d', 
        $e->getName(), 
        get_class($e->getTarget()),
        count($e->getParams()));
    }
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    public function getServiceConfig()
    {
        return [
            'services' => [
                'application-test' => ['1' => __FILE__],
            ],
            'factories' => [
                'application-date-time' => function ($sm) {
                    return new \DateTime();
                },
            ],
        ];
    }
}
