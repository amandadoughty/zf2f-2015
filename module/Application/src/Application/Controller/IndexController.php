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

class IndexController extends AbstractActionController
{
    public function indexAction()
    {
        //\Zend\Debug\Debug::dump($this->params()->fromQuery());
        //\Zend\Debug\Debug::dump($this->getEvent()->getRouteMatch());
        //echo $this->getServiceLocator()->get('application-service-test');
        //\Zend\Debug\Debug::dump($this->getServiceLocator()->get('application-service-test-array'));
        $date = $this->getServiceLocator()->get('application-date-service');
        //echo $date->format('Y-m-d H:i:s');
        $em = $this->getEventManager();
        $em->setIdentifiers('WHATEVER');
        $em->trigger('SPECIAL', $this, ['test' => __FILE__]);
        $viewModel = new ViewModel();
        // uncomment line below to make this the parent and shut off the layout
        //$viewModel->setTerminal(TRUE);
        $childModel = new ViewModel(['test' => 'TEST']);
        $childModel->setTemplate('application/index/whatever');
        $viewModel->addChild($childModel, 'capture');
        return $viewModel;
    }

    public function testAction()
    {
        $data = ['a' => 123, 'b' => 456, 'c' => 789];
        $viewModel = new ViewModel($data);
        return $viewModel;
        //$jsonModel = new JsonModel($data);
        //return $jsonModel;
    }
}
