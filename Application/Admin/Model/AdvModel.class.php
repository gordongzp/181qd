<?php
namespace Admin\Model;
use Think\Model\RelationModel;

class AdvModel extends RelationModel{
		
	protected $_validate = array(
        array('title','require','请填写广告名称'),
        array('group_id','require','请选择广告位置'),
        //array('sort','number','排序号不是一个有效数字'),
        array('start_time','require','请选择开始时间'),
        array('start_time','strtotime','开始时间不是一个有效时间',1,'function',3),
        array('end_time','require','请选择结束时间'),
        array('end_time','strtotime','结束时间不是一个有效时间',1,'function',3),
		array('end_time','check_between_time','结束时间必须大于开始时间',1,'callback',3), 
    );
	
	protected $_auto = array(
		 array('start_time','strtotime',3,'function'), 
		 array('end_time','strtotime',3,'function'), 
		 array('sort','_auto_sort',1,'callback'),
	);
	
	protected function _auto_sort($value){
		$value = $value ? $value : 0;
		return $value;
	}

	
	protected $_link = array(
		'group' => array(
			'mapping_type' => self::BELONGS_TO,
			'class_name' => 'adv_group',
			'foreign_key' => 'group_id',
			'mapping_name' => 'group',
		),
	);
	
	public function check_between_time($value){
		if(strtotime($value)>I('start_time','','strtotime')){
			return true;
		}else{
			return false;
		}
	}

}