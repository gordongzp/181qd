<?php
namespace Admin\Model;
use Think\Model;

class ProductCategoryModel extends Model{
		
	protected $_auto = array(
		array('update_time','time',1,'function') ,
	);

}