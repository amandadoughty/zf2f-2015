<?php
namespace Search\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Validator\File;
use Search\Form;
use Search\Model\ListingsTable;

class SearchController extends AbstractActionController
{
	protected $listingsTable;
	protected $searchForm;	
	protected $searchFormFilter;	
	protected $categories;
	
	public function indexAction()
    {
    	// messages
    	if ($this->flashMessenger()->hasMessages()) {
    		$messages = $this->flashMessenger()->getMessages();
    	} else {
    		$messages = array();
    	}
    	
    	// pull data from $_POST
   		$data = $this->params()->fromPost();

    	if (isset($data['submit'])) {
            return $this->forward()->dispatch('search-controller', array('action' => 'list'));
        }
        
    	// set up form
    	$this->searchForm->prepareElements($this->getServiceLocator()->get('categories'));

        return new ViewModel(array(	'categories' => $this->categories, 
        							'searchForm' => $this->searchForm, 
        							'messages' 	 => $messages,));
    }

    public function listAction()
    {
        // init vars
		$goHome   = TRUE;
        
    	// messages
    	if ($this->flashMessenger()->hasMessages()) {
    		$messages = $this->flashMessenger()->getMessages();
    	} else {
    		$messages = array();
    	}
    	// pull data from $_POST
   		$data = $this->params()->fromPost();

        // prepare filters
        $this->searchFormFilter->prepareFilters($this->categories);
        $this->searchFormFilter->setData($data);

        // validate data against the filter
        if ($this->searchFormFilter->isValid($data)) {
            
            // retrieve filtered and validated data from filter
            $validData = $this->searchFormFilter->getValues();

            // save searching to database and deal with results
            $results = $this->listingsTable->search($validData); 
            if ($results) {
                $goHome = FALSE;
            } else {
                // add flash message
                $this->flashMessenger()->addMessage('No results for this search!');
            }				
        } else {
            $messages = $this->searchFormFilter->getMessages();
        }
        
		if ($goHome) {
			return $this->redirect()->toRoute('search-home');
		} else { 	
    		return new ViewModel(array('messages'   => $messages,
                                       'categories' => $this->categories, 
    								   'shortList'  => $results));
		}
    }
    
    // called by SearchControllerFactory
    public function setListingsTable(ListingsTable $table)
    {
    	$this->listingsTable = $table;
    }
    
    // called by SearchControllerFactory
    public function setSearchForm(Form\SearchForm $form)
    {
    	$this->searchForm = $form;
    }
    
    // called by SearchControllerFactory
    public function setSearchFormFilter(Form\SearchFormFilter $filter)
    {
    	$this->searchFormFilter = $filter;
    }

    // called by SearchControllerFactory
    public function setCategories($categories)
    {
    	$this->categories = $categories;
    }
}
