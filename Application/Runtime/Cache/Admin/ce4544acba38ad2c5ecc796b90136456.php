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
				<a class="back" href="<?php echo U('admin/index');?>" title="返回列表"><i class="fa fa-arrow-circle-o-left"></i></a>
				<div class="subject">
					<h3>后台菜单 - 添加菜单</h3>
					<h5>后台菜单的添加、修改和删除</h5>
				</div>
			</div>
		</div>
		
		
		<form id="add_form" method="post" action="<?php echo U('menu/save_menu');?>">
			<input type="hidden" name="form_submit" value="ok" />
			<div class="ncap-form-default">
				<dl class="row">
					<dt class="tit">
						<label for="pid"><em>*</em>上级菜单</label>
					</dt>
					<dd class="opt">
						<select name="pid" value="<?php echo ($pid); ?>">
							<option value="0">-请选择-</option>
							<?php echo ($select_menu); ?>
						</select>
						<span class="err"></span>
						<p class="notic">请选择一个上级菜单，如果不设置，默认为顶级菜单。</p>
					</dd>
				</dl>
				<dl class="row">
					<dt class="tit">
						<label for="menu_name"><em>*</em>菜单名称</label>
					</dt>
					<dd class="opt">
						<input type="text" id="menu_name" name="menu_name" class="input-txt">
						<span class="err"></span>
						<p class="notic">要求中文。</p>
					</dd>
				</dl>
				
				<dl class="row">
					<dt class="tit">
						<label for="menu_name"><em>*</em>状态</label>
					</dt>
					<dd class="opt">
						<div class="onoff">
							<label class="cb-enable selected" for="status1">启用</label>
							<label class="cb-disable" for="status0">禁用</label>
							<input type="radio" value="1" name="status" id="status1">
							<input type="radio" value="0" name="status" id="status0">
						</div>
						<p class="notic">禁用时，菜单及其子菜单失效</p>
					</dd>
				</dl>
				
				<dl class="row">
					<dt class="tit">
						<label for="sort"><em>*</em>排序</label>
					</dt>
					<dd class="opt">
						<input type="text" id="sort" name="sort" class="w60">
						<span class="err"></span>
						<p class="notic">数字范围为0~255，数字越小越靠前。</p>
					</dd>
				</dl>
				
				<dl class="row">
					<dt class="tit">
						<label for="module_name">模块名</label>
					</dt>
					<dd class="opt">
						<input type="text" id="module_name" name="module_name" class="input-txt">
						<span class="err"></span>
						<p class="notic">要求英文，最下级菜单添加，对应类名，首字母大写，例如Menu。</p>
					</dd>
				</dl>
				
				<dl class="row">
					<dt class="tit">
						<label for="action_name">操作名</label>
					</dt>
					<dd class="opt">
						<input type="text" id="action_name" name="action_name" class="input-txt">
						<span class="err"></span>
						<p class="notic">要求英文，最下级菜单添加，对应方法名，例如list。</p>
					</dd>
				</dl>
				
				<dl class="row">
					<dt class="tit">
						<label for="data">参数</label>
					</dt>
					<dd class="opt">
						<input type="text" id="data" name="data" class="input-txt">
						<span class="err"></span>
						<p class="notic">链接的自定义参数，多个用&隔开，例如pid=0&id=3。</p>
					</dd>
				</dl>
				
				<dl class="row">
					<dt class="tit">
						<label for="class_name">图标样式</label>
					</dt>
					<dd class="opt">
						<input type="text" id="class_name" name="class_name" class="input-txt">
						<span class="err"></span>
						<p class="notic">附件显示的图标样式，二级菜单有效，例如 ico-shop-1</p>
					</dd>
				</dl>
				
				<dl class="row">
					<dt class="tit">
						<label for="remark">备注</label>
					</dt>
					<dd class="opt">
						<textarea id="remark" class="tarea" rows="6" name="remark"></textarea>
						<p class="notic">用于表示功能说明</p>						
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
			
			rules : {
				menu_name : {
					required : true,
				}
			},
			messages : {
				menu_name : {
					required : '<i class="fa fa-exclamation-circle"></i>菜单名不能为空',
				}
			}
		});
	});
	</script> 
	<div id="goTop"> <a href="JavaScript:void(0);" id="btntop"><i class="fa fa-angle-up"></i></a><a href="JavaScript:void(0);" id="btnbottom"><i class="fa fa-angle-down"></i></a></div>
</body>
</html>