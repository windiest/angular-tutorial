<?php

class Duoshuo_Widget_Recent_Comments extends WP_Widget {
	
	protected $duoshuoPlugin;
	
	function __construct() {
		$widget_ops = array('classname' => 'ds-widget-recent-comments', 'description' => '最新评论(由多说提供)' );
		parent::__construct('ds-recent-comments', '最新评论(多说)', $widget_ops);
		
		$this->alt_option_name = 'duoshuo_widget_recent_comments';

		if ( is_active_widget(false, false, $this->id_base) )
			add_action( 'wp_head', array(&$this, 'recent_comments_style') );

		//add_action( 'comment_post', array(&$this, 'flush_widget_cache') );
		//add_action( 'transition_comment_status', array(&$this, 'flush_widget_cache') );
		
		$this->duoshuoPlugin = Duoshuo_WordPress::getInstance();
	}

	function recent_comments_style() {
		if ( ! current_theme_supports( 'widgets' ) )// Temp hack #14876
			return;
		
		if (!did_action('wp_head')){
			$this->duoshuoPlugin->printScripts();
		}
	}
	
	function widget( $args, $instance ) {
		global $comments, $comment;

		if ( ! isset( $args['widget_id'] ) )
			$args['widget_id'] = $this->id;

 		extract($args, EXTR_SKIP);
 		
 		$output = '';
 		$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? __( 'Recent Comments' ) : $instance['title'], $instance, $this->id_base );

		if ( empty( $instance['number'] ) || ! $number = absint( $instance['number'] ) )
 			$number = 10;

		$output .= $before_widget;
		if ( $title )
			$output .= $before_title . $title . $after_title;
		
