<?php
/*
Plugin Name: Raadso Like Button
Plugin URI: http://raadso.so/downloads/raadso-like.zip
Description: Raadso Like Button is an easy plugin which let's you add Raadso Like to your website | Fadlan degso Raadso like oo ah Social ay Somalidu adeegsato maanta mahadsanid Version: 1.6.0
Author: OmarTeacher
Author URI: http://raadso.so/
License: GPL3
*/

/*  Copyright 2013 OmarTeacher (omarteacher@gmail.com)

    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/

if (!defined('rd_LIKE_INIT')) define('rd_LIKE_INIT', 1);
else return;

$rd_like_settings = array();

$rd_like_layouts        = array('standard', 'button_count', 'box_count');
$rd_like_verbs          = array('like', 'recommend');
$rd_like_colorschemes   = array('light', 'dark');
$rd_like_font           = array('', 'arial', 'lucida grande', 'segoe ui', 'tahoma', 'trebuchet ms', 'verdana');

$defaultappid = 258570960199805;

function rd_register_like_settings() {
	register_setting('rd_like', 'rd_like_width');
	register_setting('rd_like', 'rd_like_layout');
	register_setting('rd_like', 'rd_like_showfaces');
	register_setting('rd_like', 'rd_like_verb');
	register_setting('rd_like', 'rd_like_colorscheme');
	register_setting('rd_like', 'rd_like_font');
	register_setting('rd_like', 'rd_like_valid');
	register_setting('rd_like', 'rd_like_xfbml');
	register_setting('rd_like', 'rd_like_google1');
	register_setting('rd_like', 'rd_like_opengraph');
	register_setting('rd_like', 'rd_like_defaultpic');
	register_setting('rd_like', 'rd_like_appid');
	register_setting('rd_like', 'rd_like_send');
	register_setting('rd_like', 'rd_like_show_at_top');
	register_setting('rd_like', 'rd_like_show_at_bottom');
	register_setting('rd_like', 'rd_like_show_on_page');
	register_setting('rd_like', 'rd_like_show_on_post');
	register_setting('rd_like', 'rd_like_show_on_home');
	register_setting('rd_like', 'rd_like_show_on_search');
	register_setting('rd_like', 'rd_like_show_on_archive');
	register_setting('rd_like', 'rd_like_margin_top');
	register_setting('rd_like', 'rd_like_margin_bottom');
	register_setting('rd_like', 'rd_like_margin_left');
	register_setting('rd_like', 'rd_like_margin_right');
	register_setting('rd_like', 'rd_like_excl_post');
	register_setting('rd_like', 'rd_like_excl_cat');
	register_setting('rd_like', 'rd_like_css_style');
}

function rd_like_init()
{
    global $rd_like_settings;

	if ( is_admin() )
		add_action( 'admin_init', 'rd_register_like_settings' );

	add_filter('the_content', 'rd_like_button');
	add_filter('admin_menu', 'rd_like_admin_menu');
	add_filter('widget_text', 'do_shortcode');
	add_action('widgets_init', create_function('', 'return register_widget("rd_like_widget");'));
	
	add_option('rd_like_width', '450');
	add_option('rd_like_layout', 'standard');
	add_option('rd_like_showfaces', 'true');
	add_option('rd_like_verb', 'like');
	add_option('rd_like_font', '');
	add_option('rd_like_colorscheme', 'light');
	add_option('rd_like_valid', 'false');
	add_option('rd_like_opengraph', 'true');
	add_option('rd_like_defaultpic', WP_PLUGIN_URL.'/'.str_replace(basename( __FILE__),"",plugin_basename(__FILE__)) . 'images/raadso.png');
	add_option('rd_like_xfbml', 'true');
	add_option('rd_like_google1', 'false');
	add_option('rd_like_appid', '');
	add_option('rd_like_send', 'false');
	add_option('rd_like_show_at_top', 'false');
	add_option('rd_like_show_at_bottom', 'true');
	add_option('rd_like_show_on_page', 'false');
	add_option('rd_like_show_on_post', 'true');
	add_option('rd_like_show_on_home', 'false');
	add_option('rd_like_show_on_search', 'false');
	add_option('rd_like_show_on_archive', 'false');
	add_option('rd_like_margin_top', '0');
	add_option('rd_like_margin_bottom', '0');
	add_option('rd_like_margin_left', '0');
	add_option('rd_like_margin_right', '0');
	add_option('rd_like_excl_post', '');	
	add_option('rd_like_excl_cat', '');	
	add_option('rd_like_css_style', '');

	$rd_like_settings['width'] = get_option('rd_like_width');
	$rd_like_settings['layout'] = get_option('rd_like_layout');
	$rd_like_settings['showfaces'] = get_option('rd_like_showfaces') === 'true';
	$rd_like_settings['verb'] = get_option('rd_like_verb');
	$rd_like_settings['font'] = get_option('rd_like_font');
	$rd_like_settings['colorscheme'] = get_option('rd_like_colorscheme');
	$rd_like_settings['valid'] = get_option('rd_like_valid') === 'true';
	$rd_like_settings['opengraph'] = get_option('rd_like_opengraph') === 'true';
	$rd_like_settings['defaultpic'] = get_option('rd_like_defaultpic');
	$rd_like_settings['xfbml'] = get_option('rd_like_xfbml') === 'true';
	$rd_like_settings['google1'] = get_option('rd_like_google1') === 'true';
	$rd_like_settings['appid'] = get_option('rd_like_appid');
	$rd_like_settings['send'] = get_option('rd_like_send') === 'true';
	$rd_like_settings['showattop'] = get_option('rd_like_show_at_top') === 'true';
	$rd_like_settings['showatbottom'] = get_option('rd_like_show_at_bottom') === 'true';
	$rd_like_settings['showonpage'] = get_option('rd_like_show_on_page') === 'true';
	$rd_like_settings['showonpost'] = get_option('rd_like_show_on_post') === 'true';
	$rd_like_settings['showonhome'] = get_option('rd_like_show_on_home') === 'true';
	$rd_like_settings['showonsearch'] = get_option('rd_like_show_on_search') === 'true';
	$rd_like_settings['showonarchive'] = get_option('rd_like_show_on_archive') === 'true';
	$rd_like_settings['margin_top'] = get_option('rd_like_margin_top');
	$rd_like_settings['margin_bottom'] = get_option('rd_like_margin_bottom');
	$rd_like_settings['margin_left'] = get_option('rd_like_margin_left');
	$rd_like_settings['margin_right'] = get_option('rd_like_margin_right');
	$rd_like_settings['excl_post'] = get_option('rd_like_excl_post');
	$rd_like_settings['excl_cat'] = get_option('rd_like_excl_cat');
	$rd_like_settings['css_style'] = get_option('rd_like_css_style');
	
	$locale = defined(WPLANG) ? WPLANG : 'en_US';

	// 'wp_footer' is there instead of 'wp_head' because it makes better validation
	add_action('wp_footer', 'rd_like_js_sdk');

	// Google +1 JavaScripted placed in 'wp_head'. That's OK.
	add_action('wp_head', 'rd_like_google1_js');

	// Open Graph
	add_action('wp_head', 'rd_like_open_graph');

	// Shortcode [fb-like-button] linked to generate_button()
	add_shortcode('fb-like-button', 'generate_button');

    load_plugin_textdomain( 'rd_like_trans_domain', '', plugin_basename( dirname( __FILE__ ) . '/languages') );
}

function rd_like_pluginPath($file) {
	// $file without first '/'
	return WP_PLUGIN_URL . '/' . str_replace( basename( __FILE__) , "" , plugin_basename(__FILE__) ) . $file;
}

function rd_like_return_appid() {
	global $rd_like_settings, $defaultappid;
	
	$appid = trim($rd_like_settings['appid']);

	if (!$appid)
		$appid = $defaultappid;
		
	return $appid;	
}

/* Load Raadso SDK if needed */
function rd_like_js_sdk() {
	global $rd_like_settings;
	
	if($rd_like_settings['xfbml']=='true') {
	global $locale;
	
	if($rd_like_settings['valid']=='true')
		echo '	<script type="text/javascript" src="' . rd_like_pluginPath('js/fbObjectValidationV4.js') . '"></script>
';
	
	echo '	<div id="fb-root"></div>
	<script>(function(d, s, id) {
	var js, fjs = d.getElementsByTagName(s)[0];
	if (d.getElementById(id)) return;
	js = d.createElement(s); js.id = id;
	js.src = "//connect.raadso.so/' . $locale . '/all.js#xfbml=1&appId=' . rd_like_return_appid() . '";
	fjs.parentNode.insertBefore(js, fjs);
	}(document, \'script\', \'Raadso-jssdk\'));</script>
	';
	}
}

function rd_like_google1_js() {
	global $rd_like_settings;
	
	if($rd_like_settings['google1']=='true') {
		global $locale;

	echo <<<END
	<script type="text/javascript" src="https://apis.google.com/js/plusone.js">
		{lang: '$locale'}
	</script>

END;
	}
}

// URL Validation (for incomplete/relative address in Custom Field)
function rd_like_isValidURL($url) {
	$urlregex = "^(https?|ftp)\:\/\/([a-z0-9+!*(),;?&=\$_.-]+(\:[a-z0-9+!*(),;?&=\$_.-]+)?@)?[a-z0-9+\$_-]+(\.[a-z0-9+\$_-]+)*(\:[0-9]{2,5})?(\/([a-z0-9+\$_-]\.?)+)*\/?(\?[a-z+&\$_.-][a-z0-9;:@/&%=+\$_.-]*)?(#[a-z_.-][a-z0-9+\$_.-]*)?\$";
	return eregi($urlregex, $url);
}

function rd_like_catch_image() {
	global $rd_like_settings, $post, $posts;
	ob_start();
	ob_end_clean();
	
	// Default picture if is NOT post or page
	if (!is_single() && !is_page())
		return $rd_like_settings['defaultpic'];

	// Post thumbnail supported by theme
	if (current_theme_supports('post-thumbnails'))
		if (has_post_thumbnail($post->ID)) {
			$img = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'medium' );
			return esc_attr($img[0]);
		}
	
	// Custom Fields
	$cf_thumb_values = get_post_custom_values('thumb');
	if (!empty($cf_thumb_values))
		$img = $cf_thumb_values[0];
	$cf_thumbnail_values = get_post_custom_values('thumbnail');
	if (!empty($cf_thumbnail_values))
		$img = $cf_thumbnail_values[0];

	if (!empty($img))
		if (rd_like_isValidURL($img))
			return $img;
		else {
			$upload_dir = wp_upload_dir();
			$img = $upload_dir['baseurl'] . '/' . $img;
			if (rd_like_isValidURL($img))
				return $img;
		}

	// First picture in the post
	$output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);
	$img = $matches[1][0];
	
	//Default picture
	if (empty($img))
		$img = $rd_like_settings['defaultpic'];
		
	return $img;
}

