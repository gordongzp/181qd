<?php
namespace Admin\Model;
use Think\Model\RelationModel;

class AuthModel extends RelationModel{
	
	
	protected $_link = array(
		'auth' => array(
			'mapping_type' => self::HAS_MANY,
			'class_name' => 'menu',
			'foregin_key' => 'menu_id',
			'mapping_name' => 'menu',
			'mapping_order' => 'sort',
		),
	);
	
	public function get_auth_menu($pid){
		$pid = intval($pid);
		$admin = session('admin');
		$where['role_id'] = $admin['role_id'];
		$this->_link['auth']['condition'] = ' pid='.$pid.' and status=1 and type=1 ';
		$menu = $this->relation('auth')->where($where)->select();
	}
	
	
	
	
		
	
	
    
}