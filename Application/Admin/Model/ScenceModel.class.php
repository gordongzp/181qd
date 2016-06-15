<?php
namespace Admin\Model;
use Think\Model\RelationModel;

class ScenceModel extends RelationModel{
	
	protected $_validate = array(
		array('title','require','请填写标题'),
		array('title','1,100','标题不能超过200个字符',0,'length'), 
		);
	
	protected $_auto = array(
		array('sort','_auto_sort',1,'callback'),
		array('update_time','time',3,'function'),
		);
	
	protected function _auto_sort($value){
		$value = $value ? $value : 0;
		return $value;
	}
	
	protected $_link = array(
		'attachment' => array(
			'mapping_type'  => self::HAS_MANY,    
			'class_name'    => 'scence_attachment',    
			'foreign_key'   => 'scence_id',   
			'mapping_name'  => 'attachment',
			),
		'hotspot' => array(
			'mapping_type'  => self::HAS_MANY,    
			'class_name'    => 'hotspot',    
			'foreign_key'   => 'scence_id',   
			'mapping_name'  => 'hotspot',
			),
		);
}