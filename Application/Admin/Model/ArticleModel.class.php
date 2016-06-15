<?php
namespace Admin\Model;
use Think\Model\RelationModel;

class ArticleModel extends RelationModel{
	
	protected $_validate = array(
	    array('title','require','标题不能为空'),
        array('contents','require','内容不能为空'),
    );
	
	protected $_auto = array(
		array('update_time','time',3,'function'),
		array('sort','_auto_sort',1,'callback'),
	);
	
	protected function _auto_sort($value){
		$value = $value ? $value : 0;
		return $value;
	}
	
	/*protected $_link = array(
		'category' => array(
			'mapping_type' => self::BELONGS_TO,
			'class_name' => 'category',
			'foreign_key' => 'cat_id',
			'mapping_name' => 'category',
		),
	);*/
}