<?php
namespace Admin\Model;
use Think\Model\RelationModel;

class OrderModel extends RelationModel{
	
	protected $_link = array(
		'order_product' => array(
            'mapping_type'  => self::HAS_MANY,
            'class_name'    => 'order_product',
            'foreign_key'   => 'order_id',
			'mapping_name'    => 'order_product',
        ),
	);
}