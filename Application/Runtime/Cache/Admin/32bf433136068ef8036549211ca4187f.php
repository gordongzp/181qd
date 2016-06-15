<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
<link rel="stylesheet" type="text/css" href="/Public/Common/jquery-ui/jquery-ui.min.css" />
<link rel="stylesheet" type="text/css" href="/Public/Admin/css/index.css" />
<link rel="stylesheet" type="text/css" href="/Public/Admin/font/font-awesome.min.css" />
<link rel="stylesheet" type="text/css" href="/Public/Common/css/perfect-scrollbar.min.css" />
<style>html, body { overflow: visible;}</style>
<script>

var ADMIN_TEMPLATES_URL = '/Public/Admin';
var LOADING_IMAGE = "/Public/Admin/images/loading.gif";
var ADMIN_RESOURCE_URL = '/Public/Admin';
</script>
<script type="text/javascript" src="/Public/Common/js/jquery/jquery.js"></script>
<script type="text/javascript" src="/Public/Common/jquery-ui/jquery-ui.min.js"></script>
<script type="text/javascript" src="/Public/Common/jquery-ui/zh-CN.js"></script>
<script type="text/javascript" src="/Public/Admin/js/admin.js"></script>
<script src="/Public/Admin/dialog/dialog.js" id="dialog_js"></script>
<script type="text/javascript" src="/Public/Admin/js/flexigrid.js"></script>
<script type="text/javascript" src="/Public/Common/js/jquery/jquery.validation.min.js"></script>
<script type="text/javascript" src="/Public/Admin/js/common.js"></script>
<script type="text/javascript" src="/Public/Common/js/perfect-scrollbar.min.js"></script>
<script type="text/javascript" src="/Public/Common/js/jquery/jquery.mousewheel.js"></script>

</head>
<body style="background-color: #FFF; overflow: auto;">
	<script type="text/javascript" src="/Public/Common/js/jquery/jquery.picTip.js"></script>
	<div id="append_parent"></div>
	<div id="ajaxwaitid"></div>

	<div class="page">
		<div class="fixed-bar">
			<div class="item-title">
				<div class="subject">
					<h3><?php echo ($subject); ?></h3>
					<h5>网站全局内容基本选项设置</h5>
				</div>
			</div>
		</div>
		<!-- 操作说明 -->
		<div class="explanation" id="explanation">
			<div class="title" id="checkZoom">
				<i class="fa fa-lightbulb-o"></i>
				<h4 title="提示相关设置操作时应注意的要点">操作提示</h4>
				<span id="explanationZoom" title="收起提示"></span> 
			</div>
			<ul>
				<li>网站全局基本设置，商城及其他模块相关内容在其各自栏目设置项内进行操作。</li>
			</ul>
		</div>
		<form method="post" action="<?php echo U('system/site_setting');?>" id="save_form" name="form1">
			<input type="hidden" name="form_submit" value="ok" />
			<div class="ncap-form-default">
				<dl class="row">
					<dt class="tit">
						<label for="site_name">网站名称</label>
					</dt>
					<dd class="opt">
						<input id="site_name" name="site_name" value="<?php echo ($site_name); ?>" class="input-txt" type="text" />
						<p class="notic">网站名称，将显示在前台顶部欢迎信息等位置</p>
					</dd>
				</dl>
				<dl class="row">
					<dt class="tit">
						<label for="icp_number">ICP证书号</label>
					</dt>
					<dd class="opt">
						<input type="text" class="input-txt" value="" name="icp_number" id="icp_number" value="<?php echo ($icp_number); ?>">
						<p class="notic">前台页面底部可以显示 ICP 备案信息，如果网站已备案，在此输入你的授权码，它将显示在前台页面底部，如果没有请留空</p>
					</dd>
				</dl>
				<dl class="row">
					<dt class="tit">
						<label for="company_address">公司地址</label>
					</dt>
					<dd class="opt">
						<textarea name="company_address" rows="6" class="tarea" id="statistics_code"><?php echo ($company_address); ?></textarea>
						<p class="notic">公司地址，将显示前台联系信息模块等位置</p>
					</dd>
				</dl>
				<dl class="row">
					<dt class="tit">
						<label for="company_tel">电话</label>
					</dt>
					<dd class="opt">
						<input id="company_tel" name="company_tel" value="<?php echo ($company_tel); ?>" class="input-txt" type="text" />
						<p class="notic">公司电话，将显示前台联系信息模块等位置，格式：0760-22558811</p>
					</dd>
				</dl>
				<dl class="row">
					<dt class="tit">
						<label for="company_fax">传真</label>
					</dt>
					<dd class="opt">
						<input id="company_fax" name="company_fax" value="<?php echo ($company_fax); ?>" class="input-txt" type="text" />
						<p class="notic">传真，将显示前台联系信息模块等位置，格式：0760-22558811</p>
					</dd>
				</dl>
				
				<dl class="row">
					<dt class="tit">
						<label for="company_email">邮箱</label>
					</dt>
					<dd class="opt">
						<input id="company_email" name="company_email" value="<?php echo ($company_email); ?>" class="input-txt" type="text" />
						<p class="notic">邮箱，将显示前台联系信息模块等位置，格式：123@qq.com</p>
					</dd>
				</dl>
				
				<dl class="row">
					<dt class="tit">
						<label for="site_seo_title">首页seo标题</label>
					</dt>
					<dd class="opt">
						<input id="site_seo_title" name="site_seo_title" value="<?php echo ($site_seo_title); ?>" class="input-txt" type="text" />
						<p class="notic">默认首页标题</p>
					</dd>
				</dl>
				
				<dl class="row">
					<dt class="tit">
						<label for="site_seo_keywords">首页关键词</label>
					</dt>
					<dd class="opt">
						<input id="site_seo_keywords" name="site_seo_keywords" value="<?php echo ($site_seo_keywords); ?>" class="input-txt" type="text" />
						<p class="notic">默认首页关键词</p>
					</dd>
				</dl>
				
				<dl class="row">
					<dt class="tit">
						<label for="site_seo_description">首页描述</label>
					</dt>
					<dd class="opt">
						<textarea name="site_seo_description" rows="6" class="tarea" id="site_seo_description"><?php echo ($site_seo_description); ?></textarea>
						<p class="notic">默认首页描述</p>
					</dd>
				</dl>
				
				<div class="bot"><a href="JavaScript:void(0);" class="ncap-btn-big ncap-btn-green" onclick="document.form1.submit()">确认提交</a></div>
			</div>
		</form>
	</div>
	<script type="text/javascript">
	$(function(){
		
	});
	</script> 
	<div id="goTop"> 
		<a href="JavaScript:void(0);" id="btntop">
			<i class="fa fa-angle-up"></i>
		</a>
		<a href="JavaScript:void(0);" id="btnbottom">
			<i class="fa fa-angle-down"></i>
		</a>
	</div>
</body>
</html>