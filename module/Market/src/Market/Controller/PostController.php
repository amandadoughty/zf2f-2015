<?php
namespace Market\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class PostController extends AbstractActionController
{
    protected $categories = array();
    protected $postForm;
    
    public function indexAction()
    {
        $data = array();
        if ($this->getRequest()->isPost()) {
            $data = $this->params()->fromPost();
            // assign data to form/filter
            $this->postForm->setData($data);
            if ($this->postForm->isValid()) {
                // filtered and validated data
                $data = $this->postForm->getData();
            }
        }
        $viewModel = new ViewModel(['categories' => $this->getCategories(),
                                    'postForm'   => $this->getPostForm(),
                                    'data'       => $data,
        ]);
        $viewModel->setTemplate('market/post/index');
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
	/**
     * @return the $postForm
     */
    public function getPostForm()
    {
        return $this->postForm;
    }

	/**
     * @param field_type $postForm
     */
    public function setPostForm($postForm)
    {
        $this->postForm = $postForm;
    }


}
