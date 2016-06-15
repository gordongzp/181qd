<?php
namespace Admin\Action;
use Think\Action;
class ScenceAction extends CommonAction {
	private $tid;
	public function __construct(){
		parent::__construct();
		if (I('tid')) {
			S('tid',I('tid'));
		}
		$this->tid=S('tid');
		$this->assign('tid',$this->tid);
	}
	public function index(){
		$model = D('Scence');
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
			exit(scence_xml_encode(array('page'=>$page,'total'=>$total,'data'=>$data)));
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
			$info = D('Scence')->relation('attachment')->find(I('id'));
			$this->set_back();
			$this->assign($info);
			$this->display();
		}
	}
	public function del(){
		$del_ids = explode(',',I('id'));
		$attachment = D('ScenceAttachment')->field('path')->where(array('scence_id'=>array('in',$del_ids)))->select();
		$result3=D('Hotspot')->where(array('scence_id'=>array('in',$del_ids)))->delete();
		$result1 = D('ScenceAttachment')->where(array('scence_id'=>array('in',$del_ids)))->delete();
		$result2 = D('Scence')->relation('attachment')->where(array('scence_id'=>array('in',$del_ids)))->delete();
		if($result2 === false){
			$this->error('删除失败');
		}else{
			foreach($attachment as $f){
				unlink($f['path']);
			}
			$this->success('删除成功',U('scence/index'));
		}
	}
	
	private function save_news(){
		$model = D('Scence');
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
			$this->success('保存成功',U('Scence/index'));
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
			$res1 = D('ScenceAttachment')->where(array('atta_id'=>$aid,'scence_id'=>$nid))->delete();
		}
		$res2 = unlink($file_path);
		if($res1 && $res2){
			$this->success();
		}else{
			$this->error();
		}
	}
}