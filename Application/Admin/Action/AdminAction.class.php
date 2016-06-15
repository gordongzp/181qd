<?php
namespace Admin\Action;
use Think\Action;
class AdminAction extends CommonAction {
   
	public function __construct(){
		parent::__construct();
	}
	
	/*管理员列表*/
	public function index(){
		$model = D('Admin');
		$list = $model->order('add_time desc')->relation('role')->select();
		$this->assign('list',$list);
		$this->display();
	}
	
	/*添加管理员*/
	public function add(){
		$role_model = D('AdminRole');
		$group = D('AdminRole')->order('sort')->select();
		$this->assign('group',$group);
		$this->display();
	}
	
	/*编辑管理员*/
	public function edit(){
		$model = D('Admin');
		$role_model = D('AdminRole');
		$admin_id = I('admin_id');
		$data = $model->where(array('admin_id'=>$admin_id))->find();
		$group = D('AdminRole')->order('sort')->select();
		$this->assign('group',$group);
		$this->assign($data);
		$this->display();
	}
	
	/*保存管理员*/
	public function save_admin(){
		$model = D('Admin');
		if(false === $data = $model->create()){
			$e = $model->getError();
			$this->error($e);
		}
		
		if($data['admin_id']){
			$result = $model->save();
		}else{
			$result = $model->add();
		}
		
		if($result === false){
			$this->error('保存失败');
		}else{
			$this->success('保存成功',U('admin/index'));
		}
	}
	
	/*删除管理员*/
	public function del_admin(){
		$admin_id = I('admin_id');
		$model = D('Admin');
		$state = $model->delete($admin_id);
		if($state!==false){
			$this->success('删除成功',U('admin/index'));
		}else{
			$this->error('操作失败');
		}
	}
	
	public function group(){
		$model = D('AdminRole');
		$list = $model->select();
		$this->assign('list',$list);
		$this->display();
	}
	
	public function add_group(){
		$menu_model = D('Menu');
		$menu_list = $menu_model->where(array('type'=>1))->select();
		foreach($menu_list as $v){
			 $array[$v['menu_id']] = $v;
		}
		$tree = new \Admin\Lib\Tree;
		$tree->init($array);
        $menu = $tree->get_array(0);
		$subject = '权限管理-编辑权限组';
		$ftitle = '权限操作设置详情';
		$this->assign('menu',$menu);
		$this->assign('subject',$subject);
		$this->assign('ftitle',$ftitle);
		$this->assign('back',1);
		$this->display();
	}
	
	public function edit_group(){
		$role_id = I('role_id');
		$model = D('AdminRole');
		$menu_model = D('Menu');
		if(!$role_id || !D('AdminRole')->check_exist(array('role_id'=>$role_id))){
			$this->error('参数错误！');
		}
		$data = D('AdminRole')->where(array('role_id'=>$role_id))->find();
		
		$menu_list = $menu_model->where(array('type'=>1))->select();
		foreach($menu_list as $v){
			 $array[$v['menu_id']] = $v;
		}
		$tree = new \Admin\Lib\Tree;
		$tree->init($array);
        $menu = $tree->get_array(0);
		
		$subject = '权限管理-编辑权限组';
		$ftitle = '权限操作设置详情';
		
		$this->assign('menu',$menu);
		$this->assign($data);
		$this->assign('subject',$subject);
		$this->assign('ftitle',$ftitle);
		$this->assign('back',1);
		$this->display();
	}
	
	/*检测管理员是否存在*/
	public function check_admin_exist(){
		$admin_name = I('admin_name');
		$admin_id = I('admin_id');
		$where['admin_name'] = I('admin_name');
		if(I('admin_id')){
			$where['admin_id'] = array('neq',I('admin_id'));
		}
		$state = D('Admin')->check_exist($where) ? false : true;
		if(IS_AJAX){
			$this->ajaxReturn($state);
		}else{
			return $state;
		}
	}
	
	/*检测权限组是否存在*/
	public function check_role_exist(){
		$role_name = I('role_name');
		$role_id = I('role_id');
		$where['role_name'] = $role_name;
		if($role_id){
			$where['role_id'] = array('neq',I('role_id'));
		}
		$state = D('AdminRole')->check_exist($where) ? false : true;
		if(IS_AJAX){
			$this->ajaxReturn($state);
		}else{
			return $state;
		}
	}
	
	/*删除权限组*/
	public function del_role(){
		$model = D('AdminRole');
		$role_id = I('role_id');
		if(!$role_id) $this->error('参数错误');
		$status = $model->relation(true)->delete($role_id);
		if($status!==false){
			$this->success('删除成功',U('admin/group'));
		}else{
			$this->error('操作失败');
		}
	}
	
	/*保存权限组*/
	public function save_role(){
		$model = D('AdminRole');
		$auth = I('auth');
		if(false === $data = $model->create()){
			$e = $model->getError();
			$this->error($e);
		}
		
		if($auth){
			foreach($auth as $v){
				$auth_d[] = array('menu_id'=>$v);
			}
			$model->auth = $auth_d;
		}
		
		if($data['role_id']){
			$result = $model->relation('auth')->save();
		}else{
			$result = $model->relation('auth')->add();
		}
		
		if($result === false){
			$this->error('保存失败');
		}else{
			$this->success('保存成功',U('admin/group'));
		}
	}

}