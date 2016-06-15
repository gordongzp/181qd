<?php
namespace Admin\Model;
use Think\Model\RelationModel;

class CategoryModel extends RelationModel{
	
	protected $_validate = array(
	    array('module_id','require','模型不能为空'),
        array('cat_name','require','栏目名不能为空'),
    );
	
	protected $_auto = array(
		array('sort','_auto_sort',1,'callback'),
	);
	
	protected function _auto_sort($value){
		$value = $value ? $value : 0;
		return $value;
	}
	
	protected $_link = array(
		'module' => array(
			'mapping_type' => self::BELONGS_TO,
			'class_name' => 'module',
			'foreign_key' => 'module_id',
			'mapping_name' => 'module',
		),
		'page' => array(
			'mapping_type' => self::HAS_ONE,
			'class_name' => 'page',
			'foreign_key' => 'cat_id',
			'mapping_name' => 'page',
		),
	);
}