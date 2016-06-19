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
<link rel="stylesheet" type="text/css" href="/Public/Common/css/perfect-scrollbar.min.csss" />
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
	<script type="text/javascript" src="/Public/Common/js/jquery/jquery.picTip.js"></script></head>
	<div id="append_parent"></div>
	<div id="ajaxwaitid"></div>
	<div class="page">
		<div class="fixed-bar">
			<div class="item-title">
				<?php echo ($back_htn_html); ?>		
				<div class="subject">
					<h3>热点分类 - 新增</h3>
					<h5>热点分类编辑管理</h5>
				</div>
			</div>
		</div>
		
		
		<form id="add_form" method="post">
			<input type="hidden" name="form_submit" value="ok" />
			<input type="hidden" name="cat_id" value="" />
			<div class="ncap-form-default">
				<dl class="row">
					<dt class="tit">
						<label for="cat_name"><em>*</em>分类名称</label>
					</dt>
					<dd class="opt">
						<input type="text" id="cat_name" name="cat_name" class="input-txt">
						<span class="err"></span>
						<p class="notic">分类名称不能为空且必须小于10个字</p>
					</dd>
				</dl>
				
				<dl class="row">
					<dt class="tit">
						<label for="sort">排序</label>
					</dt>
					<dd class="opt">
						<input type="text" id="sort" name="sort" class="w60">
						<span class="err"></span>
						<p class="notic">数字范围为0~255，数字越小越靠前。</p>
					</dd>
				</dl>
			
				<div class="bot"><a href="JavaScript:void(0);" class="ncap-btn-big ncap-btn-green" id="submitBtn">确认提交</a></div>
			</div>
		</form>
	</div>
	<script>
	//按钮先执行验证再提交表
	$(document).ready(function(){
		//按钮先执行验证再提交表单
		$("#submitBtn").click(function(){
			if($("#add_form").valid()){
			 $("#add_form").submit();
			}
		});
		
		$("#add_form").validate({
			errorPlacement: function(error, element){
				var error_td = element.parent('dd').children('span.err');
				error_td.append(error);
			},
			
			rules:{
				cat_name:{
					required:true,
					maxlength:10,
				},
				sort:{
					digits:true,
				}
			},
			messages:{
				cat_name:{
					required:'<i class="fa fa-exclamation-circle"></i>分类名称不能为空！',
					maxlength:'<i class="fa fa-exclamation-circle"></i>分类名称长度少于10个字符！',
				},
				sort:{
					digits:'<i class="fa fa-exclamation-circle"></i>排列序号格式不合法！'
				}
			}
		});
	});
	</script> 
	<div id="goTop"> <a href="JavaScript:void(0);" id="btntop"><i class="fa fa-angle-up"></i></a><a href="JavaScript:void(0);" id="btnbottom"><i class="fa fa-angle-down"></i></a></div>
</body>
</html>