<?php
namespace Admin\Model;
use Think\Model;

class ProductModel extends Model{
		
	protected $_auto = array(
		array('update_time','strtotime',3,'function') ,
	);

}