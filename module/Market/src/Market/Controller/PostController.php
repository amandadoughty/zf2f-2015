<?php
namespace Market\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Log\Logger;
use Logger\Event\LoggerEvent;

class PostController extends AbstractActionController
{
    use ListingsTableTrait;
    protected $categories;
    protected $postForm;
    
	public function indexAction()
    {
        
        // TODO: check to see if response is POST
        $request = $this->getRequest();
        if ($request->isPost()) {
            // TODO: validate inputs
            $this->postForm->setData($request->getPost());
            if ($this->postForm->isValid()) {
                // TODO: insert filtered/validated data into database
                // $data = $this->postForm->getData();
                $this->flashmessenger()->addMessage('Successfully posted data');
                $this->redirect()->toRoute('home');
            }
            // QUES: if the form fails validation ... what needs to be done?
            //       Just re-display the form w/ data + errors already embedded
        }
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