function rd_like_open_graph() {
	global $rd_like_settings, $defaultappid;
	
	if($rd_like_settings['opengraph']=='true') {
		?>
		<?php if (!is_single() && !is_page()) 
			echo '<meta property="og:title" content="' . get_bloginfo('name') . '"/>
		<meta property="og:type" content="blog"/>
		<meta property="og:url" content="' . get_bloginfo("home") . '"/>
';
			else echo '<meta property="og:title" content="' . wp_title('', false) . ' &laquo; ' . get_bloginfo('name') .'"/>
		<meta property="og:type" content="article"/>
		<meta property="og:url" content="' . get_permalink() . '"/>
'; ?>
		
<head>
		<meta property="og:image" content="<?php echo rd_like_catch_image() ?>"/>
		<meta property="og:site_name" content="<?php bloginfo('name') ?>"/>
		<?php if (!empty($rd_like_settings['appid']) && rd_like_return_appid()!=$defaultappid)
	    echo '<meta property="fb:app_id" content="' . rd_like_return_appid() . '"/>';
	}
}

/* Show the button */
function rd_like_button($content) {
    global $rd_like_settings;

    if (is_feed()) return $content;

    if(is_single() && !$rd_like_settings['showonpost'])
		return $content;

    if(is_page() && !$rd_like_settings['showonpage'])
		return $content;

    if(is_front_page() && !$rd_like_settings['showonhome'])
		return $content;

    if(is_search() && !$rd_like_settings['showonsearch'])
		return $content;

    if(is_archive() && !$rd_like_settings['showonarchive'])
		return $content;
	
	/* Exclude posts and pages */
	if(trim($rd_like_settings['excl_post'])!='') {
		$excl_post_array = explode(",", $rd_like_settings['excl_post']);
		for ( $i = 0; $i < count($excl_post_array); $i++ ) {
			$excl_post_array[$i] = trim($excl_post_array[$i]);
			if(is_single($excl_post_array[$i])==true or is_page($excl_post_array[$i])==true)
				return $content;
		}	
	}
	
	/* Exclude categories */
	if(trim($rd_like_settings['excl_cat'])!='') {	
		$excl_cat_array = explode(",", $rd_like_settings['excl_cat']);	
		for ( $i = 0; $i < count($excl_cat_array); $i++ ) {
			$excl_cat_array[$i] = trim($excl_cat_array[$i]);
			if(in_category($excl_cat_array[$i])==true)
				return $content;
		}
	}
 
    /* Show the button where user wants to */
    if($rd_like_settings['showattop']=='true')
		$content = generate_button() . $content;

    if($rd_like_settings['showatbottom']=='true')
	    $content .= generate_button();
	    
	return $content;
}

