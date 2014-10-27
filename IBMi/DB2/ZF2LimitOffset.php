<?php 
/* use Zend Db from within ordinary, non-framework PHP, to implement LIMIT/OFFSET-like functionality.
 * Note: ZF2 2.3 or higher is required
 * Assume ZF2 library folder is in PHP's include path. If not, add it using set_include_path().
 */
use Zend\Db\Sql\Sql;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Adapter\Driver\IbmDb2\Result;

require_once 'Zend/Loader/StandardAutoloader.php';
$loader = new Zend\Loader\StandardAutoloader(array('autoregister_zf' => true));
$loader->register();

$configArray = array(
      'driver' =>  'IbmDb2', 
      'database'=> '*LOCAL', 
      'username'=> 'MYUSER', 
      'password'=> 'MYPASS',
      'driver_options' => array(
           'i5_naming'=> DB2_I5_NAMING_ON,
           'i5_libl'  => 'ZENDSVR6 QGPL')    
);
$adapter = new Adapter($configArray);

// works with v2.3+ of ZF2.
$sql = new Sql($adapter);
$select = $sql->select();
$select->from('SP_CUST')
       ->where('CUST_ID > 1220')
       ->order('CUST_ID ASC')
       ->limit(10) // return 10 records
       ->offset(20); // start at record number 20

$stmt = $sql->prepareStatementForSqlObject($select);

$results = $stmt->execute();

// output result rows
foreach ($results as $result) {
    print_r($result);
} //(foreach ($results as $result))

