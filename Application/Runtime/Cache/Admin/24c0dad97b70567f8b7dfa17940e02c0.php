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
				<?php echo ($back_htn_html); ?>
				<div class="subject">
					<h3>全景管理</h3>
					<h5>全景索引和管理</h5>
				</div>
			</div>
		</div>
		
		<div id="explanation" class="explanation">
			<div id="checkZoom" class="title">
				<i class="fa fa-lightbulb-o"></i>
				<h4 title="提示相关设置操作时应注意的要点">操作提示</h4>
				<span title="收起提示" id="explanationZoom"></span> 
			</div>
			<ul>
				<li>通过修改排序数字可以控制前台显示顺序，数字越小越靠前</li>
				<li>可以直接在列表中修改文章对应的浏览数，开启关闭评论和心情功能</li>
			</ul>
		</div>
		<div id="flexigrid"></div>
	</div>
	<script>
		$(function(){
			$("#flexigrid").flexigrid({
				url: '<?php echo U("tour/index");?>',
				colModel : [
				{display: '操作', name : 'operation', width : 250, sortable : false, align: 'center', className: 'handle'},
				{display: '排序', name : 'sort', width : 60, sortable : true, align: 'center'},
				{display: '全景标题', name : 'title', width : 300, sortable : false, align: 'left'},
				{display: '缩略图', name : 'pic', width : 60, sortable : false, align: 'center'},					
				{display: '场景数', name : 'scene', width : 60, sortable : false, align: 'center'},					
				{display: '分类', name : 'cat_name', width : 80, sortable : false, align: 'center'},
				{display: '浏览量', name : 'view_times', width : 80, sortable : false, align: 'center'},
				{display: '状态', name : 'status', width : 80, sortable : true, align: 'center'},
				{display: '更新时间', name : 'update_time', width : 130, sortable : true, align: 'center', className: 'column-a'},
				],
				buttons : [

				{display: '<i class="fa fa-plus"></i>添加全景', name : 'add', bclass : 'add', title : '添加新的全景', onpress : fg_operation },
				{display: '<i class="fa fa-trash"></i>批量删除', name : 'del', bclass : 'del', title : '将选定全景批量删除', onpress : fg_operation },
				{display: '<i class="fa fa-truck"></i>一键生成', name : 'xml', bclass : 'add', title : '一键生成全景', onpress : fg_operation },
				
				],
				searchitems : [
				{display: '全景标题', name : 'title'},
				],
				sortname: "sort",
				sortorder: "asc",
				title: '全景列表'
			});
			
			
		});
		
		function fg_operation(name, bDiv) {
			if(name == 'add') {
				window.location.href = '<?php echo U("tour/add");?>';
			}else if (name == 'del') {
				if ($('.trSelected', bDiv).length == 0) {
					showError('请选择要操作的数据项！');
				}
				var itemids = new Array();
				$('.trSelected', bDiv).each(function(i){
					itemids[i] = $(this).attr('data-id');
				});
				fg_del(itemids);
			}else if (name == 'xml'){
				window.location.href = "<?php echo U('kp/file_put_all');?>";
			}
		}

		function fg_del(ids){
			if (typeof ids == 'number') {
				var ids = new Array(ids.toString());
			};
			id = ids.join(',');
			if(confirm('确认这些全景吗？')){
				$.getJSON('<?php echo U("tour/del");?>', {id:id}, function(data){
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