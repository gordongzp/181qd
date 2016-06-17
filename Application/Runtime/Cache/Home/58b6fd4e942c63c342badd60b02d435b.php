<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>中山安乐窝手机触屏版</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="/Public/home/jquery.mobile-1.4.3.min.css">
<link rel="stylesheet" href="/Public/home/common-1.4.0.css">
<script src="/Public/home/jquery-1.10.2.min.js"></script>
<script>
$(document).bind("mobileinit", function(){
	//默认转场(过度)效果
	$.mobile.defaultPageTransition = 'none';
	//是否缓存访问过的页面
	//$.mobile.page.prototype.options.domCache = false;
});
</script>
<script src="/Public/home/jquery.mobile-1.4.3.min.js"></script>
<script src="/Public/home/common-1.4.0.js"></script>
</head>

<body>
<div data-role="page" id="home-index">
	<div data-role="header">
		<h1><span class="logo">安乐窝</span><span style="margin:0 5px;">&#8226;</span>中国第一权威装修行业平台</h1>
	</div>
	<!-- /header -->
	<div data-role="content">
<div class="top-banner">
	<p><span>权威：</span>中国首家泛装饰O2O交易服务平台</p>
	<p><span>保障：</span>管家式服务全程保障装修无忧</p>
	<p><span>实力：</span>超级体验馆提供一站式服务</p>
</div>		<div class="searcher">
			<form action="http://m.alwooo.com/gs" method="get">
				<label for="keyword" class="ui-hidden-accessible">关键词</label>
				<div data-role="controlgroup" data-type="horizontal">
					<input name="keyword" id="keyword" value="" placeholder="输入装修公司名字..." type="text" data-wrapper-class="controlgroup-textinput ui-btn ui-shadow" />
					<button data-icon="search" data-iconpos="notext">Search</button>
				</div>
			</form>
		</div>
		<div class="btn_yikoujia">
			<a data-icon="shop" data-role="button" data-ajax="false" href="http://zs.anlewo.com/html/special/2015/8.8shengdian/#rd#userconsent#" class="ui-btn ui-icon-shop ui-btn-icon-left ui-shadow ui-corner-all" role="button">全民抄底 8.8装修电商节！ </a>
<!--			<a data-icon="shop" data-role="button" data-ajax="false" href="--><!--" class="ui-btn ui-icon-shop ui-btn-icon-left ui-shadow ui-corner-all" role="button">全民抄底 8.8装修电商节！ </a>-->
		</div>
		<div class="home-btn">
			<div class="ui-grid-b">
				<div class="ui-block-a">
					<a href="http://m.alwooo.com/zhaobiao" class="ui-btn ui-shadow ui-corner-all ui-icon-sheji ui-btn-icon-top">免费设计</a>
				</div>
				<div class="ui-block-b">
					<a href="http://m.alwooo.com/baojia" class="ui-btn ui-shadow ui-corner-all ui-icon-baojia ui-btn-icon-top">免费报价</a>
				</div>
				<div class="ui-block-c">
					<a href="http://m.alwooo.com/zhaobiao/baozhang" class="ui-btn ui-shadow ui-corner-all ui-icon-baozhang ui-btn-icon-top">装修保障</a>
				</div>
				<div class="ui-block-a">
					<a href="<?php echo U('index/gs');?>" class="ui-btn ui-shadow ui-corner-all ui-icon-gs ui-btn-icon-top">装修公司</a>
				</div>
				<div class="ui-block-b">
					<a href="http://m.alwooo.com/cases" class="ui-btn ui-shadow ui-corner-all ui-icon-anli ui-btn-icon-top">装修案例</a>
				</div>
				<div class="ui-block-c">
					<a href="http://m.alwooo.com/article" class="ui-btn ui-shadow ui-corner-all ui-icon-xuetang ui-btn-icon-top">装修学堂</a>
				</div>
			</div>
		</div>
		<div class="form">
			<h4 style="margin-bottom:0; font-weight:normal;">闪电申请免费设计：</h4>
			<form action="http://m.alwooo.com/zhaobiao" method="get">
				<input type="hidden" value="m-zhaobiao" name="add_from" />
				<label for="mobile" class="ui-hidden-accessible">关键词</label>
				<div data-role="controlgroup" data-type="horizontal">
					<input name="mobile" id="mobile" value="" placeholder="输入手机号码..." type="text" data-wrapper-class="controlgroup-textinput ui-btn ui-shadow" />
					<button data-icon="check" data-iconpos="notext">申请</button>
				</div>
			</form>
		</div>
		<div class="content-footer">
			<p style="text-align:center; margin-bottom:5px;">安乐窝 &#8226; 中国第一权威装修行业平台</p>
			<p class="tac" style="margin:0.5em 0;"><a style="color:#333;" href="http://m.alwooo.com/">触屏版</a><span style="color:#999; margin:0 0.5em;">|</span><a style="color:#999;" href="http://www.alwooo.com?fromwap=1">电脑版</a></p>
		</div>
	</div>
	<!-- /content -->
	<div data-role="footer" data-position="fixed">
		<a class="ui-btn-left ui-btn ui-btn-a ui-btn-inline ui-mini ui-corner-all ui-btn-icon-left ui-icon-bars" href="#popupMenu-home-index" data-rel="popup" data-transition="none">菜单</a>
		<span class="ui-title"></span>
		<a class="ui-btn-right ui-btn ui-btn-a ui-btn-inline ui-mini ui-corner-all ui-btn-icon-left ui-icon-phone" href="tel:0760-88888158">0760-88888158</a>
	</div>
	<!-- /footer --> 
	<!--菜单-->
	<div data-role="popup" data-shadow="false" id="popupMenu-home-index"  style="overflow:hidden;">
		<ul data-role="listview" data-inset="true" style="min-width:100px;">
			<!--<li data-role="list-divider">菜单</li>-->
			<li><a href="http://m.alwooo.com/">网站首页</a></li>
			<li><a href="http://m.alwooo.com/zhaobiao">免费设计</a></li>
			<!--<li><a href="http://m.alwooo.com/baojia">免费报价</a></li>-->
			<li><a href="http://m.alwooo.com/gs">装修公司</a></li>
			<li><a href="http://m.alwooo.com/cases">经典案例</a></li>
			<li><a href="http://m.alwooo.com/zhaobiao/baozhang">装修保障</a></li>
			<li><a href="http://m.alwooo.com/article">装修学堂</a></li>
		</ul>
	</div>
</div>
<!-- /page -->
</body>
</html>