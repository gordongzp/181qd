<?php
namespace Admin\Action;
use Think\Action;
class RoleAction extends CommonAction {
   
	public function __construct(){
		parent::__construct();
	}
	
	public function index(){
		$model = D('AdminRole');
		$list = $model->select();
		$this->assign('list',$list);
		$this->display();
	}
	
	public function add(){
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
	
	public function edit(){
		$role_id = I('role_id');
		$model = D('AdminRole');
		$menu_model = D('Menu');
		if(!$role_id || !D('AdminRole')->check_exist(array('role_id'=>$role_id))){
			$this->error('参数错误！');
		}
		$data = D('AdminRole')->relation('auth')->where(array('role_id'=>$role_id))->find();
		foreach($data['auth'] as $v){
			$select_menu_ids[] = $v['menu_id'];
		}
		
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
		$this->assign('select_menu_ids',json_encode($select_menu_ids));
		$this->assign($data);
		$this->assign('subject',$subject);
		$this->assign('ftitle',$ftitle);
		$this->assign('back',1);
		$this->display();
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
			$this->success('删除成功',U('role/index'));
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
			$this->success('保存成功',U('role/index'));
		}
	}
	
}