<?php
namespace Admin\Action;
use Think\Action;
class SystemAction extends CommonAction {
	
	public function __construct(){
		parent::__construct();
	}
	
	public function site_setting(){
		if(IS_POST && I('form_submit')=='ok'){
			unset($_POST['form_submit']);
			F('site_setting',I());
			$this->success('保存成功',U());
		}else{
			$site_setting = F('site_setting');
			$this->assign($site_setting);
			$this->assign('subject','站点设置');
			$this->display();
		}
	}

	public function clean(){
		//新闻attachments缓存
		$news_atta=D('NewsAttachment')->field('path')->select();
		//scene_attachments缓存
		$scene_atta=D('SceneAttachment')->field('path')->select();
		//缓存拼接
		foreach ($news_atta as $k => $v) {
			$paths[]=$v['pic'];
		}
		foreach ($scene_atta as $k => $v) {
			$paths[]=$v['path'];
		}


		$filesnames = scandir('./Uploads/attachment');
		foreach ($filesnames as $k => $v) {
			if ('.'==$v||'..'==$v) {
				continue;
			}
			if (!in_array('./Uploads/attachment/'.$v,$paths,ture)) {
				echo unlink('./Uploads/attachment/'.$v);
				echo "<br>";
			}	
		}
	}


	
	
}