		$data = array(
			'num_items'	=>	$number,
			'show_avatars'=>isset($instance['show_avatars']) ? $instance['show_avatars'] : 1,
			'show_time'=>	isset($instance['show_time']) ? $instance['show_time'] : 1,
			'show_title'=>	isset($instance['show_title']) ? $instance['show_title'] : 1,
			'show_admin'=>	isset($instance['show_admin']) ? $instance['show_admin'] : 1,
			'avatar_size'=>	32,
			'excerpt_length'=>	isset($instance['excerpt_length']) ? $instance['excerpt_length'] : 70,
		);
		$attribs = '';
		foreach ($data as $key => $value)
			$attribs .= ' data-' . str_replace('_','-',$key) . '="' . esc_attr($value) . '"';
		$output .= '<ul class="ds-recent-comments"' . $attribs . '></ul>'
				. $after_widget;
		echo $output;?>
<script>
if (typeof DUOSHUO !== 'undefined')
	DUOSHUO.RecentCommentsWidget && DUOSHUO.RecentCommentsWidget('.ds-recent-comments');
</script><?php 
	}


	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['number'] = absint( $new_instance['number'] );
		$instance['excerpt_length'] = absint( $new_instance['excerpt_length'] );
		$instance['show_avatars'] =  absint( $new_instance['show_avatars'] );
		$instance['show_time'] =  absint( $new_instance['show_time'] );
		$instance['show_title'] =  absint( $new_instance['show_title'] );
		$instance['show_admin'] =  absint( $new_instance['show_admin'] );

		$alloptions = wp_cache_get( 'alloptions', 'options' );
		if ( isset($alloptions['duoshuo_widget_recent_comments']) )
			delete_option('duoshuo_widget_recent_comments');

		return $instance;
	}
	
	function form( $instance ) {
		$title = isset($instance['title']) ? esc_attr($instance['title']) : '';
		$number = isset($instance['number']) ? absint($instance['number']) : 5;
		$show_avatars = isset($instance['show_avatars']) ? absint( $instance['show_avatars']) : 1;
		$show_title = isset($instance['show_title']) ? absint($instance['show_title']) : 1;
		$show_time = isset($instance['show_time']) ? absint($instance['show_time']) : 1;
		$show_admin = isset($instance['show_admin']) ? absint($instance['show_admin']) : 1;
		$excerpt_length = isset($instance['excerpt_length']) ? absint($instance['excerpt_length']) : 70;
?>
		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></p>

		<p>
			<input name="<?php echo $this->get_field_name('show_avatars'); ?>" type="hidden" value="0" />
			<input id="<?php echo $this->get_field_id('show_avatars'); ?>" name="<?php echo $this->get_field_name('show_avatars'); ?>" type="checkbox" value="1" <?php if ($show_avatars) echo 'checked="checked" '?>/>
			<label for="<?php echo $this->get_field_id('show_avatars'); ?>">显示头像</label>
		</p>
		
		<p>
			<input name="<?php echo $this->get_field_name('show_time'); ?>" type="hidden" value="0" />
			<input id="<?php echo $this->get_field_id('show_time'); ?>" name="<?php echo $this->get_field_name('show_time'); ?>" type="checkbox" value="1" <?php if ($show_time) echo 'checked="checked" '?>/>
			<label for="<?php echo $this->get_field_id('show_time'); ?>">显示评论时间</label>
		</p>
		
		<p>
			<input name="<?php echo $this->get_field_name('show_title'); ?>" type="hidden" value="0" />
			<input id="<?php echo $this->get_field_id('show_title'); ?>" name="<?php echo $this->get_field_name('show_title'); ?>" type="checkbox" value="1" <?php if ($show_title) echo 'checked="checked" '?>/>
			<label for="<?php echo $this->get_field_id('show_title'); ?>">显示文章标题</label>
		</p>
		
		<p>
			<input name="<?php echo $this->get_field_name('show_admin'); ?>" type="hidden" value="0" />
			<input id="<?php echo $this->get_field_id('show_admin'); ?>" name="<?php echo $this->get_field_name('show_admin'); ?>" type="checkbox" value="1" <?php if ($show_admin) echo 'checked="checked" '?>/>
			<label for="<?php echo $this->get_field_id('show_admin'); ?>">显示管理员评论</label>
		</p>
		
		<p><label for="<?php echo $this->get_field_id('number'); ?>"><?php _e('Number of comments to show:'); ?></label>
		<input id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="text" value="<?php echo $number; ?>" size="3" /></p>
		
		
		<p><label for="<?php echo $this->get_field_id('excerpt_length'); ?>">引文字数(中文)：</label>
		<input id="<?php echo $this->get_field_id('excerpt_length'); ?>" name="<?php echo $this->get_field_name('excerpt_length'); ?>" type="text" value="<?php echo $excerpt_length; ?>" size="5" /></p>
<?php
	}
}

class Duoshuo_Widget_Top_Threads extends WP_Widget {

	protected $duoshuoPlugin;

	function __construct() {
		$widget_ops = array('classname' => 'ds-widget-top-threads', 'description' => '热评文章(由多说提供)');
		parent::__construct('ds-top-threads', '热评文章(多说)', $widget_ops);

		$this->alt_option_name = 'duoshuo_widget_top_threads';

		$this->duoshuoPlugin = Duoshuo_WordPress::getInstance();
	}

	function widget( $args, $instance ) {
		global $comments, $comment;

		if ( ! isset( $args['widget_id'] ) )
			$args['widget_id'] = $this->id;

		extract($args, EXTR_SKIP);
			
		$output = '';
		$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? __( 'Recent Comments' ) : $instance['title'], $instance, $this->id_base );

		if ( empty( $instance['number'] ) || ! $number = absint( $instance['number'] ) )
			$number = 5;

		$output .= $before_widget;
		if ( $title )
			$output .= $before_title . $title . $after_title;

