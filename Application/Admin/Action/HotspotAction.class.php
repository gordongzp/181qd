<?php
namespace Admin\Action;
use Think\Action;
class HotspotAction extends CommonAction {
	private $sid;
	public function __construct(){
		parent::__construct();
		if (I('sid')) {
			S('sid',I('sid'));
		}
		$this->sid=S('sid');
		$this->assign('sid',$this->sid);
	}
	
	public function index(){
		$model = D('Hotspot');
		$list = $model->where('scene_id='.$this->sid)->order('sort')->select();
		$this->assign('list',$list);
		$this->set_back();
		$this->display();
	}
	
	public function add(){
		if(IS_POST && I('form_submit')=='ok'){
			$this->save_data();
		}
		$this->set_back();
		$this->display();
	}
	
	public function save_data(){
		$model = D('Hotspot');
		if(false === $data = $model->create()){
			$e = $model->getError();
			$this->error($e);
		}
		
		if($data[$model->getPk()]){
			$result = $model->save();
		}else{
			$pk = $model->getPk();
			unset($model->$pk);
			$result = $model->add();
		}
		
		if($result === false){
			$this->error('保存失败');
		}else{
			$this->success('保存成功',U('Hotspot/index'));
		}
	}
	
	public function ajax_save_data(){
		$model = D('Hotspot');
		$data[I('branch')] = I('value');
		$data[$model->getPk()] = I('id');
		if(false === $data = $model->create($data)){
			$e = $model->getError();
			$this->error($e);
		}
		$result = $model->save();
		if($result === false){
			$this->error('保存失败');
		}else{
			$this->success('保存成功');
		}
	}
	
	public function del(){
		$del_ids = explode(',',I('id'));
		$model = D('Hotspot');
		$state = $model->where(array($model->getPk()=>array('in',$del_ids)))->delete();
		if($state!==false){
			$this->success('删除成功',U('Hotspot/index'));
		}else{
			$this->error('操作失败');
		}
	}
	
	
}