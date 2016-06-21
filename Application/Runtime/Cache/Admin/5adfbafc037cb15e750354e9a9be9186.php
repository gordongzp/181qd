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
	<script type="text/javascript" src="/Public/Common/js/jquery/jquery.picTip.js"></script></head>
	<div id="append_parent"></div>
	<div id="ajaxwaitid"></div>
	<div class="page">
		<div class="fixed-bar">
			<div class="item-title">
				<?php echo ($back_htn_html); ?>
				<div class="subject">
					<h3>全景管理 - 新增全景</h3>
					<h5>全景索引和管理</h5>
				</div>
			</div>
		</div>
		
		
		<form id="add_form" method="post" enctype="multipart/form-data">
			<input type="hidden" name="form_submit" value="ok" />
			<input type="hidden" name="admin_id" value="<?php echo session('admin.admin_id');?>" />
			<div class="ncap-form-default">
				<div class="title"><h3>基本信息</h3></div>
				
				<dl class="row">
					<dt class="tit">
						<label for="cat_id"><em>*</em>所在栏目</label>
					</dt>
					<dd class="opt">
						<select name="cat_id" id="cat_id" value="<?php echo ($cat_id); ?>">
							<option value="">-请选择-</option>
							<?php if(is_array($nc)): $i = 0; $__LIST__ = $nc;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$r): $mod = ($i % 2 );++$i;?><option value="<?php echo ($r["cat_id"]); ?>"><?php echo ($r["cat_name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
						</select>
						<span class="err"></span>
						<p class="notic">请选择一个发布栏目。</p>
					</dd>
				</dl>
				
				<dl class="row">
					<dt class="tit">
						<label for="title"><em>*</em>全景标题</label>
					</dt>
					<dd class="opt">
						<input type="text" id="title" name="title" value="<?php echo ($title); ?>" class="input-txt">
						<span class="err"></span>
						<p class="notic">单页标题不能超过200个任意字符。</p>
					</dd>
				</dl>
				
				<dl class="row">
					<dt class="tit">
						<label for="file_pic">缩略图</label>
					</dt>
					<dd class="opt">
						<div class="input-file-show">
							<?php if(($pic) != ""): ?><span class="show" id="show_pic">
								<a class="nyroModal" rel="gal" href="<?php echo ($pic); ?>"> <img src="<?php echo ($pic); ?>" onMouseOver="toolTip('<img src=<?php echo ($pic); ?>>')" onMouseOut="toolTip()"></i></a>
							</span><?php endif; ?>
							<span class="type-file-box">
								<input type="file" class="type-file-file" id="file_pic" name="file_pic" size="30" hidefocus="true"  nc_type="upload_file_pic" title="">
								<input type='text' name='textfield' id='textfield' class='type-file-text' />
								<input type='button' name='button' id='button1' value='选择上传...' class='type-file-button' />
								<input type="hidden" name="pic" id="pic" value="" />
							</span>
						</div>
						<a onclick="clear_pic()" class="ncap-btn" href="JavaScript:void(0);"><i class="fa fa-trash"></i>删除</a>
						<span class="err"></span>
						<p class="notic">建议尺寸：316px*226px，允许格式:gif,jpg,jpeg,png</p>
					</dd>
				</dl>
				
				<dl class="row">
					<dt class="tit">
						<label for="summary">简介</label>
					</dt>
					<dd class="opt">
						<textarea name="summary" rows="6" class="tarea" id="summary"><?php echo ($summary); ?></textarea>
					</dd>
				</dl>

				<dl class="row">

					<dt class="tit">
						<label for="is_rotate">自动旋转</label>
					</dt>
					<dd class="opt">
						<div class="onoff">
							<label class="cb-enable" for="is_rotate1">开</label>
							<label class="cb-disable selected" for="is_rotate0">关</label>
							<input type="radio" value="true" name="is_rotate" id="is_rotate1">
							<input type="radio" value="false" name="is_rotate" id="is_rotate0">
						</div>
						<p class="notic"></p>
					</dd>

					<dt class="tit">
						<label for="rotate_speed">旋转速度</label>
					</dt>
					<dd class="opt">
						<input type="text" id="rotate_speed" name="rotate_speed" value="0" class="w60">
						<span class="err"></span>
						<p class="notic">正为顺时针，负为逆时针。</p>
					</dd>

					<dt class="tit">
						<label for="wait_time">等待时间</label>
					</dt>
					<dd class="opt">
						<input type="text" id="wait_time" name="wait_time" value="5" class="w60">
						<span class="err"></span>
						<p class="notic">单位：秒</p>
					</dd>

				</dl>
				
				<dl class="row">
					<dt class="tit">
						<label for="status"><em>*</em>状态</label>
					</dt>
					<dd class="opt">
						<div class="onoff">
							<label class="cb-enable selected" for="status1">显示</label>
							<label class="cb-disable" for="status0">隐藏</label>
							<input type="radio" value="1" name="status" id="status1">
							<input type="radio" value="0" name="status" id="status0">
						</div>
						<p class="notic"></p>
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
	<script type="text/javascript" src="/Public/Admin/kindeditor/kindeditor-min.js"></script>
	<script type="text/javascript" src="/Public/Admin/kindeditor/config.js"></script>
	<script type="text/javascript" src="/Public/Admin/kindeditor/lang/zh_CN.js"></script>
	<script type="text/javascript" src="/Public/Common/js/jquery/jquery.iframe-transport.js"></script>
	<script type="text/javascript" src="/Public/Common/jquery-ui/jquery.ui.widget.js"></script>
	<script type="text/javascript" src="/Public/Common/js/jquery/jquery.fileupload.js"></script>
	<script type="text/javascript" src="/Public/Common/js/jquery/jquery.nyroModal.js"></script>
	<script>
	 var KE;
	 KindEditor.ready(function(K) {
		KE = K.create("textarea[name='contents']", option);
		KE.appendHtml = function(id,val) {
			this.html(this.html() + val);
			if (this.isCreated) {
				var cmd = this.cmd;
				cmd.range.selectNodeContents(cmd.doc.body).collapse(false);
				cmd.select();
			}
			return this;
		}
    });
	
	//按钮先执行验证再提交表
	$(document).ready(function(){
		
		$('.nyroModal').nyroModal();

		$("#file_pic").change(function(){
			$("#textfield").val($("#file_pic").val());
		});
			
		//按钮先执行验证再提交表单
		$("#submitBtn").click(function(){
			if($("#add_form").valid()){
			 $("#add_form").submit();
			}
		});
		
		$('#cat_id').val('<?php echo ($cat_id); ?>')
		
		$("#add_form").validate({
			errorPlacement: function(error, element){
				var error_td = element.parent('dd').children('span.err');
				error_td.append(error);
			},
			
			rules: {
				cat_id:{required:true},
				title:{required:true},
			},
			messages: {
				cat_id: {
					required : '<i class="fa fa-exclamation-circle"></i>请选择一个发布栏目。',
				},
				title: {
					required : '<i class="fa fa-exclamation-circle"></i>标题不能为空',
				},
			}
		});
	});
	
	function clear_pic(){
		$("#show_pic").remove();
		$("#textfield").val("");
		$("#file_pic").val("");
		$("#pic").val("");
	}
	
	function add_uploadedfile(data){
		var newImg = '<li id="' + data.file_id + '"><input type="hidden" name="attachment[][path]" value="' + data.file_path  + '" /><div class="thumb-list-pics"><a href="javascript:void(0);"><img src="' + data.file_path  + '" alt=""/></a></div><a href="javascript:del_file_upload(0,' + data.file_id +',\'' + data.file_path  + '\');" class="del" title="删除">X</a><a href="javascript:insert_editor(\'' + data.file_path  + '\');" class="inset"><i class="fa fa-clipboard"></i>插入图片</a></li>';
		$('#thumbnails > ul').prepend(newImg);
	}
	
	function insert_editor(file_name){
		KE.appendHtml('content', '<img src="'+ file_name + '">');
	}
	
	</script> 
	<div id="goTop"> <a href="JavaScript:void(0);" id="btntop"><i class="fa fa-angle-up"></i></a><a href="JavaScript:void(0);" id="btnbottom"><i class="fa fa-angle-down"></i></a></div>
</body>
</html>