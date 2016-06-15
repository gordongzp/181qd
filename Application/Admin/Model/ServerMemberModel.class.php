<?php
namespace Admin\Model;
use Think\Model\AdvModel;;

class ServerMemberModel extends AdvModel{
		
	protected $tableName = 'jc_wldw';
	
	protected $tablePrefix = '';
	
	protected $connection = 'sqlsrv://sa:zs1234565050801*@jmjilura.imwork.net:1433/zhl#utf8';
	
	//替换字段	
	protected $_map = array(
		'account' => 'dwdm',
		'company_name' => 'dwmc',
		'company_address' => 'jydz',
		'update_time' => 'zhxgsj',
		'status' => 'hs_cj',
		
	);
	
	protected $_filter = array(
		'account' => array('','trim'),
		'company_name' => array('','trim'),
		'company_address' => array('','trim'),
		'update_time' => array('','strtotime'),
		'status' => array('','trim'),
	);
	
	public function __construct(){
		parent::__construct();
		$fields = implode(',',$this->_map);
		$this->field($fields);
	}
}