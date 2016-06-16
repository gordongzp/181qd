<?php
namespace Admin\Model;
use Think\Model\RelationModel;

class TourModel extends RelationModel{
	
	protected $_validate = array(
		array('cat_id','require','请选择一个发布栏目'),
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
		'scene' => array(
			'mapping_type'  => self::HAS_MANY,    
			'class_name'    => 'scene',    
			'foreign_key'   => 'tour_id',   
			'mapping_name'  => 'scene',
			),
		'category' => array(
			'mapping_type'  => self::BELONGS_TO,    
			'class_name'    => 'tour_category',    
			'foreign_key'   => 'cat_id',   
			'mapping_name'  => 'category',
			),
		'admin' => array(
			'mapping_type'  => self::BELONGS_TO,    
			'class_name'    => 'admin',    
			'foreign_key'   => 'admin_id',   
			'mapping_name'  => 'admin',
			),
		);
}