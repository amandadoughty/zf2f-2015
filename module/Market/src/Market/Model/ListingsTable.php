<?php
namespace Market\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Sql;
class ListingsTable extends TableGateway
{
    const TABLE_NAME = 'listings';
    public function getMostRecentListing()
    {
        // SELECT * FROM listings 
        // ORDER BY listings_id DESC
        // LIMIT 1
        $sql = new Sql($this->getAdapter());
        $select = $sql->select();
        $select->from(self::TABLE_NAME)
               ->order('listings_id DESC')
               ->limit(1);
        return $this->selectWith($select)->current();
    }
}