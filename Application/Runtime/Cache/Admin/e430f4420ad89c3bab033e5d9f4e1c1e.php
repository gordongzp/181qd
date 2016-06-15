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
	<script type="text/javascript" src="/Public/Common/js/jquery/jquery.picTip.js"></script>
	<div id="append_parent"></div>
	<div id="ajaxwaitid"></div>
	<div class="page">
		<div class="fixed-bar">
			<div class="item-title">
				<div class="subject">
					<h3>管理员</h3>
					<h5>管理员的添加、修改和删除</h5>
				</div>
				<!--<ul class="tab-base nc-row">
					<li><a class="current"><span>管理员</span></a></li>
					<li><a href="<?php echo U('admin/group');?>" ><span>权限组</span></a></li>
					<li><a href="<?php echo U('menu/index');?>" ><span>菜单节点</span></a></li>
				</ul>-->
			</div>
		</div>
		<table class="flex-table">
			<thead>
				<tr>
					<th width="24" align="center" class="sign"><i class="ico-check"></i></th>
					<th width="150" align="center" class="handle">操作</th>
					<th width="120" align="center">角色</th>
					<th width="100" align="left">登录名</th>
					<th width="120" align="center">上次登录</th>
					<th width="60" align="center">登录次数</th>
					<th width="120" align="center">最后登录IP</th>
					<th></th>
				</tr>
			</thead>
			<tbody>
			<?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$r): $mod = ($i % 2 );++$i;?><tr>
					<td class="sign"><i class="ico-check"></i></td>
					<td class="handle">
						<?php if(($r["is_supper"]) == "1"): ?><span>--</span>
						<?php else: ?>
						<a class="btn red" href="<?php echo U('admin/del_admin',array('admin_id'=>$r['admin_id']));?>" onclick="if(confirm('删除后将不能恢复，确认删除这  1 项吗？')){return true;} else {return false;}"><i class="fa fa-trash-o"></i>删除</a>
						<a class="btn blue" href="<?php echo U('admin/edit',array('admin_id'=>$r['admin_id']));?>"><i class="fa fa-pencil-square-o"></i>编辑</a><?php endif; ?>
					</td>
					<td><?php echo ($r["role"]["role_name"]); ?></td>
					<td><?php echo ($r["admin_name"]); ?></td>
					<td>
						<?php if(($r["last_login_time"]) == ""): ?>此管理员未登录过
						<?php else: ?>
							<?php echo (date('Y-m-d H:i:s',$r["last_login_time"])); endif; ?>
					</td>
					<td><?php echo ($r["login_times"]); ?></td>
					<td><?php echo ($r["last_login_ip"]); ?></td>
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
			title: '管理员列表',
			buttons : [
					   {display: '<i class="fa fa-plus"></i>新增数据', name : 'add', bclass : 'add', onpress : fg_operation }
				   ]
		});

		function fg_operation(name, grid) {
			if (name == 'add') {
				window.location.href = '<?php echo U("admin/add");?>';
			}
		}
	</script>
	<div id="goTop"> <a href="JavaScript:void(0);" id="btntop"><i class="fa fa-angle-up"></i></a><a href="JavaScript:void(0);" id="btnbottom"><i class="fa fa-angle-down"></i></a></div>
</body>
</html>