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

class IndexController extends AbstractActionController
{
    public function indexAction()
    {
        $test = $this->getEvent()->getRouteMatch();
        $date = $this->getServiceLocator()->get('application-date-time');
        return new ViewModel(['test' => $test, 'date' => $date]);
    }
    public function whateverAction()
    {
        $response = $this->getResponse();
        $response->setContent('Whatever');
        return $response;
    }
}
