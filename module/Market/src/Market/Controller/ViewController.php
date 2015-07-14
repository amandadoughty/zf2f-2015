<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/Market for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Market\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class ViewController extends AbstractActionController
{
    public function indexAction()
    {
        $category = $this->params()->fromQuery('category');
        $viewModel = new ViewModel(['categories' => $category]);
        return $viewModel;
    }
    public function itemAction()
    {
        $itemId = $this->params()->fromQuery('itemId');
        $viewModel = new ViewModel(['itemId' => $itemId]);
        return $viewModel;
    }
}
