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
use Zend\Session\Container;

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
        // NOTE: you can use the line below to trap 404 and general dispatch errors
        //$eventManager->attach(MvcEvent::EVENT_DISPATCH_ERROR, [$this, 'onError'], 100);
    }

	public function onError(MvcEvent $e)
	{
        // set categories
        $this->onDispatch($e);
		// get view model + set variable for categories
        $viewModel = $e->getViewModel();
        $viewModel->setTemplate('error/alt-error');
        $viewModel->setVariable('message', '<h3>Hmmmm ... <br>we seem to have <br>encountered an error!</h3>');
	}
        
    public function onDispatch(MvcEvent $e)
    {
        $svcMgr = $e->getApplication()->getServiceManager();
        $viewModel = $e->getViewModel();
        $viewModel->setVariable('categories', $svcMgr->get('application-categories'));
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
        return ['Zend\Loader\ClassMapAutoloader' => [__DIR__ . '/autoload_classmap.php']];
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
                'application-session' => function ($sm) {
                    return new Container('onlineMarket');
                },
            ],
        ];
    }
}
