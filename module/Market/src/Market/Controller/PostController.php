<?php
namespace Market\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Log\Logger;
use Logger\Event\LoggerEvent;
use Notification\NotificationEvent;

class PostController extends AbstractActionController
{
    
    const MAX_ATTEMPTS      = 3;
    const MSG_SUCCESS       = 'Successfully posted data';
    const MSG_EXCEEDED      = 'Exceeded max post attempts';
    const MSG_ERROR_POSTING = 'ERROR posting data!';
    
    use ListingsTableTrait;
    
    protected $categories;
    protected $postForm;
    protected $session;
    
	public function indexAction()
    {
        
        // init vars
        $data    = array();
        $request = $this->getRequest();
        $invalid = FALSE;
        $em      = $this->getEventManager();
        $em->addIdentifiers(NotificationEvent::NOTIFICATION_EVENT_IDENTIFIER);
        
        if ($request->isPost()) {
            
            // TODO: validate inputs
            $data = $request->getPost();
            $this->postForm->setData($data);
            
            if ($this->postForm->isValid()) {
                
                // TODO: insert filtered/validated data into database
                $data = $this->listingsTable->formToTableMapping($this->postForm->getData());
                
                if ($this->listingsTable->insert($data)) {
                    $info     = self::MSG_SUCCESS;
                    $priority = Logger::INFO;
                    $em->trigger(NotificationEvent::NOTIFICATION_EVENT_NOTIFY, 
                                 $this, 
                                 ['message' => $info, 
                                  'delCode' => $data['delete_code'],
                                  'serviceManager' => $this->getServiceLocator()]);
                } else {
                    $info     = self::MSG_ERROR_POSTING;
                    $priority = Logger::ERR;
                }
                
                $em->trigger(LoggerEvent::LOGGER_LOG, $this, ['priority' => $priority, 'message' => $info]);
                $this->flashmessenger()->addMessage($info);
                return $this->redirect()->toRoute('home');
                
            } else {
                
                // manage hit count
                if (isset($this->session->count)) {
                    
                    if ($this->session->count++ > self::MAX_ATTEMPTS) {
                        
                        $info = self::MSG_EXCEEDED;
                        $em->trigger(LoggerEvent::LOGGER_LOG, 
                                     $this, 
                                     ['priority' => Logger::WARN, 'message' => $info]);
                        $this->session->count = 1;
                        $this->flashmessenger()->addMessage($info);
                        return $this->redirect()->toRoute('home');
                        
                    }
                    
                } else {
                    
                    $this->session->count = 1;
                    
                }
                
            }
                        
            $invalid = TRUE;
            // QUES: if the form fails validation ... what needs to be done?
            // ANS:  just re-display the form w/ data + errors already embedded
        }
        
        if ($invalid) {
            $childModel = new ViewModel(['postForm'   => $this->postForm,
                                         'data'       => $data]);
            $childModel->setTemplate('market/post/index');
            $viewModel = new ViewModel();
            $viewModel->setTemplate('market/post/invalid');
            $viewModel->addChild($childModel, 'child');
        } else {
            $viewModel = new ViewModel(['postForm'   => $this->postForm,
                                        'data'       => $data]);
            // reset the view template
            $viewModel->setTemplate('market/post/index');
        }
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

    public function getSession()
    {
        return $this->session;
    }

    public function setSession($session)
    {
        $this->session = $session;
    }

    public function setPostForm($postForm)
    {
        $this->postForm = $postForm;
    }

}
