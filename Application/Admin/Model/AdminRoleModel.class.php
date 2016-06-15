<?php
namespace Admin\Model;
use Think\Model\RelationModel;

class AdminRoleModel extends RelationModel{
	
	
	protected $_validate = array(
        array('role_name','require','请输入权限组'),
        array('role_name','','权限组已存在',0,'unique',1),
    );
	
	protected $_link = array(
		'auth' => array(
            'mapping_type'  => self::MANY_TO_MANY,
            'class_name'    => 'menu',
            'foreign_key'   => 'role_id',
            'relation_foreign_key'=>'menu_id',
            'relation_table' => 'cms_auth',
        ),
		'admin' => array(
			'mapping_type' => self::HAS_MANY,    
			'class_name' => 'admin',    
			'foreign_key' => 'role_id',
			'mapping_name' => 'admin',
		),
	);
	
	
	public function get_auth_menu($pid){
		$pid = intval($pid);
		$admin = session('admin');
		$where['role_id'] = $admin['role_id'];
		$this->_link['auth']['condition'] = ' status=1 and type=1 ';
		$menu = $this->relation('auth')->where($where)->find();
		foreach($menu['auth'] as $v){
			 $array[$v['menu_id']] = $v;
		}
		$tree = new \Admin\Lib\Tree;
		$tree->init($array,'menu_id','pid');
        $auth_menu = $tree->get_array($pid);
		return $auth_menu;
	}
	
	public function check_auth(){
		$admin = session('admin');
		$where['role_id'] = $admin['role_id'];
		$this->_link['auth']['condition'] = ' module_name="'.CONTROLLER_NAME.'" and action_name="'.ACTION_NAME.'"';
		$select_menu = $this->relation('auth')->where($where)->find();
		return $select_menu['auth'];
	}
	
	
	
	
	//检测操作
	public function check_exist($condition){
		return $this->where($condition)->count();
	}
	
    
}