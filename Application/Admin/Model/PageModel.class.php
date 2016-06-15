<?php
namespace Admin\Model;
use Think\Model\RelationModel;

class PageModel extends RelationModel{
	
	protected $_validate = array(
	    array('title','require','标题不能为空'),
        array('contents','require','内容不能为空'),
    );
	
	protected $_link = array(
		'category' => array(
			'mapping_type' => self::BELONGS_TO,
			'class_name' => 'category',
			'foreign_key' => 'cat_id',
			'mapping_name' => 'category',
		),
	);
}