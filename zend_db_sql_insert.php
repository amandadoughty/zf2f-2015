<?php
include 'init_autoloader.php';

use Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\Insert;
use Zend\Db\Sql\Sql;

// setup adapter
$dbParams  = array(
			'driver' 	=> 'pdo_mysql',
			'dbname' 	=> 'zend',
			'host' 		=> 'localhost',
			'username' 	=> 'zend',
			'password' 	=> 'password');
$adapter = new Adapter($dbParams);

// values to be inserted
$values = [
    ['sku' => 11111, 'qty' => 11, 'price' => 11.11],
    ['sku' => 22222, 'qty' => 22, 'price' => 22.22],
    ['sku' => 33333, 'qty' => 33, 'price' => 33.33]
];

// setup the SQL statement
$sql    = new Sql($adapter);
$insert = $sql->insert();
$insert->into('products')
       ->columns(['sku','qty','price']);
       
foreach ($values as $row) {
    $insert->values($row, Insert::VALUES_MERGE);
    echo $insert->getSqlString($adapter->getPlatform());
    echo PHP_EOL;
}

// NOTE: rather than throw 3 INSERT statements at the database server,
//       consider using the following:
$insert->into('products')
       ->columns(['sku','qty','price'])
       ->values(['sku' => ':sku','qty' => ':qty', 'price' => ':price']);
echo $insert->getSqlString($adapter->getPlatform());
echo PHP_EOL;
/*
$statement = $sql->prepareStatementForSqlObject($insert);
foreach ($values as $row) {
    $statement->execute($row);
}
*/
