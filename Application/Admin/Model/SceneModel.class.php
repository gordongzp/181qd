<?php
namespace Admin\Model;
use Think\Model\RelationModel;

class SceneModel extends RelationModel{
	
	protected $_validate = array(
		array('title','require','请填写标题'),
		array('title','1,100','标题不能超过200个字符',0,'length'), 
		array('title','_unique_title','场景名称不能相同',0,'callback',3), 
		);
	
	protected $_auto = array(
		array('sort','_auto_sort',1,'callback'),
		array('update_time','time',3,'function'),
		);
	
	protected function _auto_sort($value){
		$value = $value ? $value : 0;
		return $value;
	}

	protected function _unique_title(){
		$data=I('post.');
		if (isset($data['tour_id'])) {
			//新建scene时
			$tour_id=$data['tour_id'];
		}else{
			//编辑scene时
			//找到tour_id
			$scene_data=$this->find($data['scene_id']);
			$tour_id=$scene_data['tour_id'];
			$title=$scene_data['title'];
		}
		//确定title是否唯一
		$where = array('tour_id' =>$tour_id ,'title' =>$data['title'] , );
		if ($this->where($where)->find()) {
			//判断特殊情况(编辑时不改名)
			if ($title==$data['title']) {
				return true;
			}
			return false;
		}
		return true;
	}
	
	protected $_link = array(
		'attachment' => array(
			'mapping_type'  => self::HAS_MANY,    
			'class_name'    => 'scene_attachment',    
			'foreign_key'   => 'scene_id',   
			'mapping_name'  => 'attachment',
			),
		'hotspot' => array(
			'mapping_type'  => self::HAS_MANY,    
			'class_name'    => 'hotspot',    
			'foreign_key'   => 'scene_id',   
			'mapping_name'  => 'hotspot',
			),
		'tour' => array(
			'mapping_type'  => self::BELONGS_TO,    
			'class_name'    => 'tour',    
			'foreign_key'   => 'tour_id',   
			'mapping_name'  => 'tour',
			),
		);
}