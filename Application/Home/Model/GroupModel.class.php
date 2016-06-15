<?php
namespace Home\Model;

use Think\Model\RelationModel;

class GroupModel extends RelationModel{
	
	protected $_link = array(
		'user' => array(
			'mapping_type' => self::MANY_TO_MANY,
			'mapping_name' => 'user',
			'class_name' => 'user',
			'foreign_key' => 'role_id',
			'relation_foregin_key' => 'user_id',
			'relation_table' => '__USER_ROLE__',
		),
	);
}