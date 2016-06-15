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
				<a class="back" href="<?php echo U('role/index');?>" title="返回列表"><i class="fa fa-arrow-circle-o-left"></i></a>
				<div class="subject">
					<h3><?php echo ($subject); ?></h3>
					<h5>管理中心操作权限及分组设置</h5>
				</div>
			</div>
		</div>
		<div class="explanation" id="explanation">
			<div class="title" id="checkZoom">
				<i class="fa fa-lightbulb-o"></i>
				<h4 title="提示相关设置操作时应注意的要点">操作提示</h4>
				<span id="explanationZoom" title="收起提示"></span> 
			</div>
			<ul>
				<li>可添加一个权限组，并为其命名，方便添加管理员时使用。</li>
				<li>可在标题处全选所有功能或根据功能模块逐一选择操作权限，提交保存后生效。</li>
			</ul>
		</div>
		<form id="add_form" action="<?php echo U('role/save_role');?>" method="post" style="margin-bottom: 50px;">
			<input type="hidden" name="form_submit" value="ok" />
			<input type="hidden" name="role_id" id="role_id" value="<?php echo ($role_id); ?>" />
			<div class="ncap-form-default">
				<dl class="row">
					<dt class="tit"><label for="role_name"><em>*</em>权限组</label></dt>
					<dd class="opt">
						<input type="text" id="role_name" maxlength="40" name="role_name" value="<?php echo ($role_name); ?>" class="input-txt">
						<span class="err"></span>
						<p class="notic">为权限组设置特定名称，便于添加管理员时选择使用。</p>
					</dd>
				</dl>
				<dl class="row">
					<dt class="tit">设置权限</dt>
					<dd class="opt">
						<input id="limitAll" value="1" type="checkbox" class="checkbox">
						全部操作
						<p class="notic">勾选后选中全部操作功能，可根据需要从设置详情中进行分组设置。</p>
					</dd>
				</dl>
			</div>
			<div class="ncap-form-all">
				<div class="title"><h3><?php echo ($ftitle); ?></h3></div>
				<?php if(is_array($menu)): $i = 0; $__LIST__ = $menu;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$m1): $mod = ($i % 2 );++$i;?><dl class="row">
					<dt class="tit">
						<span><input class="checkbox" type="checkbox" name="auth[]" value="<?php echo ($m1["menu_id"]); ?>" id="menu<?php echo ($m1["menu_id"]); ?>" nctype="modulesAll"><label for="menu<?php echo ($m1["menu_id"]); ?>"><?php echo ($m1["menu_name"]); ?></label></span>
					</dt>
					<dd class="opt nobg nopd nobd nobs">
						<?php if(is_array($m1["sub"])): $i = 0; $__LIST__ = $m1["sub"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$m2): $mod = ($i % 2 );++$i;?><div class="ncap-account-container">
							<h4>
								<input class="checkbox" id="menu<?php echo ($m2["menu_id"]); ?>" name="auth[]" value="<?php echo ($m2["menu_id"]); ?>" type="checkbox" nctype="groupAll">
								<label for="menu<?php echo ($m2["menu_id"]); ?>"><?php echo ($m2["menu_name"]); ?></label>
							</h4>
							<ul class="ncap-account-container-list">
								<?php if(is_array($m2["sub"])): $i = 0; $__LIST__ = $m2["sub"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$m3): $mod = ($i % 2 );++$i;?><li>
									<input class="checkbox" id="menu<?php echo ($m3["menu_id"]); ?>" name="auth[]" type="checkbox" value="<?php echo ($m3["menu_id"]); ?>">
									<label for="menu<?php echo ($m3["menu_id"]); ?>"><?php echo ($m3["menu_name"]); ?></label>
									<?php if(($m3["sub"]) != ""): ?>【<span class="ncap-account-container-point">
										<?php if(is_array($m3["sub"])): foreach($m3["sub"] as $key=>$m4): ?><p>
											<input class="checkbox" id="menu<?php echo ($m4["menu_id"]); ?>" name="auth[]" type="checkbox" value="<?php echo ($m4["menu_id"]); ?>">
											<label for="menu<?php echo ($m4["menu_id"]); ?>"><?php echo ($m4["menu_name"]); ?></label>
										</p><?php endforeach; endif; ?>
									</span>】<?php endif; ?>
								</li><?php endforeach; endif; else: echo "" ;endif; ?>
							</ul>
						</div><?php endforeach; endif; else: echo "" ;endif; ?>
					</dd>
				</dl><?php endforeach; endif; else: echo "" ;endif; ?>
				<div class="fix-bot"><a href="JavaScript:void(0);" class="ncap-btn-big ncap-btn-green" id="submitBtn">确认提交</a></div>
			</div>
		</form>
	</div>

	<div id="goTop"> <a href="JavaScript:void(0);" id="btntop"><i class="fa fa-angle-up"></i></a><a href="JavaScript:void(0);" id="btnbottom"><i class="fa fa-angle-down"></i></a></div>
</body>
</html>
<script>
function selectLimit(name){
    if($('#'+name).attr('checked')) {
        $('.'+name).attr('checked',true);
    }else {
        $('.'+name).attr('checked',false);
    }
}
$(document).ready(function(){
	//按钮先执行验证再提交表单
	$("#submitBtn").click(function(){
	    if($("#add_form").valid()){
	     $("#add_form").submit();
		}
	});
	
	
	var select_menu_ids = <?php echo ($select_menu_ids); ?>;
	if(select_menu_ids){
		$.each(select_menu_ids,function(i,id){
			$('input[name="auth[]"][value="' + id +'"]').attr('checked',true);
		});
	}

    // 全选
    $('#limitAll').click(function(){
    	$('input[type="checkbox"]').attr('checked',$(this).attr('checked') == 'checked');
    });
    // 功能模块
    $('input[nctype="modulesAll"]').click(function(){
        $(this).parents('dt:first').next().find('input[type="checkbox"]').attr('checked',$(this).attr('checked') == 'checked');
    });
    // 功能组
    $('input[nctype="groupAll"]').click(function(){
        $(this).parents('h4:first').next().find('input[type="checkbox"]').attr('checked',$(this).attr('checked') == 'checked');
    });
	
	$("#add_form").validate({
		errorPlacement: function(error, element){
			var error_td = element.parent('dd').children('span.err');
            error_td.append(error);
        },
        rules : {
            role_name : {
                required : true,
				remote	: {
                    url :'<?php echo U("admin/check_role_exist");?>',
                    type:'get',
                    data:{
                    	role_name : function(){
                            return $('#role_name').val();
                        },
						role_id : function(){
                            return $('#role_id').val();
                        }
                    }
                }
            }
        },
        messages : {
            role_name : {
                required : '<i class="fa fa-exclamation-circle"></i>请输入',
                remote   : '<i class="fa fa-exclamation-circle"></i>该名称已存在'
            }
        }
	});
});
</script>