<?php
namespace Admin\Action;
use Think\Action;
use Admin\Lib\Seccode;

class CommonAction extends Action {
    
	public function __construct(){
		parent::__construct();
		$this->check_login();
		// $this->check_auth();
		
	}
	
	public function check_login(){
		if(!in_array(ACTION_NAME,array('login','logout','makecode','synchronous'))){
			$admin = session('admin');
			if(!($admin['admin_id'] && $admin['admin_name'])){
				$this->redirect('index/login');
				exit;
			}
			$this->assign('admin',$admin);
		}
	}
	
	public function check_auth(){
		if(in_array(CONTROLLER_NAME, array('Index'))){
            return true;
        }
		
		$select_menu = D('AdminRole')->check_auth();
		if(!$select_menu) $this->error('对不起，你没有权限');
	}
	
	public function makecode(){
		$Verify = new \Think\Verify(array('fontSize'=>60,'length'=>4,'fontttf'=>'5.ttf'));
		$Verify->entry();
	}
	
	//设置后退按钮
	protected function set_back($url=''){
		$url = $url ? $url : 'javascript:history.go(-1)';
		$html = '<a class="back" href="'.$url.'" title="返回列表"><i class="fa fa-arrow-circle-o-left"></i></a>';
		$this->assign('back_htn_html',$html);
	}
	
	//上传文件
	protected function upload_file($savepath,$field){
		$upload = new \Think\Upload(C('UPLOAD_CONFIG'));
		$upload->savePath = $savepath;
		$upload->subName = $group_id;
		$upload_info = $upload->upload();
		if(!$upload_info) { 
			$this->error($upload->getError());
		}else{
			$file_path = './Uploads'.ltrim($upload_info[$field]['savepath'],'.').$upload_info[$field]['savename'];
			$upload_info[$field]['file_path'] = $file_path;
			return $upload_info[$field];
		}
	}
	
}