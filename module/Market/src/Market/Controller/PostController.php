<?php
namespace Market\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Log\Logger;
use Logger\Event\LoggerEvent;

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

    protected function logSomething($message)
    {
        $this->getEventManager()->trigger(LoggerEvent::LOGGER_LOG, 
                                          $this, 
                                          ['priority' => 7, 'message' => $message]);
    }
    
}
