<?php
/**
 * This module demonstrates how to setup a stand-alone listener class
 */
namespace Logger\Listener;

use Logger\Event\LoggerEvent;
use Zend\EventManager\EventManagerInterface;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorAwareTrait;
use Zend\EventManager\AbstractListenerAggregate;

/**
 * Logger listener aggregate
 */
class LogListener extends AbstractListenerAggregate implements ServiceLocatorAwareInterface
{
    // this trait gives you the "getServiceLocator()" method + $serviceLocator property
    use ServiceLocatorAwareTrait;
    
    /**
     * @var array
     */
    protected $listeners = array();

    /**
     * Attach one or more listeners
     *
     * @param  EventManagerInterface $events
     * @return DefaultListenerAggregate
     */
    public function attach(EventManagerInterface $events)
    {
        $shared = $events->getSharedManager();
        $this->listeners[] = $shared->attach('*', LoggerEvent::LOGGER_LOG, [$this, 'logSomething']);
        return $this;
    }

    public function logSomething($e)
    {
        $logger = $this->getServiceLocator()->get('logger-instance');
        $params = $e->getParams();
        if (isset($params['priority'])) {
            $priority = $params['priority'] & 0b0111;
        } else {
            $priority = 7;
        }
        if (isset($params['message'])) {
            $message = $params['message'];
        } else {
            $message = 'Unknown';
        }
        $logger->log($priority, $message);
    }
}
