<?php


/************************************** Plugin setup *****************************************************************/	
	
	/*delete_option($wp_lj_plugin['slug'].'_active');
	delete_option($wp_lj_plugin['slug'].'_bg_image');
	delete_option($wp_lj_plugin['slug'].'_bg_color');
	delete_option($wp_lj_plugin['slug'].'_bg_position');*/
	
	/*if(is_admin())
	{
		echo $wp_lj_plugin['slug'];
		echo get_option($wp_lj_plugin['slug'].'_active');
		echo get_option($wp_lj_plugin['slug'].'_bg_image');
		echo get_option($wp_lj_plugin['slug'].'_bg_color');
		echo get_option($wp_lj_plugin['slug'].'_bg_position');
	}*/
	
	if (!isset($directory)){
		$directory = ABSPATH. "wp-content/uploads/";
	}
	
	if (!isset($lj_options)) {
		$lj_options = array (	
							
							
							array(  
							"name" => "Custom Adminbar Menus","desc" => "Enable or disable custom Adminbar menus. You can add your own links to WordPress adminbar or toolbar","id" => $wp_lj_plugin['slug']."_adminbar",
							"default" => '', 	"input_type" => "button",	"settings_type"=>'common', "learn_more"=>'#'),
						);
	}



	// Set all default options
	if(!function_exists('lj_add_options'))
	{
		function lj_add_options()
		{	
			global $lj_options;
			foreach ($lj_options as $option){
			if(get_option($option['id'])=='0' || get_option($option['id'])==''  ){update_option($option['id'],$option['default']);}}
			
			add_action('admin_enqueue_scripts', 'lj_admin_styles');
			add_action('login_head', 'lj_admin_styles');
			add_action('wp_head', 'lj_admin_styles');
			add_action( 'admin_enqueue_scripts','lj_pnote_admin' );	
		}
		add_action('init','lj_add_options');
	}
	
	
	// Function to set default css style//
	if(!function_exists('lj_admin_styles'))	
	{
		function lj_admin_styles()
		{
			global $wp_lj_plugin, $wp_version;
			if(is_admin() || lj_is_login_page()){
			
				if($wp_version>='3.5'){
					wp_register_style( $wp_lj_plugin['slug'], $wp_lj_plugin['url'] . 'inc/default-style.css','',$wp_lj_plugin['version'] );
				}else{
					wp_register_style( $wp_lj_plugin['slug'], $wp_lj_plugin['url'] . 'inc/old-default-style.css','',$wp_lj_plugin['version'] );	
				}
				
				if(is_admin()){
					wp_enqueue_script(  $wp_lj_plugin['slug'], $wp_lj_plugin['url'] . 'inc/script/jscolor.js','',$wp_lj_plugin['version'] );
				}
			}
			if(is_user_logged_in()){
				wp_register_style( $wp_lj_plugin['slug'].'_admin_bar', $wp_lj_plugin['url']. 'inc/default-adminbar.css','', $wp_lj_plugin['version'] );
			}
			 wp_enqueue_style( $wp_lj_plugin['slug']);
			 wp_enqueue_style($wp_lj_plugin['slug'].'_admin_bar');
		}
		
	}
	
	
	// Creating Custom Settings Page //
	if(!function_exists('lj_bd_admin'))
	{
			function lj_bd_admin()
			{	
				global $wp_lj_plugin;
				add_menu_page($wp_lj_plugin['name'],$wp_lj_plugin['name'], 'add_users', $wp_lj_plugin['slug'], 'lj_bd_admin_header',$wp_lj_plugin['url'].'/inc/images/trans.png');
			}
			add_action('admin_menu', 'lj_bd_admin');
	}
	
	
	// Settings page pointer //	
	if (!function_exists(lj_pnote_admin))
	{	
		function lj_pnote_admin()
		{
			// find out which pointer IDs this user has already seen
			 $seen_it = explode( ',', (string) get_user_meta( get_current_user_id(), 'dismissed_wp_pointers', true ) );
			//print_r($seen_it);
			// at first assume we don't want to show pointers
			$do_add_script = false;
			// Handle our first pointer announcing the plugin's new settings screen.
			// check for dismissal of pksimplenote settings menu pointer 'pksn1'
			if ( ! in_array( 'lj_pnote', $seen_it ) ) {
			   // flip the flag enabling pointer scripts and styles to be added later
			   $do_add_script = true;
			   // hook to function that will output pointer script just for pksn1
			   if ( $do_add_script && is_admin() ) 
				{
					// add JavaScript for WP Pointers
				   wp_enqueue_script( 'wp-pointer' );
				   // add CSS for WP Pointers
				   wp_enqueue_style( 'wp-pointer' );
			   } // end if checking do_add_script
			   add_action( 'admin_print_footer_scripts', 'lj_pnote_footer'  );
			} // end if
		} // end admin_scripts()
		// Each pointer has its own function responsible for putting appropriate JavaScript into footer
		
		function lj_pnote_footer() 
		{
		   // Build the main content of your pointer balloon in a variable
		   $pointer_content = '<h3>Blue Admin</h3>'; // Title should be <h3> for proper formatting.
		   $pointer_content .= '<p>I hope you find Blue Admin useful. You should probably <a href="';
		   $pointer_content .= get_bloginfo( 'url' );
		   $pointer_content .= '/wp-admin/admin.php?page=blue_admin">check your settings</a> before using it.</p>';
			// this is not a typo -- we are dropping out of PHP but still in the function
			?><script type="text/javascript">// <![CDATA[
			jQuery(document).ready(function($) {
				/* make sure pointers will actually work and have content */
				if(typeof(jQuery().pointer) != 'undefined') {
					$('#toplevel_page_blue_admin').pointer({
						content: '<?php echo $pointer_content; ?>',
						 position: {
							at: 'left bottom',
							my: 'left top'
						},
						close: function() {
							$.post( ajaxurl, {
								pointer: 'lj_pnote',
								action: 'dismiss-wp-pointer'
							});
						}
					}).pointer('open');
				}
			});
			// ]]></script>
				<?php
		} // end footer_script()
	}
	
	
	// Function to display credit text in footer//
	if(!function_exists('lj_admin_footer'))	
	{
		function lj_admin_footer(){
			echo '<span id="footer-thankyou">Thank you for creating with <a href="http://wordpress.org/">WordPress</a>.</span>
				<span id="footer-thankyou">This theme developed by <a href="http://lineshjose.com/">Linesh Jose</a>.</span>';
		}
		add_filter('admin_footer_text', 'lj_admin_footer'); 
	}
	
