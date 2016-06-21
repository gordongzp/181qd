<?php
namespace Admin\Action;
use Think\Action;
class TourAction extends CommonAction {
	
	public function index(){
		$model = D('Tour');
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
			$where['admin_id']  = array('EQ',session('admin.admin_id'));
			$total = $model->where($where)->count();
			$data = $model->where($where)->relation(true)->order($order)->page($page.','.$rp)->select();
			header('Content-Type:text/xml; charset=utf-8');
			exit(tour_xml_encode(array('page'=>$page,'total'=>$total,'data'=>$data)));
		}else{
			$this->display();
		}
	}
	
	public function add(){
		if(IS_POST && I('form_submit')=='ok'){
			$this->save_news();
		}else{
			$nc = D('TourCategory')->order('sort')->select();
			$this->set_back();
			$this->assign('nc',$nc);
			$this->display();
		}
	}
	
	public function edit(){
		if(IS_POST && I('form_submit')=='ok'){
			$this->save_news();
		}else{
			$nc = D('TourCategory')->order('sort')->select();
			$info = D('Tour')->find(I('id'));
			$this->set_back();
			$this->assign($info);
			$this->assign('nc',$nc);
			$this->display();
		}
	}

	public function del(){

		$del_ids = explode(',',I('id'));
		//删除工作目录
		foreach ($del_ids as $k => $id) {
			$tour_work_path_name=md10($id);
			if (is_dir('./Public/'.C('KP_VIEWER_PATH_NAME').'/examples/'.$tour_work_path_name)){
				delDirAndFile('./Public/'.C('KP_VIEWER_PATH_NAME').'/examples/'.$tour_work_path_name);
			}
			//临时目录
			if (is_dir('./Public/'.C('KP_VIEWER_PATH_NAME').'/examples/'.$tour_work_path_name.'temp')){
				delDirAndFile('./Public/'.C('KP_VIEWER_PATH_NAME').'/examples/'.$tour_work_path_name.'temp');
			}
		}
		$tour_data=D('Tour')->relation('scene')->where(array('tour_id'=>array('in',$del_ids)))->select();

		//删除子scene
		$scene_ids='';
		foreach ($tour_data as $key => $value) {
			if (isset($value['scene'])) {
				foreach ($value['scene'] as $k => $v) {
					$scene_ids.=$v['scene_id'];
					$scene_ids.=',';
				}
			}	
		}
		if (count(explode(',',$scene_ids))>1) {
			$Scene=A('Scene');
			$Scene->del($scene_ids);
		}
		$result2 = D('Tour')->where(array('tour_id'=>array('in',$del_ids)))->delete();
		if($result2 === false){
			$this->error('删除失败');
		}else{
			foreach ($tour_data as $k => $v) {
				if ($v['pic']) {
					unlink($v['pic']);
				}
			}
			$this->success('删除成功',U('tour/index'));
		}
	}
	
	private function save_news(){
		$model = D('Tour');
		$tour_data=$model->find(I($model->getPk()));
		if(false === $data = $model->create()){
			$e = $model->getError();
			$this->error($e);
		}
		if($data[$model->getPk()]){
			if ($data['pic']=='') {
				$model->pic='';
				unlink($tour_data['pic']);
			}
			if($_FILES['file_pic']['size']>0){
				unlink($tour_data['pic']);
				$pic_upload_info = upload_file('./attachment/','file_pic');
				$model->pic = $pic_upload_info['file_path'];
			}

			$result = $model->save();
		}else{
			if($_FILES['file_pic']['size']>0){
				$pic_upload_info = upload_file('./attachment/','file_pic');
				$model->pic = $pic_upload_info['file_path'];
			}
			$pk = $model->getPk();
			unset($model->$pk);
			$result = $model->add();
		}
		
		if($result === false){
			$this->error('保存失败');
		}else{
			$this->success('保存成功',U('tour/index'));
		}
	}

	public function get_scene(){
		$del_ids = explode(',',I('id'));
		$data = D('Scene')->where(array('tour_id'=>array('in',$del_ids)))->select();
		foreach ($data as $k => $v) {
			$id[]=$v['scene_id'];
		}
		$this->ajaxReturn($id);
	}
	
}