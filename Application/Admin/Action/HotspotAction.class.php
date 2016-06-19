<?php
namespace Admin\Action;
use Think\Action;
class HotspotAction extends CommonAction {
	private $sid;
	private $tid;
	
	public function __construct(){
		parent::__construct();
		if (I('sid')) {
			session('sid',I('sid'));
		}
		$this->sid=session('sid');
		$scene_data=D('Scene')->relation('tour')->find($sid);
		$this->tid=$scene_data['tour_id'];
		$this->assign('sid',$this->sid);
		$this->assign('scene_data',$scene_data);
	}
	
	public function index(){
		$model = D('Hotspot');
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
			$where['scene_id']  = array('EQ',$this->sid);
			$total = $model->where($where)->count();
			$data = $model->where($where)->relation(true)->order($order)->page($page.','.$rp)->select();
			header('Content-Type:text/xml; charset=utf-8');
			exit(hotspot_xml_encode(array('page'=>$page,'total'=>$total,'data'=>$data)));
		}else{
			$this->display();
		}
	}
	
	public function add(){
		if(IS_POST && I('form_submit')=='ok'){
			$this->save_news();
		}else{
			$nc = D('HotspotCategory')->order('sort')->select();
			$scenes=D('Scene')->where('tour_id='.$this->tid)->select();
			$this->set_back();
			$this->assign('nc',$nc);
			$this->assign('scenes',$scenes);
			$this->display();
		}
	}
	
	public function edit(){
		if(IS_POST && I('form_submit')=='ok'){
			$this->save_news();
		}else{
			$nc = D('HotspotCategory')->order('sort')->select();
			$scenes=D('Scene')->where('tour_id='.$this->tid)->select();
			$info = D('Hotspot')->find(I('id'));
			$this->set_back();
			$this->assign($info);
			$this->assign('nc',$nc);
			$this->assign('scenes',$scenes);
			$this->display();
		}
	}
	public function del(){
		$del_ids = explode(',',I('id'));
		$result2 = D('Hotspot')->where(array('hotspot_id'=>array('in',$del_ids)))->delete();
		if($result2 === false){
			$this->error('删除失败');
		}else{
			$this->success('删除成功',U('hotspot/index'));
		}
	}
	
	private function save_news(){
		$model = D('Hotspot');
		if(false === $data = $model->create()){
			$e = $model->getError();
			$this->error($e);
		}
		
		if($_FILES['file_pic']['size']>0){
			$pic_upload_info = upload_file('./attachment/','file_pic');
			$model->pic = $pic_upload_info['file_path'];
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

	public function save_configs(){
		$hotspot_id=I('id');//hotspot_id
		$hotspot_data=D('Hotspot')->find($hotspot_id);
		$scene_id=$hotspot_data['scene_id'];//scene_id
		$scene_data=D('Scene')->relation('attachment')->find($scene_id);
		$tour_id=$scene_data['tour_id'];//tour_id
		$model = D('Hotspot');
		$data[$model->getPk()] = I('id');
		foreach (I('get.') as $k => $v) {
			if ('id'!=$k) {
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
	
}