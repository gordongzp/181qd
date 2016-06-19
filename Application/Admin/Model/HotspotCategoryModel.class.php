<?php
namespace Admin\Model;
use Think\Model\RelationModel;

class HotspotCategoryModel extends RelationModel{
	
	protected $_validate = array(
        array('cat_name','require','分类名称不能为空'),
		array('cat_name','1,10','分类不能超过10个字符',0,'length'), 
		array('cat_name','','热点类型已经存在！',0,'unique',3),
		array('sort','number','排列序号必须是数字',2),
    );
	
	protected $_auto = array(
		array('sort','_auto_sort',1,'callback'),
	);
	
	protected function _auto_sort($value){
		$value = $value ? $value : 0;
		return $value;
	}
}