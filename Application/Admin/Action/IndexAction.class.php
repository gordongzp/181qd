<?php
namespace Admin\Action;
use Think\Action;
class IndexAction extends CommonAction {
   
	public function __construct(){
		parent::__construct();
	}
   
	public function index(){
		$model = D('AdminRole');
		$admin = session('admin');
		if($admin['is_supper']==0){
			$menu = $model->get_auth_menu(0);
		}else{
			$menu = D('Menu')->get_all_menu(0);
		}
		$this->assign('auth_menu',$menu);
		$this->display();
	}
	
	//定时执行同步
	public function synchronous(){
		$sp_model = D('ServerProduct');
		$p_model = D('Product');
		$sp_datas = $sp_model->order('zhxgsj desc')->select();
		$p_datas = $p_model->order('update_time desc')->select();
		foreach($sp_datas as $spr){
			$is_add = true;
			foreach($p_datas as $k=>$pr){
				if($spr['ser_id']==$pr['ser_id']){
					if(strtotime($spr['update_time'])!=$pr['update_time']){
						if(false!==$data = $p_model->create($spr)){
							$state = $p_model->save();
						}else{
							$e = $model->getError();
							if(IS_AJAX){
								$this->error('同步失败');
							}
						}
					}
					$is_add = false;
					break;
				}
			}
			if($is_add && (false!==$data = $p_model->create($spr))){
				$p_model->add();
			}
		}
		
		if(IS_AJAX){
			$this->success('同步成功');
		}
	}
	
	
	/*登录*/
	public function login(){
		if(IS_POST){
			$admin_name = I('admin_name', 'trim');
            $admin_password = I('admin_password', 'trim');
			$verify_code = I('verify_code');
			$admin_model = D('admin');
			$role_model = D('AdminRole');
			if(!check_verify(I('verify_code'))){
				 $this->error('验证码错误,请重新输入');
			}
			$admin = $admin_model->where(array('admin_name'=>$admin_name,'admin_password'=>md5($admin_password)))->relation('role')->find();
			if(!$admin){
				$this->error('账号密码错误！');
			}else{
				session('admin', array(
					'admin_id' => $admin['admin_id'],
					'admin_name' => $admin['admin_name'],
					'role_id' => $admin['role_id'],
					'role_name' => $admin['role']['role_name'],
					'is_supper' => $admin['is_supper'],
				));
				
				$admin_model->after_login($admin['admin_id']);
				$this->success('登录成功！', U('index/index'));
			}
		}else{
			$this->display();
		}
	}
	
	/*退出*/
	public function logout(){
		session('admin', null);
        $this->success('退出成功！', U('index/login'));
        exit;
	}
	
}