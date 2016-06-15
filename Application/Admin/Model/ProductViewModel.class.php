<?php
namespace Admin\Model;
use Think\Model\ViewModel;

class ProductViewModel extends ViewModel{
	
	public $viewFields = array(
		'product' => array('*','_type'=>'LEFT'),
		'product_category' => array('cat_name','_on'=>'product.cat_id=product_category.cat_id'),
	);
}