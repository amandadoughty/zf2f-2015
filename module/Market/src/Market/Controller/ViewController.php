<?php
namespace Market\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class ViewController extends AbstractActionController
{
    public function indexAction()
    {
        $viewModel = new ViewModel(['category' => 'CATEGORY POSTINGS']);
        return $viewModel;
    }
}