		$data = array(
			'num_items'	=>	$number,
			'range'		=>	isset($instance['range']) ? $instance['range'] : 'weekly',
			//'show_avatars'=>isset($instance['show_avatars']) ? $instance['show_avatars'] : 1,
			//'avatar_size'=>	32,
		);
		$attribs = '';
		foreach ($data as $key => $value)
			$attribs .= ' data-' . str_replace('_','-',$key) . '="' . esc_attr($value) . '"';
		$output .= '<ul class="ds-top-threads"' . $attribs . '></ul>'
				. $after_widget;
		echo $output;?>
<script>
if (typeof DUOSHUO !== 'undefined')
	DUOSHUO.TopThreads && DUOSHUO.TopThreads('.ds-top-threads');
</script><?php 
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['range'] = $new_instance['range'];
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['number'] = absint( $new_instance['number'] );
		//$instance['show_avatars'] =  absint( $new_instance['show_avatars'] );
	
		$alloptions = wp_cache_get( 'alloptions', 'options' );
		if ( isset($alloptions['duoshuo_widget_top_threads']) )
			delete_option('duoshuo_widget_top_threads');

		return $instance;
	}
	
	function form( $instance ) {
		$title = isset($instance['title']) ? esc_attr($instance['title']) : '';
		$range = isset($instance['range']) ? esc_attr($instance['range']) : 'weekly';
		$number = isset($instance['number']) ? absint($instance['number']) : 5;
		//$show_avatars = isset($instance['show_avatars']) ? absint( $instance['show_avatars']) : 1;
?>
		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></p>

		<p>
			<label><input name="<?php echo $this->get_field_name('range'); ?>" type="radio" value="daily" <?php if ($range == 'daily') echo 'checked="checked" '?>/>24小时内</label>
			<label><input name="<?php echo $this->get_field_name('range'); ?>" type="radio" value="weekly" <?php if ($range == 'weekly') echo 'checked="checked" '?>/>7天内</label>
			<label><input name="<?php echo $this->get_field_name('range'); ?>" type="radio" value="monthly" <?php if ($range == 'monthly') echo 'checked="checked" '?>/>30天内</label>
		</p>
		<!-- 
		<p>
			<input name="<?php echo $this->get_field_name('show_avatars'); ?>" type="hidden" value="0" />
			<input id="<?php echo $this->get_field_id('show_avatars'); ?>" name="<?php echo $this->get_field_name('show_avatars'); ?>" type="checkbox" value="1" <?php if ($show_avatars) echo 'checked="checked" '?>/>
			<label for="<?php echo $this->get_field_id('show_avatars'); ?>">显示头像</label>
		</p>
		 -->
		<p><label for="<?php echo $this->get_field_id('number'); ?>"><?php _e('Number of posts to show:'); ?></label>
		<input id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="text" value="<?php echo $number; ?>" size="3" /></p>
<?php
	}
}

class Duoshuo_Widget_Recent_Visitors extends WP_Widget {
	
	function __construct() {
		$widget_ops = array('classname' => 'ds-widget-recent-visitors', 'description' => '最近访客(由多说提供)' );
		parent::__construct('ds-recent-visitors', '最近访客(多说)', $widget_ops);
		
		$this->alt_option_name = 'duoshuo_widget_recent_visitors';

		if ( is_active_widget(false, false, $this->id_base) )
			add_action( 'wp_head', array(&$this, 'printScripts') );

		//add_action( 'comment_post', array(&$this, 'flush_widget_cache') );
		//add_action( 'transition_comment_status', array(&$this, 'flush_widget_cache') );
	}

	function printScripts() {
		if ( ! current_theme_supports( 'widgets' ) )// Temp hack #14876
			return;
		
		if (!did_action('wp_head')){
			$this->duoshuoPlugin->printScripts();
		}
	}
	
	function widget( $args, $instance ) {
		global $comments, $comment;

		if ( ! isset( $args['widget_id'] ) )
			$args['widget_id'] = $this->id;

 		extract($args, EXTR_SKIP);
 		
 		$output = '';
 		$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '最近访客' : $instance['title'], $instance, $this->id_base );

