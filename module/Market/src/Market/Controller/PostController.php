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

class PostController extends AbstractActionController
{
    protected $categories;
    protected $postForm;
    
	public function indexAction()
    {
        
        // TODO: check to see if response is POST
        // TODO: validate inputs
        // TODO: insert filtered/validated data into database
        // QUES: if the form fails validation ... what needs to be done?
        $viewModel = new ViewModel(['categories' => $this->getCategories(),
                                    'postForm'   => $this->postForm]);
        // reset the view template
        $viewModel->setTemplate('market/post/index');
        return $viewModel;
    }
    
    public function getCategories()
    {
        return $this->categories;
    }

    public function setCategories($categories)
    {
        $this->categories = $categories;
    }

    public function setPostForm($postForm)
    {
        $this->postForm = $postForm;
    }
}
