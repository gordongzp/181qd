<?php
namespace Admin\Model;
use Think\Model\AdvModel;;

class ServerProductCategoryModel extends AdvModel{
		
	protected $tableName = 'jc_cwfl';
	
	protected $tablePrefix = '';
	
	protected $connection = 'sqlsrv://sa:zs1234565050801*@jmjilura.imwork.net:1433/zhl#utf8';
	
	//替换字段	
	protected $_map = array(
		'cat_id' => 'bm',
		'cat_name' => 'mc',
	);
	
	protected $_filter = array(
		'cat_id' => array('','trim'),
		'cat_name' => array('','trim'),
	);
	
	public function __construct(){
		parent::__construct();
		$fields = implode(',',$this->_map);
		$this->field($fields);
	}
}