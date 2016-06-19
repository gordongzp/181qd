<?php
namespace Admin\Action;
use Think\Action;
class InstalAction extends Action {
	public function index(){
		$this->createAdminRole();
		$this->createAdmin();
		$this->createMenu();
		$this->createAuth();
		$this->createNewsCategory();
		$this->createNews();
	}
	private function createAdmin(){
		if (count(M('admin')->select())) {
			return 0;
		}
		$dataList[] = array('admin_id'=>1,'role_id'=>12,'admin_name'=>'samsu','admin_password'=>md5('123456'),'status'=>1,'add_time'=>time(),'login_times'=>0,'is_supper'=>1,);
		$dataList[] = array('admin_id'=>2,'role_id'=>23,'admin_name'=>'admin','admin_password'=>md5('admin'),'status'=>1,'add_time'=>time(),'login_times'=>0,'is_supper'=>0,);
		if (M('admin')->addAll($dataList)) {
			echo "createAdmin suc <br>";
		}else{
			echo "createAdmin failed <br>";
		}
	}
	private function createAdminRole(){
		if (count(M('admin_role')->select())) {
			return 0;
		}
		$dataList[] = array('role_id'=>12,'role_name'=>'超级管理员','sort'=>1,'status'=>1,);
		$dataList[] = array('role_id'=>23,'role_name'=>'管理员','sort'=>0,'status'=>1,);
		if (M('admin_role')->addAll($dataList)) {
			echo "createAdminRole suc";
		}else{
			echo "createAdminRole failed";
		}
	}
	private function createAuth(){
		if (count(M('auth')->select())) {
			return 0;
		}
		$dataList[] = array('role_id'=>12,'menu_id'=>1,);
		$dataList[] = array('role_id'=>12,'menu_id'=>2,);
		$dataList[] = array('role_id'=>12,'menu_id'=>3,);
		$dataList[] = array('role_id'=>12,'menu_id'=>4,);
		$dataList[] = array('role_id'=>12,'menu_id'=>5,);
		$dataList[] = array('role_id'=>12,'menu_id'=>6,);
		$dataList[] = array('role_id'=>23,'menu_id'=>1,);
		$dataList[] = array('role_id'=>23,'menu_id'=>2,);
		$dataList[] = array('role_id'=>23,'menu_id'=>3,);
		$dataList[] = array('role_id'=>23,'menu_id'=>4,);
		// $dataList[] = array('role_id'=>23,'menu_id'=>23,);
		// $dataList[] = array('role_id'=>23,'menu_id'=>24,);
		// $dataList[] = array('role_id'=>23,'menu_id'=>25,);
		// $dataList[] = array('role_id'=>23,'menu_id'=>27,);
		if (M('auth')->addAll($dataList)) {
			echo "createAuth suc";
		}else{
			echo "createAuth failed";
		}
	}
	private function createMenu(){
		if (count(M('menu')->select())) {
			return 0;
		}
		$dataList[] = array('menu_id'=>1,'menu_name'=>'系统','pid'=>0,'type'=>1,'module_name'=>'','action_name'=>'','class_name'=>'','sort'=>1,'status'=>1);
		$dataList[] = array('menu_id'=>2,'menu_name'=>'核心','pid'=>1,'type'=>1,'module_name'=>'','action_name'=>'','class_name'=>'ico-system-0','sort'=>1,'status'=>1);
		$dataList[] = array('menu_id'=>3,'menu_name'=>'站点设置','pid'=>2,'type'=>1,'module_name'=>'System','action_name'=>'site_setting','class_name'=>'','sort'=>255,'status'=>1);
		$dataList[] = array('menu_id'=>4,'menu_name'=>'后台菜单','pid'=>2,'type'=>1,'module_name'=>'Menu','action_name'=>'index','class_name'=>'','sort'=>255,'status'=>1);
		$dataList[] = array('menu_id'=>5,'menu_name'=>'角色管理','pid'=>2,'type'=>1,'module_name'=>'Role','action_name'=>'index','class_name'=>'','sort'=>255,'status'=>1);
		$dataList[] = array('menu_id'=>6,'menu_name'=>'管理员','pid'=>2,'type'=>1,'module_name'=>'Admin','action_name'=>'index','class_name'=>'','sort'=>255,'status'=>1);
		$dataList[] = array('menu_id'=>27,'menu_name'=>'添加','pid'=>4,'type'=>0,'module_name'=>'Menu','action_name'=>'add','class_name'=>'','sort'=>255,'status'=>1);
		$dataList[] = array('menu_id'=>28,'menu_name'=>'删除','pid'=>4,'type'=>0,'module_name'=>'Menu','action_name'=>'del','class_name'=>'','sort'=>255,'status'=>1);
		$dataList[] = array('menu_id'=>29,'menu_name'=>'修改','pid'=>4,'type'=>0,'module_name'=>'Menu','action_name'=>'edit','class_name'=>'','sort'=>255,'status'=>1);
		$dataList[] = array('menu_id'=>43,'menu_name'=>'内容','pid'=>0,'type'=>1,'module_name'=>'','action_name'=>'','class_name'=>'','sort'=>3,'status'=>1);
		$dataList[] = array('menu_id'=>44,'menu_name'=>'资讯','pid'=>43,'type'=>1,'module_name'=>'','action_name'=>'','class_name'=>'ico-cms-2','sort'=>255,'status'=>1,);
		$dataList[] = array('menu_id'=>45,'menu_name'=>'文章分类','pid'=>44,'type'=>1,'module_name'=>'NewsCategory','action_name'=>'index','class_name'=>'','sort'=>255,'status'=>1);
		$dataList[] = array('menu_id'=>46,'menu_name'=>'文章管理','pid'=>44,'type'=>1,'module_name'=>'News','action_name'=>'index','class_name'=>'','sort'=>255,'status'=>1);
		$dataList[] = array('menu_id'=>47,'menu_name'=>'全景','pid'=>43,'type'=>1,'module_name'=>'News','action_name'=>'index','class_name'=>'ico-shop-1','sort'=>255,'status'=>1);
		$dataList[] = array('menu_id'=>48,'menu_name'=>'全景分类','pid'=>47,'type'=>1,'module_name'=>'TourCategory','action_name'=>'index','class_name'=>'','sort'=>222,'status'=>1);
		$dataList[] = array('menu_id'=>49,'menu_name'=>'全景列表','pid'=>47,'type'=>1,'module_name'=>'Tour','action_name'=>'index','class_name'=>'','sort'=>255,'status'=>1);
		$dataList[] = array('menu_id'=>50,'menu_name'=>'热点分类','pid'=>47,'type'=>1,'module_name'=>'HotspotCategory','action_name'=>'index','class_name'=>'','sort'=>255,'status'=>1);

		if (M('menu')->addAll($dataList)) {
			echo "createMenu suc";
		}else{
			echo "createMenu failed";
		}
	}
	private function createNews(){
		if (count(M('news')->select())) {
			return 0;
		}
		$dataList[] = array('id'=>5,'cat_id'=>4,'title'=>'玉锅','contents'=>'rrr','sort'=>0,'status'=>1,'update_time'=>time(),'source'=>'一建','view_times'=>100,'pic'=>12);
		$dataList[] = array('id'=>6,'cat_id'=>2,'title'=>'捷能','contents'=>'ggg','sort'=>0,'status'=>1,'update_time'=>time(),'source'=>'一建','view_times'=>100,'pic'=>12);
		if (M('news')->addAll($dataList)) {
			echo "createNews suc";
		}else{
			echo "createNews failed";
		}
	}

	private function createNewsCategory(){
		if (count(M('news_category')->select())) {
			return 0;
		}
		$dataList[] = array('cat_id'=>1,'cat_name'=>'毽球人物','sort'=>1);
		$dataList[] = array('cat_id'=>2,'cat_name'=>'毽球知识','sort'=>2);
		$dataList[] = array('cat_id'=>3,'cat_name'=>'毽球快讯','sort'=>3);
		$dataList[] = array('cat_id'=>4,'cat_name'=>'协会介绍','sort'=>4);
		if (M('news_category')->addAll($dataList)) {
			echo "createNewsCategory suc";
		}else{
			echo "createNewsCategory failed";
		}
	}


}	
