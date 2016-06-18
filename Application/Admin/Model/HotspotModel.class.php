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
		array('goto_scene_title','_goto_scene_title','无该场景',0,'callback',3), 
    );
	
	protected $_auto = array(
		array('sort','_auto_sort',1,'callback'),
	);
	
	protected function _auto_sort($value){
		$value = $value ? $value : 0;
		return $value;
	}

	protected function _goto_scene_title(){
		if (IS_POST) {
			//新建
			$goto_scene_title=I('goto_scene_title');
			$scene_id=I('scene_id');//hotspot所属的scene
			$scene_data=D('Scene')->find($scene_id);
			$tour_id=$scene_data['tour_id'];

			
		}else{
			//编辑
			$goto_scene_title=I('value');
			$hotspot_id=I('id');
			$hotspot_data=D('Hotspot')->find($hotspot_id);
			$scene_id=$hotspot_data['scene_id'];//scene_id
			$scene_data=D('Scene')->find($scene_id);
			$tour_id=$scene_data['tour_id'];//tour_id
		}
		//判断是否存在scene
		$where = array('tour_id' => $tour_id,'title' => $goto_scene_title, );
		if(D('Scene')->where($where)->find()){
			return true;
		}
		return false;
	}

	protected $_link = array(
		'scene' => array(
			'mapping_type'  => self::BELONGS_TO,    
			'class_name'    => 'scene',    
			'foreign_key'   => 'scene_id',   
			'mapping_name'  => 'scene',
		),
	);
}