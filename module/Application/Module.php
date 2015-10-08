<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;

class Module
{
    public function onBootstrap(MvcEvent $e)
    {
        $eventManager        = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
        // attach a listener to the dispatch event
        $eventManager->attach(MvcEvent::EVENT_DISPATCH, array($this, 'onDispatch'), 100);
        // attach using the shared manager
        $shared = $eventManager->getSharedManager();
        //$shared->attach('WHATEVER', 'SPECIAL', array($this, 'onSpecial'));
    }

    public function onDispatch(MvcEvent $e)
    {
        $sm = $e->getApplication()->getServiceManager();
        $view = $e->getViewModel();
        $view->setVariable('categories', $sm->get('categories'));
    }
    
    public function onSpecial($e)
    {
        echo $e->getParam('test');
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
        return array(
            'services' => array(
                'application-service-test' => __FILE__,
                'application-service-test-array' => array(__FILE__),
            ),
            /*
            'factories' => array(
                'application-date-service' => function ($sm) {
                    return new \DateTime();
                }
            ),
            */
        );
       
    }
}
