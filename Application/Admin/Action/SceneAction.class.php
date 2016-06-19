<?php
namespace Admin\Action;
use Think\Action;
class SceneAction extends CommonAction {
	private $tid;
	public function __construct(){
		parent::__construct();
		if (I('tid')) {
			session('tid',I('tid'));
		}
		$this->tid=session('tid');
		$this->assign('tid',$this->tid);
		$tour_data=D('Tour')->find($this->tid);
		$this->assign('tour_title',$tour_data['title']);
	}
	public function index(){
		$model = D('Scene');
		if(IS_AJAX){
			$page = I('curpage',1,'trim');
			$rp = I('rp',15,'trim');
			if(($sortname = I('sortname')) && ($sortorder = I('sortorder'))){
				$sortorder = I('sortorder');
				$order = $sortname.' '.$sortorder;
			}
			if(($keywords = I('request.qtype')) && ($value = I('request.query'))){
				$where[$keywords] = array('like','%'.$value.'%');
			}
			$where['tour_id']  = array('EQ',$this->tid);
			$total = $model->where($where)->count();
			$data = $model->where($where)->relation(true)->order($order)->page($page.','.$rp)->select();
			header('Content-Type:text/xml; charset=utf-8');
			exit(scene_xml_encode(array('page'=>$page,'total'=>$total,'data'=>$data)));
		}else{
			$this->set_back();
			$this->display();
		}
	}
	
	public function add(){
		if(IS_POST && I('form_submit')=='ok'){
			$this->save_news();
		}else{
			$this->set_back();
			$this->display();
		}
	}
	
	public function edit(){
		if(IS_POST && I('form_submit')=='ok'){
			$this->save_news();
		}else{
			$info = D('Scene')->relation('attachment')->find(I('id'));
			$this->set_back();
			$this->assign($info);
			$this->display();
		}
	}
	public function del(){
		$del_ids = explode(',',I('id'));
		$attachment = D('SceneAttachment')->field('path')->where(array('scene_id'=>array('in',$del_ids)))->select();
		$result3=D('Hotspot')->where(array('scene_id'=>array('in',$del_ids)))->delete();
		$result1 = D('SceneAttachment')->where(array('scene_id'=>array('in',$del_ids)))->delete();
		$result2 = D('Scene')->relation('attachment')->where(array('scene_id'=>array('in',$del_ids)))->delete();
		if($result2 === false){
			$this->error('删除失败');
		}else{
			foreach($attachment as $f){
				unlink($f['path']);
			}
			$this->success('删除成功',U('scene/index'));
		}
	}

	public function save_configs(){
		$model = D('Scene');
		$scene_id=I('id');//scene_id

		$scene_data=D('Scene')->find($scene_id);
		$tour_id=$scene_data['tour_id'];//tour_id

		$data[$model->getPk()] = I('id');
		foreach (I('get.') as $k => $v) {
			if ($model->getPk()!=$k) {
				$data[$k]=$v;
			}
		}		
		if(false === $data = $model->create($data)){
			$e = $model->getError();
			$this->error($e);
		}
		$result = $model->save();
		if($result === false){
			$this->error('保存失败');
		}else{
			$this->success('保存成功',U('Kp/file_put_and_show',array('id' =>$tour_id ,)));
		}
	}

	private function save_news(){
		$model = D('Scene');
		$attachment = I('attachment');
		if(false === $data = $model->create()){
			$e = $model->getError();
			$this->error($e);
		}
		
		if($_FILES['file_pic']['size']>0){
			$pic_upload_info = upload_file('./attachment/','file_pic');
			$model->pic = $pic_upload_info['file_path'];
		}
		
		if($attachment){
			$model->attachment = $attachment;
		}

		if($data[$model->getPk()]){
			$result = $model->relation('attachment')->save();
		}else{
			$pk = $model->getPk();
			unset($model->$pk);
			$result = $model->relation('attachment')->add();
		}
		
		if($result === false){
			$this->error('保存失败');
		}else{
			$this->success('保存成功',U('Scene/index'));
		}
	}
	
	//上传附件
	public function upload_attachment(){
		$upload_info = upload_file('./attachment/','fileupload');
		$this->ajaxReturn(array('status'=>1,'data'=>array('file_path'=>$upload_info['file_path'],'file_id'=>date('YmdHis'))));
	}
	
	//删除附件
	public function remove_attachment(){
		$file_path = I('file_path');
		$aid = I('aid');
		$nid = I('nid');
		$res1 = true;
		if($aid && $nid){
			$res1 = D('SceneAttachment')->where(array('atta_id'=>$aid,'scene_id'=>$nid))->delete();
		}
		$res2 = unlink($file_path);
		if($res1 && $res2){
			$this->success();
		}else{
			$this->error();
		}
	}
}