function rd_like_count_margin() {
	global $rd_like_settings;

	return $rd_like_settings['margin_top'] . 'px '
		. $rd_like_settings['margin_right'] . 'px ' 
		. $rd_like_settings['margin_bottom'] . 'px '
		. $rd_like_settings['margin_left'] . 'px';
}

/* Generate code for Google +1 Button. Nothing more. */
function rd_like_generate_google1() {
	global $rd_like_settings;
	
	if($rd_like_settings['google1']=='true') {
		switch($rd_like_settings['layout']) {
			case "standard":
				return '<div style="float: right; margin: ' . rd_like_count_margin() . '"><g:plusone href="' . get_permalink() . '"></g:plusone></div>';
				break;					
			case "button_count":
				return '<div style="float: right; margin: ' . rd_like_count_margin() . '"><g:plusone size="medium" href="' . get_permalink() . '"></g:plusone></div>';
				break;
			case "box_count":
				return '<div style="float: right; margin: ' . rd_like_count_margin() . '"><g:plusone size="tall" href="' . get_permalink() . '"></g:plusone></div>';
				break;
		}
	}
}

/* Return button's body (to rd_like_button() and shortcode [fb-like-button]) */
function generate_button() {
	global $rd_like_settings;
	
	$margin = rd_like_count_margin();

	if($rd_like_settings['xfbml']) {
		/* XFBML VERSION */
		global $locale;
		
		$rdlike = '<iframe src="http://www.raadso.so/geturl.php" width="100" 

height="21" scrolling="no" name="Raadso" border="0" frameborder="0"></iframe>';
		
		if ($rd_like_settings['valid'])
			return '
	<span class="fbreplace">
	<!-- FBML ' . $rdlike . ' FBML -->
	</span>
	' . rd_like_generate_google1() . '
'; else return  $rdlike . rd_like_generate_google1();
		/* END OF XFBML VERSION */
	}
	else {
		/* STANDARD (NON-XFBML) VERSION */	
		switch($rd_like_settings['layout']) {
			case "standard":
				$height = (($rd_like_settings['showfaces']=='true')?80:35);
				break;
			case "button_count":
				$height = 21;
				break;
			case "box_count":
				$height = 65;
				break;
		}

		return '<iframe class="rdlikes" src="http://www.raadso.so/plugins/like.php?href=' . get_permalink() . '&amp;send=false&amp;layout=' . $rd_like_settings['layout'] . '&amp;width=' . $rd_like_settings['width'] . '&amp;show_faces=' . (($rd_like_settings['showfaces']=='true')?'true':'false') . '&amp;action=' . $rd_like_settings['verb'] . '&amp;colorscheme=' . $rd_like_settings['colorscheme'] . '&amp;' . (($rd_like_settings['font']!='') ? 'font='. $rd_like_settings['font'] : 'font') . '&amp;height=' . $height . '" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:' . $rd_like_settings['width'] . 'px; height:' . $height . 'px; margin: ' . $margin . ';' . (($rd_like_settings['css_style']!='') ? ' ' . $rd_like_settings['css_style'] : '') . '" allowTransparency="true"></iframe>' . rd_like_generate_google1();
		/* END OF STANDARD (NON-XFBML) VERSION */
	}
}

