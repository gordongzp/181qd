<?php
namespace Admin\Model;
use Think\Model\RelationModel;

class AdminModel extends RelationModel{
	
		
	protected $_validate = array(
        array('admin_name','require','请输入管理员账号'),
        array('admin_name','','管理员已存在',0,'unique',1),
    );
	
	protected $_auto = array(
		array('admin_password','check_passowrd',3,'callback'),
		array('add_time','time',1,'function'), 
		array('admin_password','',2,'ignore'),
	);
	
	protected $_link = array(
		'role' => array(
			'mapping_type' => self::BELONGS_TO,
			'class_name' => 'admin_role',
			'mapping_name' => 'role',
			'foreign_key' => 'role_id',
		),
		
		
	);
	
	public function check_passowrd($value){
		$value = $value ? md5($value) : $value;
		return $value;
		
	}
	
	
	//检测操作
	public function check_exist($condition){
		return $this->where($condition)->find();
	}
	
	public function after_login($admin_id){
		if(!$admin_id){
			return false;
		}
		$this->where(array('admin_id'=>$admin_id))->save(array('last_login_time'=>time(), 'last_login_ip'=>get_client_ip()));
		$this->where(array('admin_id'=>$admin_id))->setInc('login_times',1);
	}
	
    
}