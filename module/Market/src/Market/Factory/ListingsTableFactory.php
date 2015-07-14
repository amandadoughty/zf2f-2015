<?php
namespace Market\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Market\Model\ListingsTable;

class ListingsTableFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $sm)
    {
        // TODO: implement the MetaDataFeature to pre-populate the model w/ column names
        // __construct($table, AdapterInterface $adapter, $features = null, ResultSetInterface $resultSetPrototype = null, Sql $sql = null)
        return new ListingsTable(ListingsTable::TABLE_NAME, $sm->get('general-adapter'));
    }
}