/* Widget Raadso Like Box */
class rd_like_widget extends WP_Widget {
    /** constructor */
    function rd_like_widget() {
        parent::WP_Widget(false, $name = 'Raadso Like Box');	
    }

    /** @see WP_Widget::widget */
    function widget($args, $instance) {		
    	global $rd_like_settings;
    	
        extract( $args );
        $title     = apply_filters('fly-fb-likebox', $instance['rd_likebox_title']);
        $url       = apply_filters('fly-fb-likebox', $instance['rd_likebox_url']);
        $width     = apply_filters('fly-fb-likebox', $instance['rd_likebox_width']);
        $showfaces = $instance['rd_likebox_showfaces'];
        $stream    = $instance['rd_likebox_stream'];
        $header    = $instance['rd_likebox_header'];
        
        echo $before_widget;
         
        if ( $title )
        	echo $before_title . $title . $after_title;
                  
        if($rd_like_settings['xfbml']) {
        	/* XFBML VERSION OF LIKE BOX */
			$rdlikebox = '<div class="fb-like-box" data-href="' . $url . '" data-width="' . $width . '"' . ($rd_like_settings['colorscheme']=="dark" ? ' data-colorscheme="dark"' : '') . ' data-show-faces="' . ($showfaces ? 'true' : 'false') . '" data-stream="' . ($stream ? 'true' : 'false') . '" data-header="' . ($header ? 'true' : 'false') . '"></div>';
         	
         	if ($rd_like_settings['valid'])
			echo '
	<span class="fbreplace">
	<!-- FBML ' . $rdlikebox . ' FBML -->
	</span>
'; else
			echo $rdlikebox;
       	}
        else {
            /* IFRAME VERSION OF LIKE BOX */
            
            // Count height in so lame way. :X
            if ( $stream && $header && $showfaces )
            	$height = 590;
            elseif ( $stream && $header )
            	$height = 420;
            elseif ( $stream && $showfaces )
            	$height = 558;	
            elseif ( $header && $showfaces )
            	$height = 290; 	
            elseif ( $stream )
            	$height = 395;
            elseif ( $showfaces )
            	$height = 258;
            else $height = 62;	
            
			echo '<iframe src="http://www.raadso.so/plugins/likebox.php?href=' . $url . '&amp;width=' . $width . '&amp;colorscheme=' . $rd_like_settings['colorscheme'] . '&amp;show_faces=' . ($showfaces ? 'true' : 'false') . '&amp;border_color&amp;stream=' . ($stream ? 'true' : 'false') . '&amp;header=' . ($header ? 'true' : 'false') . '&amp;height=' . $height . '" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:' . $width . 'px; height:' . $height . 'px;" allowTransparency="true"></iframe>';
        }
         	
       		echo $after_widget;
    }

