<?php
namespace Market\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class ViewController extends AbstractActionController
{
    public function indexAction()
    {
        $category = $this->params()->fromQuery('category');
        $viewModel = new ViewModel(['category' => $category]);
        return $viewModel;
    }
    public function itemAction()
    {
        $itemId    = $this->params()->fromQuery('itemId');
        if (!$itemId) {
            $this->flashMessenger()->addMessage('Item Not Found');
            return $this->redirect()->toRoute('market');
        }
        $viewModel = new ViewModel(['itemId' => $itemId]);
        return $viewModel;
    }
}
