<?php
namespace Admin\Model;
use Think\Model\AdvModel;;

class ServerProductModel extends AdvModel{
		
	protected $tableName = 'jc_spxx';
	
	protected $tablePrefix = '';
	
	protected $connection = 'sqlsrv://sa:zs1234565050801*@jmjilura.imwork.net:1433/zhl#utf8';
	
	//替换字段	
	protected $_map = array(
		'ser_id' => 'spbm',
		'cat_id' => 'cwfl',
		'product_name' => 'spmc',
		'spec' => 'ypgg',
		'origin_place' => 'chandi',
		'factory' => 'sccj',
		'unit' => 'dw',
		'approval_num' => 'pzwh',
		'price' => 'pzpj',
		'stock' => 'pfj',
		'update_time' => 'zhxgsj',
	);
	
	protected $_filter = array(
		'ser_id' => array('','trim'),
		'cat_id' => array('','trim'),
		'product_name' => array('','trim'),
		'spec' => array('','trim'),
		'origin_place' => array('','trim'),
		'factory' => array('','trim'),
		'unit' => array('','trim'),
		'approval_num' => array('','trim'),
		'price' => array('','trim'),
		'stock' => array('','intval'),
		'update_time' => array('','trim'),
	);
	
	public function __construct(){
		parent::__construct();
		$fields = implode(',',$this->_map);
		$this->field($fields);
	}
}