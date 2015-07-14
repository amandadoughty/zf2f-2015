<?php
namespace Market\Controller;

// NOTE: a lot of developers also create a matching interface
//       i.e. ListingsTableAwareInterface

trait ListingsTableTrait
{
    protected $listingsTable;
    public function setListingsTable(\Market\Model\ListingsTable $table)
    {
        $this->listingsTable = $table;
    }
    public function getListingsTable()
    {
        return $this->listingsTable;
    }
}