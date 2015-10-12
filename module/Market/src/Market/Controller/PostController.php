<?php
namespace Market\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class PostController extends AbstractActionController
{
    protected $categories = array();
    public function indexAction()
    {
        $viewModel = new ViewModel(['categories' => $this->getCategories()]);
        return $viewModel;
    }
	/**
     * @return the $categories
     */
    public function getCategories()
    {
        return $this->categories;
    }

	/**
     * @param multitype: $categories
     */
    public function setCategories($categories)
    {
        $this->categories = $categories;
    }

}
