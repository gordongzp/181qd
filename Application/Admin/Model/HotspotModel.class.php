<?php
namespace Admin\Model;
use Think\Model\RelationModel;

class HotspotModel extends RelationModel{
	
	protected $_validate = array(
        array('hotspot_name','require','热点名称不能为空'),
		array('hotspot_name','1,10','热点名称不能超过10个字符',0,'length'), 
		array('sort','number','排列序号必须是数字',2),
		array('type','require','类型不能为空'),
		array('type','/^[1-3]d*$/','类型格式：1：导航，2：链接，3：放大镜...',0),
    );
	
	protected $_auto = array(
		array('sort','_auto_sort',1,'callback'),
	);
	
	protected function _auto_sort($value){
		$value = $value ? $value : 0;
		return $value;
	}
}