<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/zf2 for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Logger\Listener;

use Logger\Event\LoggerEvent;
use Zend\EventManager\ListenerAggregateInterface;
use Zend\EventManager\EventManagerInterface;
use Zend\Stdlib\CallbackHandler;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorAwareTrait;

/**
 * Logger listener aggregate
 */
class LogListener implements ListenerAggregateInterface, ServiceLocatorAwareInterface
{
    
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

    /**
     * Detach all previously attached listeners
     *
     * @param  EventManagerInterface $events
     * @return void
     */
    public function detach(EventManagerInterface $events)
    {
        foreach ($this->listeners as $key => $listener) {
            $detached = false;
            if ($listener === $this) {
                continue;
            }
            if ($listener instanceof ListenerAggregateInterface) {
                $detached = $listener->detach($events);
            } elseif ($listener instanceof CallbackHandler) {
                $detached = $events->detach($listener);
            }

            if ($detached) {
                unset($this->listeners[$key]);
            }
        }
    }

    public function logSomething($e)
    {
        $logger = $this->getServiceLocator()->get('logger-instance');
        $params = $e->getParams();
        if (isset($params['priority'])) {
            $priority = $params['priority'] & 0xb0111;
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
