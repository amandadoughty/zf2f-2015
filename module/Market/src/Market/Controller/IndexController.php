<?php
namespace Market\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController
{
    // NOTE: don't need a "use" statement: trait is in the same namespace
    use ListingsTableTrait;
    
    public function indexAction()
    {
        $item = $this->listingsTable->getMostRecentListing();
        $messages = array();
        if ($this->flashMessenger()->hasMessages()) {
            $messages = $this->flashMessenger()->getMessages();
        }
        return new ViewModel(['messages' => $messages, 'item' => $item]);
    }

    public function fooAction()
    {
        // This shows the :controller and :action parameters in default route
        // are working when you browse to /module-specific-root/skeleton/foo
        return array();
    }
}