/********************************************************************************************************************************************/	
			
			
			
	
	// Login page validation //
	if(!function_exists('lj_is_login_page'))
	{
		function lj_is_login_page() {
		return in_array($GLOBALS['pagenow'], array('wp-login.php', 'wp-register.php'));
		}
	}
	
	
				
	// Checking curretn tab //
	if(!function_exists('lj_nav_tab_active'))
	{
		function lj_nav_tab_active($args='') {	if($args[0]==$args[1]) echo 'nav-tab-active';}
	}
	
	
      
	// Function for redirecting //
	if(!function_exists('lj_redirect'))	
	{
		function lj_redirect($tab='',$action='')
		{
			if($tab) { $location=$_SERVER['PHP_SELF'].'?page=blue_admin&tab='.$tab.'&'.$action; }
			else{$location= $_SERVER['PHP_SELF'].'?page=blue_admin&'.$action;}
			header("Location: $location");
			die;
		}
	}	
	
	
	// Adding Custom Adminbar/Toolbar menus feature //
	if(get_settings('blue_admin_adminbar') =='1')
	{
		if ( version_compare( $wp_version, '3.3', '>' ) )
		{
				
			if (function_exists('register_nav_menus'))
			{
				if(!function_exists(lj_adminbar_menus))
				{
					function lj_adminbar_menus() {
						register_nav_menus(	array('lj_adminbar_menus' => __( 'Adminbar Menu','lj' )));
					}
					add_action( 'init', 'lj_adminbar_menus' );
				}
			}	
					
	
			if(!function_exists(lj_custom_adminbar_menus))
			{
				// To add custom links to adminbar //
				function lj_custom_adminbar_menus() 
				{
					global $wp_admin_bar;
					 $menu_name = 'lj_adminbar_menus';
					 if ( ( $locations = get_nav_menu_locations() ) && isset( $locations[ $menu_name ] ) )
					 {
						$menu = wp_get_nav_menu_object( $locations[ $menu_name ] );
						$menu_items = wp_get_nav_menu_items($menu->term_id);
			
						foreach ( (array) $menu_items as $key => $menu_item )
						{
								if($menu_item->classes){$clasess=implode(' ',$menu_item->classes);} else{$clasess="";}
								$meta=array('class' =>$clasess , 'onclick' => '', target => $menu_item->target, title =>$menu_item->attr_title);
								//print_r($menu_items);
								if ($menu_item->menu_item_parent) 
								{ 
									$wp_admin_bar->add_menu( array(
									'id' => $menu_item->ID,
									'parent' => $menu_item->menu_item_parent, 
									'title' => $menu_item->title,
									'href' => $menu_item->url,
									'meta' =>  $meta ) );
									
								}
								else
								{
									$wp_admin_bar->add_menu( array(
									'id' => $menu_item->ID,
									'title' => $menu_item->title,
									'href' => $menu_item->url,
									'meta' =>  $meta ) );
								}
						}
					}
				}
				add_action( 'wp_before_admin_bar_render', 'lj_custom_adminbar_menus' );
				}
		}
		else
		{	// Shows as an error message. You could add a link to the right page if you wanted.
				function bd_error()
				{
					echo '<div id="message" class="error fade"><p><strong>'.$lj_bd_plugin['name'].'</strong> plugin\'s <strong>Custom Adminbar Menus</strong> feature is only compatible for <strong>WordPress 3.3</strong> or above versions. Please <strong><a href="./update-core.php">Update your WordPress</a></strong> now</strong></p></div>';
				}	
				add_action('admin_notices', 'bd_error');	
		}
	}	
?>