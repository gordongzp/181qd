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
					<h3>角色管理</h3>
					<h5>管理员的分组和权限设置</h5>
				</div>
			</div>
		</div>
		<table class="flex-table">
			<thead>
				<tr>
					<th width="24" align="center" class="sign"><i class="ico-check"></i></th>
					<th width="150" align="center" class="handle">操作</th>
					<th width="150" align="left">角色</th>
					<th></th>
				</tr>
			</thead>
			<tbody>
			<?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$r): $mod = ($i % 2 );++$i;?><tr class="hover">
					<td class="sign"><i class="ico-check"></i></td>
					<td class="handle">
						<a class="btn red" href="<?php echo U('role/del_role',array('role_id'=>$r['role_id']));?>" onclick="if(confirm('确定要删除此权限及拥有此权限的管理员吗？')){return true;} else {return false;}"><i class="fa fa-trash-o"></i>删除</a>
						<a class="btn blue" href="<?php echo U('role/edit',array('role_id'=>$r['role_id']));?>"><i class="fa fa-pencil-square-o"></i>编辑</a>
					</td>
					<td><?php echo ($r["role_name"]); ?></td>
					<td></td>
				</tr><?php endforeach; endif; else: echo "" ;endif; ?>
			</tbody>
		</table>
	</div>
	<script>
		$('.flex-table').flexigrid({	
			height:'auto',// 高度自动
			usepager: false,// 不翻页
			striped: true,// 使用斑马线
			resizable: false,// 不调节大小
			reload: false,// 不使用刷新
			columnControl: false,// 不使用列控制 
			title: '角色列表',
			buttons : [
					   {display: '<i class="fa fa-plus"></i>新增数据', name : 'add', bclass : 'add', onpress : fg_operation }
				   ]
			});

		function fg_operation(name, grid) {
			if (name == 'add') {
				window.location.href = '<?php echo U("role/add");?>';
			}
		}
	</script>
	<div id="goTop"> <a href="JavaScript:void(0);" id="btntop"><i class="fa fa-angle-up"></i></a><a href="JavaScript:void(0);" id="btnbottom"><i class="fa fa-angle-down"></i></a></div>
</body>
</html>