    /** @see WP_Widget::update */
    function update($new_instance, $old_instance) {				
		$instance = $old_instance;
		$instance['rd_likebox_title']     = strip_tags($new_instance['rd_likebox_title']);
		$instance['rd_likebox_url']       = strip_tags($new_instance['rd_likebox_url']);
		$instance['rd_likebox_width']     = strip_tags($new_instance['rd_likebox_width']);
		$instance['rd_likebox_showfaces'] = (isset($new_instance['rd_likebox_showfaces']) ? 1 : 0);
		$instance['rd_likebox_stream']    = (isset($new_instance['rd_likebox_stream']) ? 1 : 0);
		$instance['rd_likebox_header']    = (isset($new_instance['rd_likebox_header']) ? 1 : 0);
	
        return $instance;
    }

    /** @see WP_Widget::form */
    function form($instance) {	
    
    	global $rd_like_settings;
    	
    	/* Some default widget settings */
		$defaults = array( 'rd_likebox_width' => 292,
		                   'rd_likebox_height' => 427,
		                   'rd_likebox_stream' => 1,
		                   'rd_likebox_header' => 1 );
						   
		$instance = wp_parse_args( (array) $instance, $defaults );
    			
        $title     = esc_attr($instance['rd_likebox_title']);
        $url       = esc_attr($instance['rd_likebox_url']);
        $width     = esc_attr($instance['rd_likebox_width']);
        $showfaces = isset($instance['rd_likebox_showfaces']) ? 1 : 0;
        $stream    = isset($instance['rd_likebox_stream']) ? 1 : 0;
        $header    = isset($instance['rd_likebox_header']) ? 1 : 0;
        
        ?>
            </head>

            <p><label for="<?php echo $this->get_field_id('rd_likebox_title'); ?>"><?php _e("Title:", 'rd_like_trans_domain' ); ?> <input class="widefat" id="<?php echo $this->get_field_id('rd_likebox_title'); ?>" name="<?php echo $this->get_field_name('rd_likebox_title'); ?>" type="text" value="<?php echo $title; ?>" /></label></p>

            <p><label for="<?php echo $this->get_field_id('rd_likebox_url'); ?>"><?php _e("Raadso Page URL:", 'rd_like_trans_domain' ); ?> <input class="widefat" id="<?php echo $this->get_field_id('rd_likebox_url'); ?>" name="<?php echo $this->get_field_name('rd_likebox_url'); ?>" type="text" value="<?php echo $url; ?>" /></label><br /><small><?php _e("The URL of the FB Page for this Like box.", 'rd_like_trans_domain' ); ?></small></p>

            <p><label for="<?php echo $this->get_field_id('rd_likebox_width'); ?>"><?php _e("Width:", 'rd_like_trans_domain' ); ?> <input class="widefat" id="<?php echo $this->get_field_id('rd_likebox_width'); ?>" name="<?php echo $this->get_field_name('rd_likebox_width'); ?>" type="number" value="<?php echo $width; ?>" /></label><br /><small><?php _e("The width of the widget in pixels.", 'rd_like_trans_domain' ); ?></small></p>

            <p><input class="checkbox" type="checkbox" <?php checked( (bool) $instance['rd_likebox_showfaces'], true ); ?> id="<?php echo $this->get_field_id( 'rd_likebox_showfaces' ); ?>" name="<?php echo $this->get_field_name( 'rd_likebox_showfaces' ); ?>" /><label for="<?php echo $this->get_field_id( 'rd_likebox_showfaces' ); ?>">&nbsp;<?php _e("Show Faces", 'rd_like_trans_domain' ); ?></label></p>

            <p><input class="checkbox" type="checkbox" <?php checked( (bool) $instance['rd_likebox_stream'], true ); ?> id="<?php echo $this->get_field_id( 'rd_likebox_stream' ); ?>" name="<?php echo $this->get_field_name( 'rd_likebox_stream' ); ?>" /><label for="<?php echo $this->get_field_id( 'rd_likebox_stream' ); ?>">&nbsp;<?php _e("Stream", 'rd_like_trans_domain' ); ?></label><br /><small><?php _e("Show the profile stream for the public profile.", 'rd_like_trans_domain' ); ?></small></p>

			<p><input class="checkbox" type="checkbox" <?php checked( (bool) $instance['rd_likebox_header'], true ); ?> id="<?php echo $this->get_field_id( 'rd_likebox_header' ); ?>" name="<?php echo $this->get_field_name( 'rd_likebox_header' ); ?>" /><label for="<?php echo $this->get_field_id( 'rd_likebox_header' ); ?>">&nbsp;<?php _e("Header", 'rd_like_trans_domain' ); ?></label><br /><small><?php _e("Show the 'Find us on Raadso' bar at top.<br /><small>Only when either stream or connections are present.</small>", 'rd_like_trans_domain' ); ?></small></p>

        <?php 
    }
}

