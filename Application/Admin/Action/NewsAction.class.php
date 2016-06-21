<?php
namespace Admin\Action;
use Think\Action;
class NewsAction extends CommonAction {
	
	public function index(){
		$model = D('News');
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
			$total = $model->where($where)->count();
			$data = $model->where($where)->relation(true)->order($order)->page($page.','.$rp)->select();
			header('Content-Type:text/xml; charset=utf-8');
			exit(news_xml_encode(array('page'=>$page,'total'=>$total,'data'=>$data)));
		}else{
			$this->display();
		}
	}
	
	public function add(){
		if(IS_POST && I('form_submit')=='ok'){
			$this->save_news();
		}else{
			$nc = D('NewsCategory')->order('sort')->select();
			$this->set_back();
			$this->assign('nc',$nc);
			$this->display();
		}
	}
	
	public function edit(){
		if(IS_POST && I('form_submit')=='ok'){
			$this->save_news();
		}else{
			$nc = D('NewsCategory')->order('sort')->select();
			$info = D('News')->relation('attachment')->find(I('id'));
			$this->set_back();
			$this->assign($info);
			$this->assign('nc',$nc);
			$this->display();
		}
	}


	public function del(){
		$del_ids = explode(',',I('id'));
		$news_data=D('News')->field('pic')->where(array('news_id'=>array('in',$del_ids)))->select();
		$attachment = D('NewsAttachment')->field('path')->where(array('news_id'=>array('in',$del_ids)))->select();
		$result1 = D('NewsAttachment')->where(array('news_id'=>array('in',$del_ids)))->delete();
		$result2 = D('News')->relation('attachment')->where(array('news_id'=>array('in',$del_ids)))->delete();
		if($result2 === false){
			$this->error('删除失败');
		}else{
			foreach($attachment as $f){
				unlink($f['path']);
			}
			foreach ($news_data as $k => $v) {
				if ($v['pic']) {
					unlink($v['pic']);
				}
			}
			$this->success('删除成功',U('news/index'));
		}
	}
	
	private function save_news(){
		$model = D('News');
		$news_data=$model->find(I($model->getPk()));
		$attachment = I('attachment');
		if(false === $data = $model->create()){
			$e = $model->getError();
			$this->error($e);
		}
		if($data[$model->getPk()]){
			if ($data['pic']=='') {
				$model->pic='';
				unlink($news_data['pic']);
			}
			if($_FILES['file_pic']['size']>0){
				unlink($news_data['pic']);
				$pic_upload_info = upload_file('./attachment/','file_pic');
				$model->pic = $pic_upload_info['file_path'];
			}

			if($attachment){
				$model->attachment = $attachment;
			}
			$result = $model->relation('attachment')->save();
		}else{
			if($_FILES['file_pic']['size']>0){
				$pic_upload_info = upload_file('./attachment/','file_pic');
				$model->pic = $pic_upload_info['file_path'];
			}

			if($attachment){
				$model->attachment = $attachment;
			}
			$pk = $model->getPk();
			unset($model->$pk);
			$result = $model->relation('attachment')->add();
		}
		
		if($result === false){
			$this->error('保存失败');
		}else{
			$this->success('保存成功',U('News/index'));
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
			$res1 = D('NewsAttachment')->where(array('atta_id'=>$aid,'news_id'=>$nid))->delete();
		}
		$res2 = unlink($file_path);
		if($res1 && $res2){
			$this->success();
		}else{
			$this->error();
		}
	}
}