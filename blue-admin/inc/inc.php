<?php
// multi site functions  -------------->
	if(!function_exists('switch_to_blog')){
		function switch_to_blog(){
			return true;	
		}
	}
	if(!function_exists('restore_current_blog')){
		function restore_current_blog(){
				return true;	
		}
	}
	
	function ba_main_site()
	{
		if(is_multisite() && is_super_admin()){
			if(is_main_site()){
				return true; 	
			}else{
				return false;
			}
		}else{
			return true;	
		}
	}
	function get_ba_main_blog_id()
	{
		if(ba_main_site()){
			$ps=get_current_blog_id();
		}else if(defined('BLOG_ID_CURRENT_SITE')){
			$ps=BLOG_ID_CURRENT_SITE;	
		}else{
			$ps=1;
		}
		return $ps;
	}
	
	function ba_get_option($option){
		switch_to_blog(get_ba_main_blog_id());
		$out = get_option($option);
		restore_current_blog();
		return $out;
	}

	
// Update Blue Admin settings --------------------- //
	if($_SERVER['REQUEST_METHOD'] == 'POST')
	{
		foreach (get_ba_options('settings') as $value)
		{
			if($value['settings_type']=='common')
			{
				if ( $_POST[$value['id'].'_enable']){ 
					update_option( $value['id'], '1');
					ba_redirect('','saved=true');
				}else if ( $_POST[$value['id'].'_disable']){ 
					update_option( $value['id'], '');
					ba_redirect('','saved=true');
				}
			}
		}
	}	
	


// initialize Blue admin ------------->
	function init_ba_options()
	{	
		foreach (get_ba_options('settings') as $option){
			if(get_option($option['id'])=='0' || get_option($option['id'])==''  ){
				update_option($option['id'],$option['default']);
			}
		}
		add_action('wp_head', 'ba_admin_styles');
		add_action('login_head', 'ba_admin_styles');
		add_action('admin_enqueue_scripts', 'ba_admin_styles');
		add_action('admin_enqueue_scripts','ba_pnote_admin' );	
	}
	add_action('init','init_ba_options');


// Set css styles ---------------->
	function ba_admin_styles()
	{
		if(is_admin() ||  ba_is_login_page() )	{
			wp_register_style( get_ba_options('slug'), get_ba_options('url') . 'assets/default-css/style.css','',get_ba_options('version') );
			wp_enqueue_style(get_ba_options('slug'));
		}
		if(is_user_logged_in()){
			 wp_register_style(get_ba_options('slug').'_admin_bar', get_ba_options('url'). 'assets/default-css/adminbar.css','', get_ba_options('version') );
			 wp_enqueue_style(get_ba_options('slug').'_admin_bar');
		}
	}



// Creating Custom Settings Page for Blue admin -------->
	function ba_admin_page()	{	
		if(ba_main_site()){
			add_menu_page(get_ba_options('name'),get_ba_options('name'), 'add_users', get_ba_options('slug'), 'ba_admin_page_header', get_ba_options('url').'assets/images/icon.png');
		}
	}
	add_action('admin_menu', 'ba_admin_page');



// Settings Page  -------->
	function ba_admin_page_header()	{
	?>
        <div class="wrap">
          <?php if ( $_REQUEST['saved'] ) echo '<div id="message" class="updated fade"><p><strong>'.get_ba_options('name').' settings saved.</strong></p></div>';	?>
          <?php if ( $_REQUEST['error'] ) echo '<div id="message" class="error fade"><p><strong>Something went wrong please try again.</strong></p></div>';	?>
          <h2 ><?php echo get_ba_options('name'); ?> Settings</h2>
          <h3 class="nav-tab-wrapper" style="margin: 10px 8px 0 0;"> <a href="./admin.php?page=<?php echo get_ba_options('slug');?>" class="nav-tab <?php ba_nav_tab_active(array($_GET['tab'],''));?> ">Dashboard</a> </h3>
          <div class="blue_admin_settings" style="margin:0; padding:10px">
            <?php include(get_ba_options('path').'inc/gen_form.php'); ?>
            <div style="clear:both"></div>
          </div>
        </div>
<?php 
	} 
	

// Function to display credit text in footer  -------->
	function ba_admin_footer(){
		echo '<span id="footer-thankyou">
				Thank you for creating with 
				<a href="http://wordpress.org/">WordPress</a>. 
				This admin theme developed by 
				<a href="https://lineshjose.com/">Linesh Jose</a>.
			</span>';
	}
	add_filter('admin_footer_text', 'ba_admin_footer'); 

		

// Login page validation  -------->
	function ba_is_login_page() {
		return in_array($GLOBALS['pagenow'], array('wp-login.php', 'wp-register.php'));
	}


// Checking current tab  -------->
	function ba_nav_tab_active($args=''){
		if($args[0]==$args[1]) {
			echo 'nav-tab-active';
		}else{
		}
	}


// Function for redirecting  -------->
	function ba_redirect($tab='',$action=''){
		if($tab=trim($tab)) { 
			$location=$_SERVER['PHP_SELF'].'?page=blue_admin&tab='.$tab.'&'.$action; 
		}else{
			$location= $_SERVER['PHP_SELF'].'?page=blue_admin&'.$action;
		}
		header("Location:".$location);
		die;
	}


// Settings page pointer //	
	function ba_pnote_admin()
	{
		$seen_it = explode( ',', (string) get_user_meta( get_current_user_id(), 'dismissed_wp_pointers', true ) );
		$do_add_script = false;
		if ( ! in_array( 'lj_pnote', $seen_it ) ) {
			 $do_add_script = true;
		   if ( $do_add_script && is_admin() ) 
			{
			   wp_enqueue_script( 'wp-pointer' );
			   wp_enqueue_style( 'wp-pointer' );
		   } // end if checking do_add_script
		   add_action( 'admin_print_footer_scripts', 'ba_pnote_footer'  );
		} // end if
	} // end admin_scripts()
	// Each pointer has its own function responsible for putting appropriate JavaScript into footer
	
	function ba_pnote_footer() 
	{
	   // Build the main content of your pointer balloon in a variable
	   $pointer_content = '<h3>Blue Admin</h3>'; // Title should be <h3> for proper formatting.
	   $pointer_content .= '<p>I hope you find Blue Admin useful. You should probably <a href="';
	   $pointer_content .= get_bloginfo( 'url' );
	   $pointer_content .= '/wp-admin/admin.php?page=blue_admin">check your settings</a> before using it.</p>';
		// this is not a typo -- we are dropping out of PHP but still in the function
		?><script type="text/javascript">// <![CDATA[
		jQuery(document).ready(function($) {
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
?>
