<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
<title>后台管理系统</title>
<link rel="stylesheet" type="text/css" href="/Public/Common/jquery-ui/jquery-ui.min.css" />
<link rel="stylesheet" type="text/css" href="/Public/Admin/css/index.css" />
<link rel="stylesheet" type="text/css" href="/Public/Admin/font/font-awesome.min.css" />
<link rel="stylesheet" type="text/css" href="/Public/Common/css/jquery.Jcrop.min.css" />
<script type="text/javascript">
var ADMIN_SITE_URL = '/index.php/admin';
var ADMIN_TEMPLATES_URL = '/Public/Admin';
//var ADMIN_RESOURCE_URL = 'http://b2b2c.shopnctest.com/tesa/shopnc/resource';
//var SITEURL = 'http://b2b2c.shopnctest.com/tesa/shopnc';
</script>
<script type="text/javascript" src="/Public/Common/js/jquery/jquery.js"></script>
<script type="text/javascript" src="/Public/Admin/js/common.js"></script>
<script src="/Public/Admin/dialog/dialog.js" id="dialog_js"></script>
<script type="text/javascript" src="/Public/Common/jquery-ui/jquery-ui.min.js"></script>
<script type="text/javascript" src="/Public/Common/js/jquery/jquery.cookie.js"></script>
<script type="text/javascript" src="/Public/Common/js/jquery/jquery.bgColorSelector.js"></script>
<script type="text/javascript" src="/Public/Admin/js/admincp.js"></script>
<script type="text/javascript" src="/Public/Common/js/ajaxfileupload.js"></script>
<script type="text/javascript" src="/Public/Common/js/jquery/jquery.Jcrop.js"></script>
</head>

