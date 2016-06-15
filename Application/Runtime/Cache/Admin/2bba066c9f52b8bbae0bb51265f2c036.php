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
<script type="text/javascript" src="/Public/Common/js/jquery/jquery.edit.js"></script>
</head>
<body style="background-color: #FFF; overflow: auto;">
	<script type="text/javascript" src="/Public/Common/js/jquery/jquery.picTip.js"></script>
	<div id="append_parent"></div>
	<div id="ajaxwaitid"></div>
	<div class="page">
		<div class="fixed-bar">
			<div class="item-title">
				<?php if(($back) != "0"): ?><a class="back" href="<?php echo U('menu/index');?>" title="返回列表"><i class="fa fa-arrow-circle-o-left"></i></a><?php endif; ?>
				<div class="subject">
					<h3><?php echo ($subject); ?></h3>
					<h5>后台菜单的添加、修改和删除</h5>
				</div>
			</div>
		</div>
		<table class="flex-table">
			<thead>
				<tr>
					<th width="24" align="center" class="sign"><i class="ico-check"></i></th>
					<th width="150" class="handle" align="center">操作</th>
					<th width="60" align="center">排序</th>
					<th width="300" align="left">菜单名称</th>
					<th width="80" align="center">类型</th>
					<th width="80" align="center">状态</th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				<?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$r): $mod = ($i % 2 );++$i;?><tr data-id="<?php echo ($r["menu_id"]); ?>">
					<td class="sign"><i class="ico-check"></i></td>
					<td class="handle">
					<a class="btn red" href="javascript:void(0);" onclick="fg_del(<?php echo ($r["menu_id"]); ?>);"><i class="fa fa-trash-o"></i>删除</a>
						<span class="btn"><em><i class="fa fa-cog"></i>设置<i class="arrow"></i></em>
						<ul>
							<li><a href="<?php echo U('menu/edit',array('menu_id'=>$r['menu_id']));?>">编辑此菜单</a></li>
							<li><a href="<?php echo U('menu/add',array('pid'=>$r['menu_id']));?>">新增子菜单</a></li>
							<li><a href="<?php echo U('menu/index',array('pid'=>$r['menu_id'],'pname'=>$r['menu_name']));?>">查看子菜单</a></li>
						</ul>
						</span>
					</td>
					<td class="sort"><span title="可编辑" column_id="<?php echo ($r["menu_id"]); ?>" fieldname="sort" nc_type="inline_edit" class="editable "><?php echo ($r["sort"]); ?></span></td>
					<td class="name"><span title="可编辑" column_id="<?php echo ($r["menu_id"]); ?>" fieldname="menu_name" nc_type="inline_edit" class="editable "><?php echo ($r["menu_name"]); ?></span></td>
					<td><?php if(($r["type"]) == "1"): ?>菜单<?php else: ?>节点<?php endif; ?></td>
					<td>
						<?php if(($r["status"]) == "0"): ?><span class="no"><i class="fa fa-ban"></i>禁用</span>
						<?php else: ?>
						<span class="yes"><i class="fa fa-check-circle"></i>启用</span><?php endif; ?>
					</td>
					<td></td>
				</tr><?php endforeach; endif; else: echo "" ;endif; ?>
			</tbody>
		</table>
	</div>
	<script>
		$(function(){
			$('.flex-table').flexigrid({
				height:'auto',// 高度自动
				usepager: false,// 不翻页
				striped:false,// 不使用斑马线
				resizable: false,// 不调节大小
				title: '<?php echo ($ftitle); ?>',// 表格标题
				reload: false,// 不使用刷新
				columnControl: false,// 不使用列控制
				buttons : [
					{display: '<i class="fa fa-plus"></i>新增数据', name : 'add', bclass : 'add', onpress : fg_operation },
					{display: '<i class="fa fa-trash"></i>批量删除', name : 'del', bclass : 'del', title : '将选定行数据批量删除', onpress : fg_operation },
				]
			});

			$('span[nc_type="inline_edit"]').inline_edit({c:'menu',a:'ajax_save_menu'});
		});
		
		function fg_operation(name, bDiv) {
			if (name == 'add') {
				window.location.href = '<?php echo U("menu/add");?>';
			}else if (name == 'del') {
				if ($('.trSelected', bDiv).length == 0) {
					showError('请选择要操作的数据项！');
				}
				var itemids = new Array();
				$('.trSelected', bDiv).each(function(i){
					itemids[i] = $(this).attr('data-id');
				});
				fg_del(itemids);
			}
		}
		
		function fg_del(ids){
			if (typeof ids == 'number') {
				var ids = new Array(ids.toString());
			};
			id = ids.join(',');
			if(confirm('确认删除此菜单及其所有子菜单吗？')){
				$.getJSON('<?php echo U("menu/del");?>', {id:id}, function(data){
					if (data.status) {
						location.reload();
					} else {
						showError(data.info)
					}
				});
			}
		}
	</script>
	<div id="goTop"> <a href="JavaScript:void(0);" id="btntop"><i class="fa fa-angle-up"></i></a><a href="JavaScript:void(0);" id="btnbottom"><i class="fa fa-angle-down"></i></a></div>
</body>
</html>