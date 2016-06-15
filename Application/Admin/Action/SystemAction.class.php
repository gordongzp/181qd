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

	// public function clean(){
	// 	//新闻缩略图缓存
	// 	$pics=M('news')->field('pic')->select();
	// 	//新闻attachments缓存
	// 	$attachments=M('news_attachment')->field('path')->select();
	// 	//缓存拼接
	// 	foreach ($pics as $k => $v) {
	// 		$paths[]=$v['pic'];
	// 	}
	// 	foreach ($attachments as $k => $v) {
	// 		$paths[]=$v['path'];
	// 	}
	// 	$filesnames = scandir('./Uploads/attachment');
	// 	foreach ($filesnames as $k => $v) {
	// 		if ('.'==$v||'..'==$v) {
	// 			continue;
	// 		}
	// 		if (!in_array('./Uploads/attachment/'.$v,$paths,ture)) {
	// 			echo unlink('./Uploads/attachment/'.$v);
	// 			echo "<br>";
	// 		}	
	// 	}
	// }

	public function test(){
		$str=<<<str
		<xml>
			<ToUserName><![CDATA[{$ToUserName}]]></ToUserName>
			<FromUserName><![CDATA[{$FromUserName}]]></FromUserName>
			<CreateTime>{$CreateTime}</CreateTime>
			<MsgType><![CDATA[text]]></MsgType>
			<Content><![CDATA[{$msg}]]></Content>
		</xml>
str;
		$str.=<<<str
		<xml>
			<ToUserName><![CDATA[{$ToUserName}]]></ToUserName>
			<FromUserName><![CDATA[{$FromUserName}]]></FromUserName>
			<CreateTime>{$CreateTime}</CreateTime>
			<MsgType><![CDATA[text]]></MsgType>
			<Content><![CDATA[{$msg}]]></Content>
		</xml>
str;
		file_put_contents('./Public/viewer/examples/tour/tour.xml',$str);
	}
	
	
}