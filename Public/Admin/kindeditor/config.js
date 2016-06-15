var option = {
	items : ['source', '|', 'fullscreen', 'undo', 'redo', 'print', 'cut', 'copy', 'paste',
            'plainpaste', 'wordpaste', '|', 'justifyleft', 'justifycenter', 'justifyright',
            'justifyfull', 'insertorderedlist', 'insertunorderedlist', 'indent', 'outdent', 'subscript',
            'superscript', '|', 'selectall', 'clearhtml','quickformat','|',
            'formatblock', 'fontname', 'fontsize', '|', 'forecolor', 'hilitecolor', 'bold',
            'italic', 'underline', 'strikethrough', 'lineheight', 'removeformat', '|', 'image', 'table', 'hr', 'emoticons', 'link', 'unlink', '|', 'about'],
	cssPath : "/Public/Admin/kindeditor/themes/default/default.css",
	allowImageUpload : true,
	allowFlashUpload : false,
	allowMediaUpload : false,
	allowFileManager : false,
	syncType:"form",
	afterCreate : function() {
		var self = this;
		self.sync();
	},
	afterChange : function() {
		var self = this;
		self.sync();
	},
	afterBlur : function() {
		var self = this;
		self.sync();
	}
}