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
        echo $this->getServiceLocator()->get('application-service-test');
        \Zend\Debug\Debug::dump($this->getServiceLocator()->get('application-service-test-array'));
        $date = $this->getServiceLocator()->get('application-date-service');
        echo $date->format('Y-m-d H:i:s');
        $em = $this->getEventManager();
        $em->setIdentifiers('WHATEVER');
        $em->trigger('SPECIAL', $this, ['test' => __FILE__]);
        return new ViewModel();
    }

}
