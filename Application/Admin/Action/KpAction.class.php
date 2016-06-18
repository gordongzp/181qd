<?php
namespace Admin\Action;
use Think\Action;
class KpAction extends CommonAction {
	
	public function __construct(){
		parent::__construct();
	}

	public function show(){
		$tour_work_path_name=md10(I('id'));
		echo '<script>window.location.href=\'./Public/'.C('KP_VIEWER_PATH_NAME').'/examples/'.$tour_work_path_name.'/index.html\';</script>';
	}

	public function file_put_and_show(){
		$this->file_put();
		$this->show();
	}

	public function file_put(){
		$id=I('id');
		$this->put($id);
	}

	public function file_put_all(){
		$data=D('Admin')->relation('tour')->find(session('admin.admin_id'));
		foreach ($data['tour'] as $k => $tour) {
			$this->put($tour['tour_id']);
		}
		$this->success('生成完毕',U('tour/index'));
	}

	public function put($id){
		$KP_PANOS_PATH_NAME=C('KP_PANOS_PATH_NAME');
		$KP_MOBILE_NAME=C('KP_MOBILE_NAME');
		$tour_work_path_name=md10($id);
		$tour=D('Tour')->relation('scene')->where('tour_id='.$id)->find();
		if ($tour['scene']) {
			foreach ($tour['scene'] as $k => $v) {
				$scene_ids[]=$v['scene_id'];
			}
			$scenes=D('scene')->relation(true)->where(array('scene_id'=>array('in',$scene_ids)))->order('sort asc')->select();
		}
		//检查是否有工作目录,有则删除,没有则创建
		if (is_dir('./Public/'.C('KP_VIEWER_PATH_NAME').'/examples/'.$tour_work_path_name)){
			delDirAndFile('./Public/'.C('KP_VIEWER_PATH_NAME').'/examples/'.$tour_work_path_name);
		}
		recurse_copy('./Public/'.C('KP_VIEWER_PATH_NAME').'/examples/'.C('KP_TEMPLATE_NAME'),'./Public/'.C('KP_VIEWER_PATH_NAME').'/examples/'.$tour_work_path_name);
			//修改index入口文件
		$str=<<<str
<!DOCTYPE html>
<html>
<head>
<!-- redirect to the root krpano.html to avoid local browser restrictions -->
<meta http-equiv="refresh" content="0; url=../../krpano.html?xml=examples/{$tour_work_path_name}/tour.xml" />
<style>body{background-color:#000000;}</style>
</head>
</html>
str;
		file_put_contents('./Public/'.C('KP_VIEWER_PATH_NAME').'/examples/'.$tour_work_path_name.'/index.html',$str);

		//场景文件组织
		foreach ($scenes as $k => $scene) {
			$scene_path_name=md10($scene['scene_id']);
			//创建场景目录
			mkdir('./Public/'.C('KP_VIEWER_PATH_NAME').'/examples/'.$tour_work_path_name.'/'.C('KP_PANOS_PATH_NAME').'/'.$scene_path_name);
			//构建场景thumb
			copy($scene['pic'],'./Public/'.C('KP_VIEWER_PATH_NAME').'/examples/'.$tour_work_path_name.'/'.C('KP_PANOS_PATH_NAME').'/'.$scene_path_name.'/thumb.jpg');
			//复制空的index.html
			copy('./Public/'.C('KP_VIEWER_PATH_NAME').'/examples/'.C('KP_TEMPLATE_NAME').'/index_empty.html','./Public/'.C('KP_VIEWER_PATH_NAME').'/examples/'.$tour_work_path_name.'/'.C('KP_PANOS_PATH_NAME').'/'.$scene_path_name.'/index.html');
			//构建场景cube
			foreach ($scene['attachment'] as $key => $attachment) {
				switch ($key) {
					case 0:
					copy($attachment['path'],'./Public/'.C('KP_VIEWER_PATH_NAME').'/examples/'.$tour_work_path_name.'/'.C('KP_PANOS_PATH_NAME').'/'.$scene_path_name.'/'.C('KP_MOBILE_NAME').'_r.jpg');
					break;
					case 1:
					copy($attachment['path'],'./Public/'.C('KP_VIEWER_PATH_NAME').'/examples/'.$tour_work_path_name.'/'.C('KP_PANOS_PATH_NAME').'/'.$scene_path_name.'/'.C('KP_MOBILE_NAME').'_l.jpg');
					break;
					case 2:
					copy($attachment['path'],'./Public/'.C('KP_VIEWER_PATH_NAME').'/examples/'.$tour_work_path_name.'/'.C('KP_PANOS_PATH_NAME').'/'.$scene_path_name.'/'.C('KP_MOBILE_NAME').'_b.jpg');
					break;
					case 3:
					copy($attachment['path'],'./Public/'.C('KP_VIEWER_PATH_NAME').'/examples/'.$tour_work_path_name.'/'.C('KP_PANOS_PATH_NAME').'/'.$scene_path_name.'/'.C('KP_MOBILE_NAME').'_f.jpg');
					break;
					case 4:
					copy($attachment['path'],'./Public/'.C('KP_VIEWER_PATH_NAME').'/examples/'.$tour_work_path_name.'/'.C('KP_PANOS_PATH_NAME').'/'.$scene_path_name.'/'.C('KP_MOBILE_NAME').'_d.jpg');
					break;
					case 5:
					copy($attachment['path'],'./Public/'.C('KP_VIEWER_PATH_NAME').'/examples/'.$tour_work_path_name.'/'.C('KP_PANOS_PATH_NAME').'/'.$scene_path_name.'/'.C('KP_MOBILE_NAME').'_u.jpg');
					break;
					default:
					break;
				}	
			}
		}


$str=<<<str
<krpano>
	<include url="navbar/navbar.xml" />
	<include url="contextmenu.xml" />


	<action name="startup" autorun="onstart">
		if(startscene === null, set(startscene,get(scene[0].name)) );
		loadscene(get(startscene),null,MERGE);
		addthumbs();
	</action>

	<!-- hotspot styles -->
	<style name="arrowspot1" url="skin/pfeil1.png" distorted="true" />
	<style name="arrowspot2" url="skin/pfeil2.png" distorted="true" />
	<style name="arrowspot3" url="skin/pfeil3.png" distorted="true" />
	<style name="arrowspot4" url="skin/pfeil4.png" distorted="true" />
	<style name="arrowspot5" url="skin/pfeil5.png" distorted="true" />
	<style name="zoomspot"   url="skin/zoomicon.png" distorted="true" />



	<!-- thumbs -->
	<layer name="thumbs" keep="true" type="container" align="leftbottom" width="100" height="100%" x="-102" y="0" state="closed">
		<layer name="thumbsicon" url="skin/thumbs.png" align="rightbottom" x="-10" y="5" edge="leftbottom" scale.mobile="0.75" onclick="if(layer[thumbs].state == 'closed', tween(layer[thumbs].x,0,0.5,easeOutQuint), tween(layer[thumbs].x,-102,0.5,easeOutQuint)); switch(layer[thumbs].state,'closed','opened');" />
		<layer name="thumbbar" keep="true" type="container" align="leftbottom" width="100" height="100%" x="0" y="0" bgcolor="0xFFFFFF" bgalpha="0.7">
			<layer name="scrollarea" url.flash="%SWFPATH%/plugins/scrollarea.swf" url.html5="%SWFPATH%/plugins/scrollarea.js" align="center" width="100" height="100%" direction="v" onloaded="setcenter(0,0);" />
		</layer>
	</layer>

	<action name="addthumbs">
		calc(layer[scrollarea].height, scene.count*90 + 10);
		for(set(i,0), i LT scene.count, inc(i),
			calc(thumbname,'thumb_' + i);
			addlayer(get(thumbname));
			copy(layer[get(thumbname)].url, scene[get(i)].thumburl);
			set(layer[get(thumbname)].keep, true);
			set(layer[get(thumbname)].parent, 'scrollarea');
			set(layer[get(thumbname)].align, lefttop);
			set(layer[get(thumbname)].x, 10);
			calc(layer[get(thumbname)].y, i*90 + 10);
			set(layer[get(thumbname)].linkedscene, get(scene[get(i)].name) );
			set(layer[get(thumbname)].onclick, tween(layer[thumbs].x,-102,0.2,easeOutQuint,wait); set(layer[thumbs].state,'closed');  loadscene(get(linkedscene), null, MERGE, BLEND(0.5)); );
		  );
	</action>

	<!-- logo -->
	<plugin name="logo"
	        url="skin/kuchlerhaus-logo.png"
	        keep="true"
	        enabled="false"
	        align="rightbottom"
	        x="10" y="5"
	        scale.mobile="0.5"
	        />

	<!-- loading information -->
	<plugin name="loading"
	        url="skin/loading.png"
	        scale="0.5"
	        keep="true"
	        align="center"
	        enabled="false"
	        visible="false"
	        />

	<events onxmlcomplete="set(plugin[loading].visible,true);"
	        onloadcomplete="set(plugin[loading].visible,false);;"
	        />


	<!-- transition action
		%1 = name of the hotspot to move
		%2 = destination ath for the hotspot
		%3 = destination atv for the hotspot
		%4 = destination rotate for the hotspot
		%5 = new scene
		%6 = hlookat startup position in the new scene
		%7 = vlookat startup position in the new scene
		%8 = startup fov in the new scene
	-->
	<action name="transition">
		<!-- move the hotspot to the destination position -->
		tween(hotspot[%1].alpha, 0.0, 0.25, default);
		tween(hotspot[%1].rotate, %4, 0.25, default);
		tween(hotspot[%1].ath,    %2, 0.25, default);
		tween(hotspot[%1].atv,    %3, 0.25, default, WAIT);

		<!-- look at the hotspot position -->
		looktohotspot(%1);

		set(plugin[loading].visible,true);

		<!-- load and blend to the new scene -->
		loadscene(%5, null, MERGE, BLEND(2));

		<!-- save the startup view position of the scene-->
		copy(startview_hlookat, view.hlookat);
		copy(startview_vlookat, view.vlookat);
		copy(startview_fov, view.fov);

		<!-- look at the given position and wait for blending -->
		lookat(%6, %7, %8);
		wait(LOAD);

		set(plugin[loading].visible,false);

		wait(BLEND);

		<!-- return to startup position -->
		oninterrupt(break);
		lookto(get(startview_hlookat), get(startview_vlookat), get(startview_fov), smooth(60,-60,180));

	</action>


	<!-- calc the max. flyout size of a hotspot for the current screen size -->
	<action name="calc_flyout_size">
		div(screen_sideaspect, stagewidth, stageheight);
		div(hotspot_sideaspect, hotspot[%1].width, hotspot[%1].height);

		if(screen_sideaspect LT hotspot_sideaspect,
			div(hotspot[%1].width,stagewidth,stageheight);
			mul(hotspot[%1].width,80);
			txtadd(hotspot[%1].width,'%');
			set(hotspot[%1].height,prop);
		  ,
			set(hotspot[%1].width,prop);
			set(hotspot[%1].height,80%);
		  );
	</action>

	<!-- fly in a hotspot = show hotspot fixed at screen -->
	<action name="flyin">
		if(hotspot[%1].flying == 0.0, hotspot[%1].resetsize(); calc_flyout_size(%1); );
		if(hotspot[%1].oldscale === null, copy(hotspot[%1].oldscale, hotspot[%1].scale) );
		if(hotspot[%1].oldrx === null, copy(hotspot[%1].oldrx, hotspot[%1].rx) );
		if(hotspot[%1].oldry === null, copy(hotspot[%1].oldry, hotspot[%1].ry) );
		if(hotspot[%1].oldrz === null, copy(hotspot[%1].oldrz, hotspot[%1].rz) );
		set(hotspot[%1].enabled,true);
		set(hotspot[%1].visible,true);
		tween(hotspot[%1].alpha,  1.0);
		tween(hotspot[%1].flying, 1.0);
		tween(hotspot[%1].scale,  1.0);
		tween(hotspot[%1].rx, 0.0);
		tween(hotspot[%1].ry, 0.0);
		tween(hotspot[%1].rz, 0.0);
	</action>

	<!-- fly the hotspot out/back -->
	<action name="flyout">
		set(hotspot[%1].enabled,false);
		tween(hotspot[%1].alpha,  0.0, 0.5, default, set(hotspot[%1].visible,false); );
		tween(hotspot[%1].flying, 0.0);
		tween(hotspot[%1].scale,  get(hotspot[%1].oldscale));
		tween(hotspot[%1].rx,  get(hotspot[%1].oldrx));
		tween(hotspot[%1].ry,  get(hotspot[%1].oldry));
		tween(hotspot[%1].rz,  get(hotspot[%1].oldrz));
	</action>



	<!-- scenes -->

str;

	foreach ($scenes as $k => $scene) {
		$scene_path_name=md10($scene['scene_id']);
		$hlookat=$scene['hlookat'];
		$vlookat=$scene['vlookat'];
		$fov=$scene['fov'];

$str.=<<<str

	<scene name="{$scene_path_name}" title="{$scene_path_name}" onstart="" thumburl="{$KP_PANOS_PATH_NAME}/{$scene_path_name}/thumb.jpg">

		<view hlookat="{$hlookat}" vlookat="{$vlookat}" fovtype="MFOV" fov="{$fov}" fovmin="45" fovmax="120" />

		<image>
			<cube url="{$KP_PANOS_PATH_NAME}/{$scene_path_name}/{$KP_MOBILE_NAME}_%s.jpg" />
		</image>

		<!--
		 the 'tooltip' style - show the tooltip textfield and update its position as long as hovering 
		-->
		<style name="tooltip" onover="copy(layer[tooltip].html, tooltip); set(layer[tooltip].visible, true); tween(layer[tooltip].alpha, 1.0, 0.5); asyncloop(hovering, copy(layer[tooltip].x,mouse.stagex); copy(layer[tooltip].y,mouse.stagey); );" onout="tween(layer[tooltip].alpha, 0.0, 0.25, default, set(layer[tooltip].visible,false), copy(layer[tooltip].x,mouse.stagex); copy(layer[tooltip].y,mouse.stagey); );"/>
		<!--  the 'tooltip' textfield  -->
		<layer name="tooltip" keep="true" url="%SWFPATH%/plugins/textfield.swf" parent="STAGE" visible="false" alpha="0" enabled="false" align="lefttop" edge="bottom" oy="-2" background="false" backgroundcolor="0xFFFFFF" backgroundalpha="1.0" border="false" bordercolor="0x000000" borderalpha="1.0" borderwidth="1.0" roundedge="0" shadow="0.0" shadowrange="4.0" shadowangle="45" shadowcolor="0x000000" shadowalpha="1.0" textshadow="1" textshadowrange="6.0" textshadowangle="90" textshadowcolor="0x000000" textshadowalpha="1.0" css="text-align:center; color:#FFFFFF; font-family:Arial; font-weight:bold; font-size:14px;" html=""/>		

str;

	foreach ($scene['hotspot'] as $key => $hotspot) {
		$hotspot_id=$hotspot['hotspot_id'];
		$hotspot_name=$hotspot['hotspot_name'];
		$type=$hotspot['type'];
		$ath=$hotspot['ath'];
		$atv=$hotspot['atv'];
		$goto_scene_title=$hotspot['goto_scene_title'];
		$goto_scene_hlookat=$hotspot['goto_scene_hlookat'];
		$goto_scene_vlookat=$hotspot['goto_scene_vlookat'];
		$goto_scene_fov=$hotspot['goto_scene_fov'];
		$target=$hotspot['target'];

		$md10_hotspot_id=md10($hotspot_id);

		$where = array('title' => $goto_scene_title, 'tour_id' => $id,);
		$goto_scene_data=D('Scene')->relation('attachment')->where($where)->find();
		$goto_scene_id=$goto_scene_data['scene_id'];//goto_scene_id
		$goto_scene_name=md10($goto_scene_id);

		$des_ath=$ath+C('KP_HOTSPOT_DATH');
		$des_atv=$atv+C('KP_HOTSPOT_DATV');
		switch ($type) {
			case 1:
$str.=<<<str
<hotspot name="{$md10_hotspot_id}" tooltip="{$hotspot_name}" style="arrowspot1|tooltip" ath="{$ath}" atv="{$atv}" scale="0.45" onclick="transition({$md10_hotspot_id}, {$des_ath}, {$des_atv}, 0, {$goto_scene_name}, {$goto_scene_hlookat}, {$goto_scene_vlookat}, {$goto_scene_fov});" />
str;
			break;
			case 2:
$str.=<<<str

str;
			break;
			case 3:
$str.=<<<str

str;
			break;
			
			default:
			break;
		}

	}

$str.=<<<str

	</scene>

str;

	}

$str.=<<<str

</krpano>

str;
		file_put_contents('./Public/'.C('KP_VIEWER_PATH_NAME').'/examples/'.$tour_work_path_name.'/tour.xml',$str);
	}




	public function set_ath_and_atv(){
		if (isset($_GET['atv'])) {
			$hotspot_id=I('id');
			$atv=I('atv');
			$ath=I('ath');
			//写入数据库
			R('Hotspot/save_configs');
			die;
		}
		$hotspot_id=I('id');//hotspot_id
		$hotspot_data=D('Hotspot')->find($hotspot_id);
		$scene_id=$hotspot_data['scene_id'];//scene_id
		$scene_data=D('Scene')->relation('attachment')->find($scene_id);
		$tour_id=$scene_data['tour_id'];//tour_id
		$get_url='/index.php?m=Admin&amp;c=kp&amp;a=set_ath_and_atv';
		$ath=$hotspot_data['ath'];
		$atv=$hotspot_data['atv'];

		$KP_PANOS_PATH_NAME=C('KP_PANOS_PATH_NAME');
		$KP_MOBILE_NAME=C('KP_MOBILE_NAME');
		$tour_work_path_name=md10($tour_id).'temp';

		//检查是否有工作目录,有则删除,没有则创建
		if (is_dir('./Public/'.C('KP_VIEWER_PATH_NAME').'/examples/'.$tour_work_path_name)){
			delDirAndFile('./Public/'.C('KP_VIEWER_PATH_NAME').'/examples/'.$tour_work_path_name);
		}
		recurse_copy('./Public/'.C('KP_VIEWER_PATH_NAME').'/examples/'.C('KP_TEMPLATE_NAME'),'./Public/'.C('KP_VIEWER_PATH_NAME').'/examples/'.$tour_work_path_name);
			//修改index入口文件
		$str=<<<str
<!DOCTYPE html>
<html>
<head>
<!-- redirect to the root krpano.html to avoid local browser restrictions -->
<meta http-equiv="refresh" content="0; url=../../krpano.html?xml=examples/{$tour_work_path_name}/tour.xml" />
<style>body{background-color:#000000;}</style>
</head>
</html>
str;
		file_put_contents('./Public/'.C('KP_VIEWER_PATH_NAME').'/examples/'.$tour_work_path_name.'/index.html',$str);

			//场景文件组织
			$scene_path_name=md10($scene_id);
			//创建场景目录
			mkdir('./Public/'.C('KP_VIEWER_PATH_NAME').'/examples/'.$tour_work_path_name.'/'.C('KP_PANOS_PATH_NAME').'/'.$scene_path_name);
			//构建场景thumb
			copy($scene['pic'],'./Public/'.C('KP_VIEWER_PATH_NAME').'/examples/'.$tour_work_path_name.'/'.C('KP_PANOS_PATH_NAME').'/'.$scene_path_name.'/thumb.jpg');
			//复制空的index.html
			copy('./Public/'.C('KP_VIEWER_PATH_NAME').'/examples/'.C('KP_TEMPLATE_NAME').'/index_empty.html','./Public/'.C('KP_VIEWER_PATH_NAME').'/examples/'.$tour_work_path_name.'/'.C('KP_PANOS_PATH_NAME').'/'.$scene_path_name.'/index.html');
			//构建场景cube
			foreach ($scene_data['attachment'] as $key => $attachment) {
				switch ($key) {
					case 0:
					copy($attachment['path'],'./Public/'.C('KP_VIEWER_PATH_NAME').'/examples/'.$tour_work_path_name.'/'.C('KP_PANOS_PATH_NAME').'/'.$scene_path_name.'/'.C('KP_MOBILE_NAME').'_r.jpg');
					break;
					case 1:
					copy($attachment['path'],'./Public/'.C('KP_VIEWER_PATH_NAME').'/examples/'.$tour_work_path_name.'/'.C('KP_PANOS_PATH_NAME').'/'.$scene_path_name.'/'.C('KP_MOBILE_NAME').'_l.jpg');
					break;
					case 2:
					copy($attachment['path'],'./Public/'.C('KP_VIEWER_PATH_NAME').'/examples/'.$tour_work_path_name.'/'.C('KP_PANOS_PATH_NAME').'/'.$scene_path_name.'/'.C('KP_MOBILE_NAME').'_b.jpg');
					break;
					case 3:
					copy($attachment['path'],'./Public/'.C('KP_VIEWER_PATH_NAME').'/examples/'.$tour_work_path_name.'/'.C('KP_PANOS_PATH_NAME').'/'.$scene_path_name.'/'.C('KP_MOBILE_NAME').'_f.jpg');
					break;
					case 4:
					copy($attachment['path'],'./Public/'.C('KP_VIEWER_PATH_NAME').'/examples/'.$tour_work_path_name.'/'.C('KP_PANOS_PATH_NAME').'/'.$scene_path_name.'/'.C('KP_MOBILE_NAME').'_d.jpg');
					break;
					case 5:
					copy($attachment['path'],'./Public/'.C('KP_VIEWER_PATH_NAME').'/examples/'.$tour_work_path_name.'/'.C('KP_PANOS_PATH_NAME').'/'.$scene_path_name.'/'.C('KP_MOBILE_NAME').'_u.jpg');
					break;
					default:
					break;
				}	
			}


$str=<<<str
<krpano>

	<include url="contextmenu.xml" />

	<view hlookat="0" vlookat="0" fovtype="MFOV" fov="100" fovmin="60" fovmax="150" />

	<!-- hotspot styles -->
	<style name="arrowspot1" url="skin/pfeil1.png" distorted="true" />
	<style name="arrowspot2" url="skin/pfeil2.png" distorted="true" />
	<style name="arrowspot3" url="skin/pfeil3.png" distorted="true" />
	<style name="arrowspot4" url="skin/pfeil4.png" distorted="true" />
	<style name="arrowspot5" url="skin/pfeil5.png" distorted="true" />
	<style name="zoomspot"   url="skin/zoomicon.png" distorted="true" />

	<!-- textfield with information about the currently dragged hotspot -->
	<plugin name="hotspot_pos_info"
	        url="%SWFPATH%/plugins/textfield.swf"
	        html="drag the hotspots..."
	        css="font-family:Courier;color:white;background:black;"
	        padding="0"
	        align="lefttop" x="10" y="10"
	        width="200"
	        enabled="false"
	        />

	<!-- logo -->
	<plugin name="logo"
	        url="skin/kuchlerhaus-logo.png"
	        keep="true"
	        enabled="false"
	        align="rightbottom"
	        x="10" y="5"
	        scale.mobile="0.5"
	        />

	<!-- 跳转 -->
	<action name="get_url">
		def(uuu, string, '');
		txtadd(uuu,'{$get_url}&amp;id={$hotspot_id}','&amp;ath=',get(hotspot[0].ath),'&amp;atv=',get(hotspot[0].atv));
		openurl(get(uuu));
	</action>
	
	<!-- the action for dragging the hotspot - call it once in the ondown event -->
	<action name="draghotspot">
		spheretoscreen(ath, atv, hotspotcenterx, hotspotcentery, 'l');
		sub(drag_adjustx, mouse.stagex, hotspotcenterx);
		sub(drag_adjusty, mouse.stagey, hotspotcentery);
		asyncloop(pressed,
			sub(dx, mouse.stagex, drag_adjustx);
			sub(dy, mouse.stagey, drag_adjusty);
			screentosphere(dx, dy, ath, atv);
			print_hotspot_pos();
		  );
	</action>

	<action name="print_hotspot_pos"><![CDATA[
		copy(print_ath, ath);
		copy(print_atv, atv);
		roundval(print_ath, 3);
		roundval(print_atv, 3);
		calc(plugin[hotspot_pos_info].html, '&lt;hotspot name="' + name + '"[br]&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;...[br]&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ath="' + print_ath + '"[br]&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;atv="' + print_atv + '"[br]&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;...[br]&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/&gt;');
	]]></action>

		<image>
			<cube url="{$KP_PANOS_PATH_NAME}/{$scene_path_name}/{$KP_MOBILE_NAME}_%s.jpg" />
		</image>

		<hotspot name="选择热点位置"   style="arrowspot1" ath="{$ath}"     atv="{$atv}"  scale="0.40" ondown="draghotspot();"/>

		<hotspot name="确定" 
			 url="skin/kuchlerhaus-logo.png"
			 ath="0"
	         atv="90"
	         distorted="true"
	         scale="1.0"
	         rotate="0.0"
	         onclick="get_url();"
	    />
</krpano>

str;
		file_put_contents('./Public/'.C('KP_VIEWER_PATH_NAME').'/examples/'.$tour_work_path_name.'/tour.xml',$str);
		echo '<script>window.location.href=\'./Public/'.C('KP_VIEWER_PATH_NAME').'/examples/'.$tour_work_path_name.'/index.html\';</script>';
	}




	public function set_goto_scene(){
		if (isset($_GET['goto_scene_hlookat'])) {
			//写入数据库
			R('Hotspot/save_configs');
			die;
		}

		$hotspot_id=I('id');//hotspot_id
		$hotspot_data=D('Hotspot')->find($hotspot_id);
		$scene_id=$hotspot_data['scene_id'];//scene_id
		$scene_data=D('Scene')->relation('attachment')->find($scene_id);
		$tour_id=$scene_data['tour_id'];//tour_id

		$goto_scene_title=$hotspot_data['goto_scene_title'];//goto_scene_title
		$where = array('title' => $goto_scene_title, 'tour_id' => $tour_id,);
		$goto_scene_data=D('Scene')->relation('attachment')->where($where)->find();
		$goto_scene_id=$goto_scene_data['scene_id'];//goto_scene_id

		$get_url='/index.php?m=Admin&amp;c=kp&amp;a=set_goto_scene';
		$goto_scene_hlookat=$hotspot_data['goto_scene_hlookat'];
		$goto_scene_vlookat=$hotspot_data['goto_scene_vlookat'];
		$goto_scene_fov=$hotspot_data['goto_scene_fov'];

		$KP_PANOS_PATH_NAME=C('KP_PANOS_PATH_NAME');
		$KP_MOBILE_NAME=C('KP_MOBILE_NAME');
		$tour_work_path_name=md10($tour_id).'temp';

		//检查是否有工作目录,有则删除,没有则创建
		if (is_dir('./Public/'.C('KP_VIEWER_PATH_NAME').'/examples/'.$tour_work_path_name)){
			delDirAndFile('./Public/'.C('KP_VIEWER_PATH_NAME').'/examples/'.$tour_work_path_name);
		}
		recurse_copy('./Public/'.C('KP_VIEWER_PATH_NAME').'/examples/'.C('KP_TEMPLATE_NAME'),'./Public/'.C('KP_VIEWER_PATH_NAME').'/examples/'.$tour_work_path_name);
			//修改index入口文件
		$str=<<<str
<!DOCTYPE html>
<html>
<head>
<!-- redirect to the root krpano.html to avoid local browser restrictions -->
<meta http-equiv="refresh" content="0; url=../../krpano.html?xml=examples/{$tour_work_path_name}/tour.xml" />
<style>body{background-color:#000000;}</style>
</head>
</html>
str;
		file_put_contents('./Public/'.C('KP_VIEWER_PATH_NAME').'/examples/'.$tour_work_path_name.'/index.html',$str);

			//场景文件组织
			$scene_path_name=md10($goto_scene_id);
			//创建场景目录
			mkdir('./Public/'.C('KP_VIEWER_PATH_NAME').'/examples/'.$tour_work_path_name.'/'.C('KP_PANOS_PATH_NAME').'/'.$scene_path_name);
			//构建场景thumb
			copy($scene['pic'],'./Public/'.C('KP_VIEWER_PATH_NAME').'/examples/'.$tour_work_path_name.'/'.C('KP_PANOS_PATH_NAME').'/'.$scene_path_name.'/thumb.jpg');
			//复制空的index.html
			copy('./Public/'.C('KP_VIEWER_PATH_NAME').'/examples/'.C('KP_TEMPLATE_NAME').'/index_empty.html','./Public/'.C('KP_VIEWER_PATH_NAME').'/examples/'.$tour_work_path_name.'/'.C('KP_PANOS_PATH_NAME').'/'.$scene_path_name.'/index.html');
			//构建场景cube
			foreach ($goto_scene_data['attachment'] as $key => $attachment) {
				switch ($key) {
					case 0:
					copy($attachment['path'],'./Public/'.C('KP_VIEWER_PATH_NAME').'/examples/'.$tour_work_path_name.'/'.C('KP_PANOS_PATH_NAME').'/'.$scene_path_name.'/'.C('KP_MOBILE_NAME').'_r.jpg');
					break;
					case 1:
					copy($attachment['path'],'./Public/'.C('KP_VIEWER_PATH_NAME').'/examples/'.$tour_work_path_name.'/'.C('KP_PANOS_PATH_NAME').'/'.$scene_path_name.'/'.C('KP_MOBILE_NAME').'_l.jpg');
					break;
					case 2:
					copy($attachment['path'],'./Public/'.C('KP_VIEWER_PATH_NAME').'/examples/'.$tour_work_path_name.'/'.C('KP_PANOS_PATH_NAME').'/'.$scene_path_name.'/'.C('KP_MOBILE_NAME').'_b.jpg');
					break;
					case 3:
					copy($attachment['path'],'./Public/'.C('KP_VIEWER_PATH_NAME').'/examples/'.$tour_work_path_name.'/'.C('KP_PANOS_PATH_NAME').'/'.$scene_path_name.'/'.C('KP_MOBILE_NAME').'_f.jpg');
					break;
					case 4:
					copy($attachment['path'],'./Public/'.C('KP_VIEWER_PATH_NAME').'/examples/'.$tour_work_path_name.'/'.C('KP_PANOS_PATH_NAME').'/'.$scene_path_name.'/'.C('KP_MOBILE_NAME').'_d.jpg');
					break;
					case 5:
					copy($attachment['path'],'./Public/'.C('KP_VIEWER_PATH_NAME').'/examples/'.$tour_work_path_name.'/'.C('KP_PANOS_PATH_NAME').'/'.$scene_path_name.'/'.C('KP_MOBILE_NAME').'_u.jpg');
					break;
					default:
					break;
				}	
			}


$str=<<<str

<krpano>

	<include url="contextmenu.xml" />

	<view hlookat="{$goto_scene_hlookat}" vlookat="{$goto_scene_vlookat}" fovtype="MFOV" fov="{$goto_scene_fov}" fovmin="60" fovmax="150" />

	<!-- hotspot styles -->
	<style name="arrowspot1" url="skin/pfeil1.png" distorted="true" />
	<style name="arrowspot2" url="skin/pfeil2.png" distorted="true" />
	<style name="arrowspot3" url="skin/pfeil3.png" distorted="true" />
	<style name="arrowspot4" url="skin/pfeil4.png" distorted="true" />
	<style name="arrowspot5" url="skin/pfeil5.png" distorted="true" />
	<style name="zoomspot"   url="skin/zoomicon.png" distorted="true" />

	<!-- textfield with information about the currently dragged hotspot -->
	<plugin name="hotspot_pos_info"
	        url="%SWFPATH%/plugins/textfield.swf"
	        html="drag the hotspots..."
	        css="font-family:Courier;color:white;background:black;"
	        padding="0"
	        align="lefttop" x="10" y="10"
	        width="200"
	        enabled="false"
	        />

	<!-- logo -->
	<plugin name="logo"
	        url="skin/kuchlerhaus-logo.png"
	        keep="true"
	        enabled="false"
	        align="rightbottom"
	        x="10" y="5"
	        scale.mobile="0.5"
	        />

	<!-- 跳转 -->
	<action name="get_url">
		def(uuu, string, '');
		txtadd(uuu,'{$get_url}&amp;id={$hotspot_id}','&amp;goto_scene_hlookat=',get(view[0].hlookat),'&amp;goto_scene_vlookat=',get(view[0].vlookat),'&amp;goto_scene_fov=',get(view[0].fov));
		openurl(get(uuu));
	</action>
	
	<!-- the action for dragging the hotspot - call it once in the ondown event -->

	<action name="print_view_sets"><![CDATA[
		copy(print_hlookat, view[0].hlookat);
		copy(print_vlookat, view[0].vlookat);
		copy(print_fov, view[0].fov);
		roundval(print_hlookat, 3);
		roundval(print_vlookat, 3);
		roundval(print_fov, 3);
		calc(plugin[hotspot_pos_info].html, '&lt;view name=镜头[br]&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;...[br]&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;hlookat="' + print_hlookat + '"[br]&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;vlookat="' + print_vlookat + '"[br]&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;fov="' + print_fov + '"[br]&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;...[br]&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/&gt;');
	]]></action>

		<image>
			<cube url="{$KP_PANOS_PATH_NAME}/{$scene_path_name}/{$KP_MOBILE_NAME}_%s.jpg" />
		</image>

		<events onviewchange="print_view_sets()"/>

		<hotspot name="确定" 
			 url="skin/kuchlerhaus-logo.png"
			 ath="0"
	         atv="90"
	         distorted="true"
	         scale="1.0"
	         rotate="0.0"
	         onclick="get_url();"
	    />
</krpano>

str;
		file_put_contents('./Public/'.C('KP_VIEWER_PATH_NAME').'/examples/'.$tour_work_path_name.'/tour.xml',$str);
		echo '<script>window.location.href=\'./Public/'.C('KP_VIEWER_PATH_NAME').'/examples/'.$tour_work_path_name.'/index.html\';</script>';
	}


	public function set_scene(){

		if (isset($_GET['hlookat'])) {
			//写入数据库
			R('Scene/save_configs');
			die;
		}

		$scene_id=I('id');//scene_id
		$scene_data=D('Scene')->relation('attachment')->find($scene_id);
		$tour_id=$scene_data['tour_id'];//tour_id

		$get_url='/index.php?m=Admin&amp;c=kp&amp;a=set_scene';
		$hlookat=$scene_data['hlookat'];
		$vlookat=$scene_data['vlookat'];
		$fov=$scene_data['fov'];

		$KP_PANOS_PATH_NAME=C('KP_PANOS_PATH_NAME');
		$KP_MOBILE_NAME=C('KP_MOBILE_NAME');
		$tour_work_path_name=md10($tour_id).'temp';

		//检查是否有工作目录,有则删除,没有则创建
		if (is_dir('./Public/'.C('KP_VIEWER_PATH_NAME').'/examples/'.$tour_work_path_name)){
			delDirAndFile('./Public/'.C('KP_VIEWER_PATH_NAME').'/examples/'.$tour_work_path_name);
		}
		recurse_copy('./Public/'.C('KP_VIEWER_PATH_NAME').'/examples/'.C('KP_TEMPLATE_NAME'),'./Public/'.C('KP_VIEWER_PATH_NAME').'/examples/'.$tour_work_path_name);
			//修改index入口文件
		$str=<<<str
<!DOCTYPE html>
<html>
<head>
<!-- redirect to the root krpano.html to avoid local browser restrictions -->
<meta http-equiv="refresh" content="0; url=../../krpano.html?xml=examples/{$tour_work_path_name}/tour.xml" />
<style>body{background-color:#000000;}</style>
</head>
</html>
str;
		file_put_contents('./Public/'.C('KP_VIEWER_PATH_NAME').'/examples/'.$tour_work_path_name.'/index.html',$str);

			//场景文件组织
			$scene_path_name=md10($scene_id);
			//创建场景目录
			mkdir('./Public/'.C('KP_VIEWER_PATH_NAME').'/examples/'.$tour_work_path_name.'/'.C('KP_PANOS_PATH_NAME').'/'.$scene_path_name);
			//构建场景thumb
			copy($scene['pic'],'./Public/'.C('KP_VIEWER_PATH_NAME').'/examples/'.$tour_work_path_name.'/'.C('KP_PANOS_PATH_NAME').'/'.$scene_path_name.'/thumb.jpg');
			//复制空的index.html
			copy('./Public/'.C('KP_VIEWER_PATH_NAME').'/examples/'.C('KP_TEMPLATE_NAME').'/index_empty.html','./Public/'.C('KP_VIEWER_PATH_NAME').'/examples/'.$tour_work_path_name.'/'.C('KP_PANOS_PATH_NAME').'/'.$scene_path_name.'/index.html');
			//构建场景cube
			foreach ($scene_data['attachment'] as $key => $attachment) {
				switch ($key) {
					case 0:
					copy($attachment['path'],'./Public/'.C('KP_VIEWER_PATH_NAME').'/examples/'.$tour_work_path_name.'/'.C('KP_PANOS_PATH_NAME').'/'.$scene_path_name.'/'.C('KP_MOBILE_NAME').'_r.jpg');
					break;
					case 1:
					copy($attachment['path'],'./Public/'.C('KP_VIEWER_PATH_NAME').'/examples/'.$tour_work_path_name.'/'.C('KP_PANOS_PATH_NAME').'/'.$scene_path_name.'/'.C('KP_MOBILE_NAME').'_l.jpg');
					break;
					case 2:
					copy($attachment['path'],'./Public/'.C('KP_VIEWER_PATH_NAME').'/examples/'.$tour_work_path_name.'/'.C('KP_PANOS_PATH_NAME').'/'.$scene_path_name.'/'.C('KP_MOBILE_NAME').'_b.jpg');
					break;
					case 3:
					copy($attachment['path'],'./Public/'.C('KP_VIEWER_PATH_NAME').'/examples/'.$tour_work_path_name.'/'.C('KP_PANOS_PATH_NAME').'/'.$scene_path_name.'/'.C('KP_MOBILE_NAME').'_f.jpg');
					break;
					case 4:
					copy($attachment['path'],'./Public/'.C('KP_VIEWER_PATH_NAME').'/examples/'.$tour_work_path_name.'/'.C('KP_PANOS_PATH_NAME').'/'.$scene_path_name.'/'.C('KP_MOBILE_NAME').'_d.jpg');
					break;
					case 5:
					copy($attachment['path'],'./Public/'.C('KP_VIEWER_PATH_NAME').'/examples/'.$tour_work_path_name.'/'.C('KP_PANOS_PATH_NAME').'/'.$scene_path_name.'/'.C('KP_MOBILE_NAME').'_u.jpg');
					break;
					default:
					break;
				}	
			}


$str=<<<str

<krpano>

	<include url="contextmenu.xml" />

	<view hlookat="{$hlookat}" vlookat="{$vlookat}" fovtype="MFOV" fov="{$fov}" fovmin="60" fovmax="150" />

	<!-- hotspot styles -->
	<style name="arrowspot1" url="skin/pfeil1.png" distorted="true" />
	<style name="arrowspot2" url="skin/pfeil2.png" distorted="true" />
	<style name="arrowspot3" url="skin/pfeil3.png" distorted="true" />
	<style name="arrowspot4" url="skin/pfeil4.png" distorted="true" />
	<style name="arrowspot5" url="skin/pfeil5.png" distorted="true" />
	<style name="zoomspot"   url="skin/zoomicon.png" distorted="true" />

	<!-- textfield with information about the currently dragged hotspot -->
	<plugin name="hotspot_pos_info"
	        url="%SWFPATH%/plugins/textfield.swf"
	        html="drag the hotspots..."
	        css="font-family:Courier;color:white;background:black;"
	        padding="0"
	        align="lefttop" x="10" y="10"
	        width="200"
	        enabled="false"
	        />

	<!-- logo -->
	<plugin name="logo"
	        url="skin/kuchlerhaus-logo.png"
	        keep="true"
	        enabled="false"
	        align="rightbottom"
	        x="10" y="5"
	        scale.mobile="0.5"
	        />

	<!-- 跳转 -->
	<action name="get_url">
		def(uuu, string, '');
		txtadd(uuu,'{$get_url}&amp;id={$scene_id}','&amp;hlookat=',get(view[0].hlookat),'&amp;vlookat=',get(view[0].vlookat),'&amp;fov=',get(view[0].fov));
		openurl(get(uuu));
	</action>
	
	<!-- the action for dragging the hotspot - call it once in the ondown event -->

	<action name="print_view_sets"><![CDATA[
		copy(print_hlookat, view[0].hlookat);
		copy(print_vlookat, view[0].vlookat);
		copy(print_fov, view[0].fov);
		roundval(print_hlookat, 3);
		roundval(print_vlookat, 3);
		roundval(print_fov, 3);
		calc(plugin[hotspot_pos_info].html, '&lt;view name=镜头[br]&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;...[br]&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;hlookat="' + print_hlookat + '"[br]&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;vlookat="' + print_vlookat + '"[br]&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;fov="' + print_fov + '"[br]&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;...[br]&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/&gt;');
	]]></action>

		<image>
			<cube url="{$KP_PANOS_PATH_NAME}/{$scene_path_name}/{$KP_MOBILE_NAME}_%s.jpg" />
		</image>

		<events onviewchange="print_view_sets()"/>

		<hotspot name="确定" 
			 url="skin/kuchlerhaus-logo.png"
			 ath="0"
	         atv="90"
	         distorted="true"
	         scale="1.0"
	         rotate="0.0"
	         onclick="get_url();"
	    />
</krpano>

str;
		file_put_contents('./Public/'.C('KP_VIEWER_PATH_NAME').'/examples/'.$tour_work_path_name.'/tour.xml',$str);
		echo '<script>window.location.href=\'./Public/'.C('KP_VIEWER_PATH_NAME').'/examples/'.$tour_work_path_name.'/index.html\';</script>';
	}
	
}