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
        $category = $this->params()->fromRoute('category');
        $adapter = $this->getServiceLocator()->get('general-adapter');
        $list = $adapter->query('SELECT * FROM listings WHERE category = ?', [$category]);
        $viewModel = new ViewModel(['category' => $category, 'list' => $list]);
        return $viewModel;
    }
    public function itemAction()
    {
        $itemId = $this->params()->fromRoute('itemId');
        $adapter = $this->getServiceLocator()->get('general-adapter');
        $item = $adapter->query('SELECT * FROM listings WHERE listings_id = ? LIMIT 1', [$itemId]);
        $viewModel = new ViewModel(['itemId' => $itemId, 'item' => $item->current()]);
        return $viewModel;
    }
}