<body>
	<div class="admincp-map ui-widget-content" nctype="map_nav" style="display:none;" id="draggable" >
	  <div class="title ui-widget-header" >
		<h3>管理中心全部菜单</h3>
		<h5>切换显示全部管理菜单，通过点击勾选可添加菜单为管理常用操作项，最多添加10个</h5>
		<span><a nctype="map_off" href="JavaScript:void(0);">X</a></span> </div>
		<div class="content"> 
			<ul class="admincp-map-nav">
				<li><a href="javascript:void(0);" data-param="map-system">平台</a></li>
				<li><a href="javascript:void(0);" data-param="map-shop">商城</a></li>
				<li><a href="javascript:void(0);" data-param="map-cms">资讯</a></li>
				<li><a href="javascript:void(0);" data-param="map-circle">圈子</a></li>
				<li><a href="javascript:void(0);" data-param="map-microshop">微商城</a></li>
				<li><a href="javascript:void(0);" data-param="map-mobile">手机端</a></li>
			</ul>
			<div class="admincp-map-div" data-param="map-system">
				<dl>
					<dt>设置</dt>
					<dd class="">
						<a href="javascript:void(0);" data-param="system|setting">站点设置</a>
						<i class="fa fa-check-square-o"></i>
					</dd>
					<dd class="">
						<a href="javascript:void(0);" data-param="system|upload">上传设置</a>
						<i class="fa fa-check-square-o"></i>
					</dd>
					<dd class="">
						<a href="javascript:void(0);" data-param="system|message">邮件设置</a>
						<i class="fa fa-check-square-o"></i>
					</dd>
					<dd class="">
						<a href="javascript:void(0);" data-param="admin|index">权限设置</a>
						<i class="fa fa-check-square-o"></i>
					</dd>
					<dd class="">
						<a href="javascript:void(0);" data-param="system|admin_log">操作日志</a>
						<i class="fa fa-check-square-o"></i>
					</dd>
					<dd class="">
						<a href="javascript:void(0);" data-param="system|area">地区设置</a>
						<i class="fa fa-check-square-o"></i>
					</dd>
					<dd class="selected">
						<a href="javascript:void(0);" data-param="system|cache">清理缓存</a>
						<i class="fa fa-check-square-o"></i>
					</dd>
				</dl>
			</div>
		</div>
	  <script>
		//固定层移动
		$(function(){
			//管理显示与隐藏
					$("#admin-manager-btn").click(function () {
						if ($(".manager-menu").css("display") == "none") {
							$(".manager-menu").css('display', 'block'); 
							$("#admin-manager-btn").attr("title","关闭快捷管理"); 
							$("#admin-manager-btn").removeClass().addClass("arrow-close");
						}
						else {
							$(".manager-menu").css('display', 'none');
							$("#admin-manager-btn").attr("title","显示快捷管理");
							$("#admin-manager-btn").removeClass().addClass("arrow");
						}           
					});
			
			$("#draggable").draggable({
				handle: "div.title"
			});
			$("div.title").disableSelection()

			$('#_pic').change(uploadChange);
			function uploadChange(){
				var filepath=$(this).val();
				var extStart=filepath.lastIndexOf(".");
				var ext=filepath.substring(extStart,filepath.length).toUpperCase();
				if(ext!=".PNG"&&ext!=".GIF"&&ext!=".JPG"&&ext!=".JPEG"){
					alert("file type error");
					$(this).attr('value','');
					return false;
				}
				if ($(this).val() == '') return false;
				ajaxFileUpload();
			}
			function ajaxFileUpload()
			{
				$.ajaxFileUpload
				(
					{
						url:'http://b2b2c.shopnctest.com/tesa/shopnc/index.php?act=common&op=pic_upload&type=admin_avatar&form_submit=ok&uploadpath=admin/avatar',
						secureuri:false,
						fileElementId:'_pic',
						dataType: 'json',
						success: function (data, status)
						{
							if (data.status == 1){
								ajax_form('cutpic','裁剪','http://b2b2c.shopnctest.com/tesa/shopnc/index.php?act=common&op=pic_cut&type=admin_avatar&x=100&y=100&resize=1&ratio=1&url='+data.url,690);
							}else{
								alert(data.msg);
							}
							$('#_pic').bind('change',uploadChange);
						},
						error: function (data, status, e)
						{
							alert('上传失败');
							$('#_pic').bind('change',uploadChange);
						}
					}
				)
			};
		});
		//裁剪图片后返回接收函数
		function call_back(picname){
			$.getJSON('index.php?act=index&op=save_avatar&avatar=' + picname, function(data){
				if (data) {
					$('img[nctype="admin_avatar"]').attr('src', 'http://b2b2c.shopnctest.com/tesa/data/upload/admin/avatar/' + picname);
				}
			});
		}
		</script> 
	</div>
	<div class="admincp-header">
		<div class="bgSelector"></div>
		<div id="foldSidebar"><i class="fa fa-outdent " title="展开/收起侧边导航"></i></div>
		<div class="admincp-name">
			<h1>一建体育官方商城平台</h1>
			<h2>后台系统管理中心</h2>
		</div>
		<div class="nc-module-menu">
			<ul class="nc-row">
			<?php if(is_array($auth_menu)): $i = 0; $__LIST__ = $auth_menu;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$r): $mod = ($i % 2 );++$i;?><li data-param="menu<?php echo ($r["menu_id"]); ?>"><a href="javascript:void(0);"><?php echo ($r["menu_name"]); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
			</ul>
		</div>
		<div class="admincp-header-r">
			<div class="manager">
				<dl>
					<dt class="name"><?php echo ($admin["admin_name"]); ?></dt>
					<dd class="group"><?php echo ($admin["role_name"]); ?></dd>
				</dl>
				<span class="avatar">
					<input name="_pic" type="file" class="admin-avatar-file" id="_pic" title="设置管理员头像"/>
					<img alt="" nctype="admin_avatar" src="/Public/Admin/images/admin_avatar.jpg"> 
				</span>
				<i class="arrow" id="admin-manager-btn" title="显示快捷管理菜单"></i>
				<div class="manager-menu">
					<div class="title">
						<h4>最后登录</h4>
						<a href="javascript:void(0);" onclick="CUR_DIALOG = ajax_form('modifypw', '修改密码', 'http://b2b2c.shopnctest.com/tesa/shopnc/index.php?act=index&op=modifypw');" class="edit-password">修改密码</a> 
					</div>
					<div class="login-date">
						2015-11-14 08:50:09          
						<span>(IP:119.142.26.132)</span> 
					</div>
					<div class="title">
						<h4>常用操作</h4>
						<a href="javascript:void(0)" class="add-menu">添加菜单</a> 
					</div>
					<ul class="nc-row" nctype="quick_link">
						<li><a href="javascript:void(0);" onclick="openItem('system|cache')">清理缓存</a></li>
					</ul>
				</div>
			</div>
			<ul class="operate nc-row">
				<li style="display: none !important;" nctype="pending_matters"><a class="toast show-option" href="javascript:void(0);" onclick="$.cookie('commonPendingMatters', 0, {expires : -1});ajax_form('pending_matters', '待处理事项', 'http://b2b2c.shopnctest.com/tesa/shopnc/index.php?act=common&op=pending_matters', '480');" title="查看待处理事项">&nbsp;<em>0</em></a></li>
				<li><a class="sitemap show-option" nctype="map_on" href="javascript:void(0);" title="查看全部管理菜单">&nbsp;</a></li>
				<li><a class="style-color show-option" id="trace_show" href="javascript:void(0);" title="给管理中心换个颜色">&nbsp;</a></li>
				<li><a class="homepage show-option" target="_blank" href="http://b2b2c.shopnctest.com/tesa/shop" title="新窗口打开商城首页">&nbsp;</a></li>
				<li><a class="login-out show-option" href="<?php echo U('index/logout');?>" title="安全退出管理中心">&nbsp;</a></li>
			</ul>
		</div>
		<div class="clear"></div>
	</div>
	
	
	<div class="admincp-container unfold">
		<div class="admincp-container-left">
			<div class="top-border"><span class="nav-side"></span><span class="sub-side"></span></div>
			<?php if(is_array($auth_menu)): $i = 0; $__LIST__ = $auth_menu;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$m1): $mod = ($i % 2 );++$i;?><div id="admincpNavTabs_menu<?php echo ($m1["menu_id"]); ?>" class="nav-tabs">
				<?php if(is_array($m1["sub"])): $i = 0; $__LIST__ = $m1["sub"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$m2): $mod = ($i % 2 );++$i;?><dl>
					<dt>
						<a href="javascript:void(0);">
							<span class="<?php echo ($m2["class_name"]); ?>"></span>
							<h3><?php echo ($m2["menu_name"]); ?></h3>
						</a>
					</dt>
					<dd class="sub-menu">
						<ul>
						<?php if(is_array($m2["sub"])): $i = 0; $__LIST__ = $m2["sub"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$m3): $mod = ($i % 2 );++$i;?><li><a href="javascript:void(0);" data-param="<?php echo ($m3["module_name"]); ?>|<?php echo ($m3["action_name"]); ?>|<?php echo ($m1["menu_id"]); ?>|<?php echo ($m3["menu_id"]); ?>"><?php echo ($m3["menu_name"]); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
						</ul>
					</dd>
				</dl><?php endforeach; endif; else: echo "" ;endif; ?>
			</div><?php endforeach; endif; else: echo "" ;endif; ?>
			<div class="about" title="关于一建体育" onclick="ajax_form('about', '', 'http://b2b2c.shopnctest.com/tesa/shopnc/index.php?act=aboutus&op=index', 640);">
				<i class="fa fa-copyright"></i>
				<span>YIJIANSPORTS</span>
			</div>
		</div>
		<div class="admincp-container-right">
			<div class="top-border"></div>
			<iframe src="" id="workspace" name="workspace" style="overflow: visible;" frameborder="0" width="100%" height="94%" scrolling="yes" onload="window.parent"></iframe>
		</div>
	</div>
</body>
</html>