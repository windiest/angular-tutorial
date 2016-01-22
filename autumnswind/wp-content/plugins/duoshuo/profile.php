<?php
$params = array(
	'short_name'	=>	$this->shortName,
	'remote_auth'	=>	$this->remoteAuth($this->userData()),
);
$settingsUrl = 'http://' . self::DOMAIN.'/settings/?' . http_build_query($params);
?>
<link rel="stylesheet" href="<?php echo $this->pluginDirUrl; ?>styles.css" type="text/css" />

<div class="wrap">
<?php screen_icon(); ?>
<h2>我的多说帐号
	<a class="add-new-h2" target="_blank" href="<?php echo $settingsUrl;?>">在新窗口中打开</a>
</h2>
<iframe id="duoshuo-remote-window" src="<?php echo $settingsUrl;?>" style="width:960px;"></iframe>
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
