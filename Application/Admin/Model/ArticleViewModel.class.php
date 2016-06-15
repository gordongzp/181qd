<?php
namespace Admin\Model;
use Think\Model\ViewModel;

class ArticleViewModel extends ViewModel{
	
	public $viewFields = array(
		'article' => array('*','_type'=>'LEFT'),
		'category' => array('cat_name','_on'=>'article.cat_id=category.cat_id'),
	);
}