		if ( empty( $instance['number'] ) || ! $number = absint( $instance['number'] ) )
 			$number = 15;

		$output .= $before_widget;
		if ( $title )
			$output .= $before_title . $title . $after_title;
		
		$data = array(
			'num_items'	=>	$number,
			'show_time'=>	isset($instance['show_time']) ? $instance['show_time'] : 1,
			'avatar_size'=>	50,
		);
		$attribs = '';
		foreach ($data as $key => $value)
			$attribs .= ' data-' . str_replace('_','-',$key) . '="' . esc_attr($value) . '"';
		$output .= '<ul class="ds-recent-visitors"' . $attribs . '></ul>'
				. $after_widget;
		echo $output;?>
<script>
if (typeof DUOSHUO !== 'undefined')
	DUOSHUO.RecentVisitors('.ds-recent-visitors');
</script><?php 
	}


	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['number'] = absint( $new_instance['number'] );
		$instance['show_time'] =  absint( $new_instance['show_time'] );
		
		$alloptions = wp_cache_get( 'alloptions', 'options' );
		if ( isset($alloptions['duoshuo_widget_recent_visitors']) )
			delete_option('duoshuo_widget_recent_visitors');

		return $instance;
	}
	
	function form( $instance ) {
		$title = isset($instance['title']) ? esc_attr($instance['title']) : '';
		$number = isset($instance['number']) ? absint($instance['number']) : 15;
		$show_time = isset($instance['show_time']) ? absint($instance['show_time']) : 1;
?>
		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></p>

		<!-- p>
			<input name="<?php echo $this->get_field_name('show_time'); ?>" type="hidden" value="0" />
			<input id="<?php echo $this->get_field_id('show_time'); ?>" name="<?php echo $this->get_field_name('show_time'); ?>" type="checkbox" value="1" <?php if ($show_time) echo 'checked="checked" '?>/>
			<label for="<?php echo $this->get_field_id('show_time'); ?>">显示访问时间</label>
		</p -->
		
		<p><label for="<?php echo $this->get_field_id('number'); ?>">显示访客的数量：</label>
		<input id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="text" value="<?php echo $number; ?>" size="3" /></p>
<?php
	}
}


class Duoshuo_Widget_Qqt_Follow extends WP_Widget {
	
	function __construct() {
		$widget_ops = array('classname' => 'ds-widget-qqt-follow', 'description' => '腾讯微博-收听组件(由多说提供)' );
		parent::__construct('ds-qqt-follow', '腾讯微博-收听(多说)', $widget_ops);
		
		$this->alt_option_name = 'duoshuo_widget_qqt_follow';
		
	}
	
	function widget( $args, $instance ) {

		if ( ! isset( $args['widget_id'] ) )
			$args['widget_id'] = $this->id;

 		extract($args, EXTR_SKIP);
 		
 		$output = $before_widget;
 		
 		$title = apply_filters( 'widget_title', isset( $instance['title'] ) ? $instance['title'] : '', $instance, $this->id_base );

		if ( $title )
			$output .= $before_title . $title . $after_title;
		
		$params = array(
			'c'	=>	'follow',
			'a'	=>	'quick',
			'name'=>isset($instance['qqt_name']) ? $instance['qqt_name'] : 'duo-shuo',
			'style'=>isset($instance['qqt_style']) ? $instance['qqt_style'] : 1,
			't'	=>	time() . sprintf("%03d", microtime() * 1000),
			'f'	=>	isset($instance['qqt_followers']) ? $instance['qqt_followers'] : 1,
		);
		
		switch($params['style']){
			case 1:
				$width = $params['f'] ? 227 : 167;
				$height = 75;
				break;
			case 2:
				$width = $params['f'] ? 191 : 136;
				$height = 38;
				break;
			case 3:
				$width = $params['f'] ? 168 : 125;
				$height = 20;
				break;
			case 4:
				$width = $params['f'] ? 182 : 125;
				$height = 27;
				break;
			case 5:
				$width = $params['f'] ? 178 : 125;
				$height = 24;
				break;
			default:
		}
		
		$attribs = array(
			'scrolling'	=>	'no',
			'width'		=>	$width,
			'height'	=>	$height,
			'frameborder'=>	0,
			'allowtransparency'=>'true',
			'marginheight'=>0,
			'marginwidth'=>	0,
			'src'		=>	'http://follow.v.t.qq.com/index.php?' . http_build_query($params, null, '&'),
		);
		
		$output .= '<iframe '; 
		foreach ($attribs as $key => $value)
			$output .= ' ' . $key . '="' . $value . '"';
		$output .= '></iframe>' . $after_widget;
		echo $output;
	}


	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['qqt_name'] = strip_tags($new_instance['qqt_name']);
		$instance['qqt_style'] = absint( $new_instance['qqt_style'] );
		$instance['qqt_followers'] = absint( $new_instance['qqt_followers'] );
		