/* Admin menu page linked to rd_plugin_options() */
function rd_like_admin_menu() {
    add_options_page('Raadso Like Button Options', 'Raadso Like Button', 8, __FILE__, 'rd_plugin_options');
}

function rd_plugin_options() {
    global $rd_like_layouts;
    global $rd_like_verbs;
    global $rd_like_font;
    global $rd_like_colorschemes;
    global $rd_like_aligns;
?>

    <div class="wrap">
    <h2>Raadso Like Button <small>by <a href="http://raadso.so/" target="_blank">Raadso</a></small></h2>

    <form method="post" action="options.php">

    <?php settings_fields('rd_like'); ?>
	
<table class="form-table">
        <tr valign="top">
            <th scope="row"><h3>If you liked our work like Raadso Social Page.</h3><br>

			</th>
		</tr>
    </table>
    
	<table border="0" width="378" height="108">
	<tr>
		<td height="108" width="188"><script src="http://www.raadso.so/static/socialbuttons.js"></script> <cfbutton:like cburl="http://www.raadso.so/socialbuttons/likebox/aHR0cDovL3d3dy5yYWFkc28uc28vcGFnZXMvNS8=" w="242" h="550"></cfbutton:like></td>
		<td height="108" width="174"><iframe src="//www.facebook.com/plugins/likebox.php?href=https%3A%2F%2Fwww.facebook.com%2Fpages%2FRaadso-social%2F570112133005785&width=242&height=590&show_faces=true&colorscheme=light&stream=true&show_border=true&header=true&appId=582715868425124" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:242px; height:590px;" allowTransparency="true"></iframe></td>
	</tr>
</table>
<br> No Editing Needed Here. Just Activate or Deactivate The Pluging Normaly Thanks | www.raadso.so | Developer Contact: omarteacher@gmail.com	
</form>
</div>
<?php
}

rd_like_init();
?>