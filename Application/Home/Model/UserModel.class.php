<?php
namespace Home\Model;

use Think\Model\RelationModel;

class UserModel extends RelationModel{
	
	protected $_link = array(
		'role' => array(
			'mapping_type' => self::MANY_TO_MANY,
			'mapping_name' => 'role',
			'class_name' => 'role',
			'foreign_key' => 'user_id',
			'relation_foregin_key' => 'role_id',
			'relation_table' => '__USER_ROLE__',
		),
	);
}