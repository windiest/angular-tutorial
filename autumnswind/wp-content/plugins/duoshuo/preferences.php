<link rel="stylesheet" href="<?php echo $this->pluginDirUrl; ?>styles.css" type="text/css" />
<?php
$params = array(
	//'template'		=>	'wordpress',
	'remote_auth'	=>	$this->remoteAuth($this->userData()),
);
$adminUrl = 'http://' . $this->shortName . '.' . self::DOMAIN . '/admin/settings/?' . http_build_query($params);
?>
<div class="wrap">
<?php screen_icon(); ?>
<h2>多说评论框设置
<a class="add-new-h2" target="_blank" href="<?php echo $adminUrl;?>">在新窗口中打开</a></h2>
<iframe id="duoshuo-remote-window" src="<?php echo $adminUrl;?>" style="width:100%;"></iframe>
</div>

<script>
jQuery(function(){
var $ = jQuery,
	iframe = $('#duoshuo-remote-window'),
	resetIframeHeight = function(){
		iframe.height($(window).height() - iframe.offset().top - 70);
	};
resetIframeHeight();
$(window).resize(resetIframeHeight);
});
</script>
