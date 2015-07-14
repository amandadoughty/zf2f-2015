<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;
use Logger\Event\LoggerEvent;

class IndexController extends AbstractActionController
{
    public function indexAction()
    {
        $test = $this->getEvent()->getRouteMatch();
        $date = $this->getServiceLocator()->get('application-date-time');
        $viewModel = new ViewModel(['test' => $test, 'date' => $date]);
        $viewModel->setTemplate('application/index/index');
        return $viewModel;
    }
    public function whateverAction()
    {
        $viewModel = new ViewModel();
        $viewModel->setVariable('whatever', 'TEST');
        $this->getEventManager()->trigger(LoggerEvent::LOGGER_LOG, $this, ['message' => __FILE__, 'priority' => 0]);
        return $viewModel;
    }
    public function testAction()
    {
        return new JsonModel(['whatever' => 'TEST']);
    }
}
