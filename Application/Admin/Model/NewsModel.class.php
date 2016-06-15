<?php
namespace Admin\Model;
use Think\Model\RelationModel;

class NewsModel extends RelationModel{
	
	protected $_validate = array(
        array('cat_id','require','请选择一个发布栏目'),
		array('title','require','请填写标题'),
		array('title','1,100','标题不能超过200个字符',0,'length'), 
		array('contents','require','请填完善详细内容'),
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
			'class_name'    => 'news_attachment',    
			'foreign_key'   => 'news_id',   
			'mapping_name'  => 'attachment',
		),
		'category' => array(
			'mapping_type'  => self::BELONGS_TO,    
			'class_name'    => 'news_category',    
			'foreign_key'   => 'cat_id',   
			'mapping_name'  => 'category',
		),
	);
}