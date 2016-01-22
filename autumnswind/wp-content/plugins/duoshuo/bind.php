<link rel="stylesheet" href="<?php echo self::$pluginDirUrl; ?>styles.css" type="text/css" />
<?php
/**
 * 给那些已经有wordpress帐号但是没有access token的用户使用，绑定帐号
 */
$query = http_build_query(array(
	'sso'	=>	1,
	'remote_auth'=>Duoshuo::remoteAuth(),
), null, '&');
?>
<h3>绑定社交帐号之后您便可以享用多说的服务了，多说可以让您：</h3>
<ul>
	<li>无需密码，用社交帐号即可登录本博客</li>
	<li>发布文章时同步发布微博</li>
	<li>发布评论时同步发微博</li>
	<li>别人对你的回复，第一时间提醒你，不再错过精彩评论</li>
</ul>
<ul class="ds-service-icon">
	<li><a class="ds-weibo" href="<?php echo 'http://' . self::$shortName . '.duoshuo.com/bind/weibo/?' . $query;?>" title="绑定微博帐号"></a></li>
	<li><a class="ds-qq" href="<?php echo 'http://' . self::$shortName . '.duoshuo.com/bind/qq/?' . $query;?>" title="绑定QQ帐号"></a></li>
	<li><a class="ds-renren" href="<?php echo 'http://' . self::$shortName . '.duoshuo.com/bind/renren/?' . $query;?>" title="绑定人人帐号"></a></li>
	<li><a class="ds-kaixin" href="<?php echo 'http://' . self::$shortName . '.duoshuo.com/bind/kaixin/?' . $query;?>" title="绑定开心帐号"></a></li>
	<li><a class="ds-douban" href="<?php echo 'http://' . self::$shortName . '.duoshuo.com/bind/douban/?' . $query;?>" title="绑定豆瓣帐号"></a></li>
	<li><a class="ds-netease" href="<?php echo 'http://' . self::$shortName . '.duoshuo.com/bind/netease/?' . $query;?>" title="绑定网易帐号"></a></li>
	<li><a class="ds-sohu" href="<?php echo 'http://' . self::$shortName . '.duoshuo.com/bind/sohu/?' . $query;?>" title="绑定搜狐帐号"></a></li>
	<li><a class="ds-baidu" href="<?php echo 'http://' . self::$shortName . '.duoshuo.com/bind/baidu/?' . $query;?>" title="绑定百度帐号"></a></li>
</ul>
