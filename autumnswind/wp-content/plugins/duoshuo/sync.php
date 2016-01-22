<link rel="stylesheet" href="<?php echo $this->pluginDirUrl; ?>styles.css" type="text/css" />
<div class="wrap">
<?php echo screen_icon();?><h2>数据同步</h2>
<div id="ds-export">
	<p class="message-start">安装成功了！只要一键将您的用户、文章和评论信息同步到多说，多说就可以开始为您服务了！<a href="javascript:void(0)" class="button-primary" onclick="fireExport();return false;">开始同步</a></p>
	<p class="status"></p>
	<p class="message-complete">同步完成，现在你可以<a href="<?php echo admin_url('admin.php?page=duoshuo-settings');?>">设置</a>或<a href="<?php echo admin_url('admin.php?page=duoshuo');?>">管理</a></p>
</div>
<?php include_once dirname(__FILE__) . '/common-script.html';?>
</div>