		$alloptions = wp_cache_get( 'alloptions', 'options' );
		if ( isset($alloptions['duoshuo_widget_qqt_follow']) )
			delete_option('duoshuo_widget_qqt_follow');

		return $instance;
	}
	
	function form( $instance ) {
		$title = isset($instance['title']) ? $instance['title'] : '';
		$qqt_name = isset($instance['qqt_name']) ? $instance['qqt_name'] : '';
		$qqt_style = isset($instance['qqt_style']) ? absint( $instance['qqt_style']) : 1;
		$qqt_followers = isset($instance['qqt_followers']) ? absint( $instance['qqt_followers']) : 1;
?>
		<p><label for="<?php echo $this->get_field_id('title'); ?>">标题：</label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo esc_attr($title);?>"></p>
		<p><label for="<?php echo $this->get_field_id('qqt_name'); ?>">腾讯微博帐号 (不含@，如：duo-shuo)：</label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id('qqt_name'); ?>" name="<?php echo $this->get_field_name('qqt_name'); ?>" value="<?php echo esc_attr($qqt_name);?>"></p>
		<p><input name="<?php echo $this->get_field_name('qqt_followers'); ?>" type="hidden" value="0" />
				<input id="<?php echo $this->get_field_id('qqt_followers'); ?>" name="<?php echo $this->get_field_name('qqt_followers'); ?>" type="checkbox" value="1" <?php if ($qqt_followers) echo 'checked="checked" '?>/>
				<label for="<?php echo $this->get_field_id('qqt_followers'); ?>">显示已收听人数</label></p>
		<ul>
			<li><label><input name="<?php echo $this->get_field_name('qqt_style'); ?>" type="radio" value="1" <?php if ($qqt_style == 1) echo 'checked="checked" '?>/> 头像+收听按钮（样式丰富，更有效吸引听众）</label></li>
			<li><label><input name="<?php echo $this->get_field_name('qqt_style'); ?>" type="radio" value="2" <?php if ($qqt_style == 2) echo 'checked="checked" '?>/> 收听按钮（适合有限的展现空间）</label></li>
			<li><label><input name="<?php echo $this->get_field_name('qqt_style'); ?>" type="radio" value="3" <?php if ($qqt_style == 3) echo 'checked="checked" '?>/> 收听文字链（最简洁的状态）</label></li>
			<li><label><input name="<?php echo $this->get_field_name('qqt_style'); ?>" type="radio" value="4" <?php if ($qqt_style == 4) echo 'checked="checked" '?>/> 收听按钮（清新蓝色）</label></li>
			<li><label><input name="<?php echo $this->get_field_name('qqt_style'); ?>" type="radio" value="5" <?php if ($qqt_style == 5) echo 'checked="checked" '?>/> 收听按钮（小巧白色）</label></li>
		</ul>
<?php
	}
}
