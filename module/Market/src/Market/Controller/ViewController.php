<?php
namespace Market\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Insert;

class ViewController extends AbstractActionController
{
    public function indexAction()
    {
        $category  = $this->params()->fromRoute('category');
        $adapter   = $this->getServiceLocator()->get('general-adapter');
        $list      = $adapter->query('SELECT * FROM listings WHERE category = ?', [$category]);
        $viewModel = new ViewModel(['category' => $category,
                                    'list'     => $list,
        ]);
        return $viewModel;
    }
    public function itemAction()
    {
        $adapter   = $this->getServiceLocator()->get('general-adapter');
        $sql = new Sql($adapter);
        $select = $sql->select();
        $select->from(['L' => 'listings'])
               ->columns(['t' => 'title', 'd' => 'description']);
        echo $sql->getSqlStringForSqlObject($select, $adapter->getPlatform());
        $insert = $sql->insert();
        $insert->into('listings')
               ->columns(['title' => 'title', 'description' => 'description'])
               ->values(['Test Title 1', 'Description 1'], Insert::VALUES_SET)
               ->values(['Test Title 2', 'Description 2'], Insert::VALUES_MERGE)
        ;
        echo '<br>';
        echo $sql->getSqlStringForSqlObject($insert, $adapter->getPlatform());
        exit;
        
        $itemId    = $this->params()->fromRoute('itemId');
        if (!$itemId) {
            $this->flashMessenger()->addMessage('Item Not Found');
            return $this->redirect()->toRoute('market');
        }
        $viewModel = new ViewModel(['itemId' => $itemId]);
        return $viewModel;
    }
}
