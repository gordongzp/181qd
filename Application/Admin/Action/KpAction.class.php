<?php
namespace Admin\Action;
use Think\Action;
class KpAction extends CommonAction {
	
	public function __construct(){
		parent::__construct();
	}
	public function show(){
		$id=I('id');
		echo '<script>window.location.href=\'./Public/viewer/examples/'.$id.'/index.html\';</script>';
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
		$tour=D('Tour')->relation('scene')->where('tour_id='.$id)->find();
		if ($tour['scene']) {
			foreach ($tour['scene'] as $k => $v) {
				$scene_ids[]=$v['scene_id'];
			}
			$scenes=D('scene')->relation(true)->where(array('scene_id'=>array('in',$scene_ids)))->select();
		}
		
		dump($tour);
		dump($scenes);

		//检查是否有工作目录,有则删除,没有则创建
		if (is_dir('./Public/viewer/examples/'.$id)){
			delDirAndFile('./Public/viewer/examples/'.$id);
		}
		recurse_copy('./Public/viewer/examples/template','./Public/viewer/examples/'.$id);
			//修改index入口文件
		$str=<<<str
<!DOCTYPE html>
<html>
<head>
<!-- redirect to the root krpano.html to avoid local browser restrictions -->
<meta http-equiv="refresh" content="0; url=../../krpano.html?xml=examples/{$id}/tour.xml" />
<style>body{background-color:#000000;}</style>
</head>
</html>
str;
		file_put_contents('./Public/viewer/examples/'.$id.'/index.html',$str);

		//场景文件组织
		foreach ($scenes as $k => $scene) {
			//检查是否有场景目录，没有则创建
			mkdir('./Public/viewer/examples/'.$id.'/panos/'.$scene['scene_id']);
			//构建场景thumb
			copy($scene['pic'],'./Public/viewer/examples/'.$id.'/panos/'.$scene['scene_id'].'/thumb.jpg');
			//构建场景cube
			foreach ($scene['attachment'] as $key => $attachment) {
				switch ($key) {
					case 0:
					copy($attachment['path'],'./Public/viewer/examples/'.$id.'/panos/'.$scene['scene_id'].'/mobile_r.jpg');
					break;
					case 1:
					copy($attachment['path'],'./Public/viewer/examples/'.$id.'/panos/'.$scene['scene_id'].'/mobile_l.jpg');
					break;
					case 2:
					copy($attachment['path'],'./Public/viewer/examples/'.$id.'/panos/'.$scene['scene_id'].'/mobile_b.jpg');
					break;
					case 3:
					copy($attachment['path'],'./Public/viewer/examples/'.$id.'/panos/'.$scene['scene_id'].'/mobile_f.jpg');
					break;
					case 4:
					copy($attachment['path'],'./Public/viewer/examples/'.$id.'/panos/'.$scene['scene_id'].'/mobile_d.jpg');
					break;
					case 5:
					copy($attachment['path'],'./Public/viewer/examples/'.$id.'/panos/'.$scene['scene_id'].'/mobile_u.jpg');
					break;
					default:
					break;
				}	
			}
		}


$str=<<<str
<!--
	krpano Virtual Tour Demo - Kuchlerhaus
		http://krpano.com/tours/kuchlerhaus/

	The tour images were build fully automatic with the MAKE VTOUR Droplet,
	but the skin itself and the hotspots are fully custom xml code.

	Note - this is an reduced example (smaller images, stronger compression, fewer panos) to keep the download package small!
-->
<krpano>

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

$str.=<<<str

	<scene name="s{$scene['scene_id']}" title="s{$scene['scene_id']}" onstart="" thumburl="panos/{$scene['scene_id']}/thumb.jpg">

		<view hlookat="0" vlookat="0" fovtype="MFOV" fov="95" fovmin="45" fovmax="120" />

		<image>
			<cube url="panos/{$scene['scene_id']}/mobile_%s.jpg" />
		</image>

	</scene>

str;

	}

		$str.=<<<str

</krpano>

str;
		file_put_contents('./Public/viewer/examples/'.$id.'/tour.xml',$str);

	}
	
}