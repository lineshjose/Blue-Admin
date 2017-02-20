<?php
// reset -->
/*foreach (get_ba_options('settings') as $index=>$option){
	ba_del_option($index);
}
exit;*/

// Update Blue Admin settings --------------------- //
	if($_SERVER['REQUEST_METHOD'] == 'POST')
	{
		// saving login page settings -------------->
		if(isset($_POST['ba_lp_options_save'])){
			update_option( 'ba_lp_attr', $_POST['ba_lp_attr']);
			ba_redirect('blue_admin_login_page');
			
		}else if(isset($_POST['ba_cs_options_save'])){
			update_option( 'blue_admin_color_scheme_val', $_POST['blue_admin_color_scheme_val']);
			ba_redirect('blue_admin_color_scheme');
			
		}else{
			// saving general settings -------------->
			foreach (get_ba_options('settings') as $index=>$value){
				if($value['settings_type']=='common' && ( isset($_POST[$index.'_enable']) ||  isset($_POST[$index.'_disable'])) ){
					if ( isset($_POST[$index.'_enable']) ){update_option( $index, '1');}
					else if ( isset($_POST[$index.'_disable']) ){update_option( $index, '');}
					ba_redirect();
				}
			}
		}
	}	
	


// multi-site functions  -------------->
	if(!function_exists('switch_to_blog')){
		function switch_to_blog(){return true;}
	}
	if(!function_exists('restore_current_blog')){
		function restore_current_blog(){return true;	}
	}
	function is_s_admin(){
		global $userdata;
		if(function_exists('get_super_admins') && is_multisite() ){
			if(@in_array($userdata->user_login,get_super_admins()) ){return true;}
			else{return false;}
		}else if(@in_array('administrator',$userdata->roles)  && ($userdata->caps['administrator']==1) ){return true;}
		else{return false;}
	}
	function ba_main_site(){
		if(is_multisite()){
			if(is_main_site()){return true; 	}
			else{return false;}
		}else{return true;}
	}
	function get_ba_main_blog_id(){
		if(ba_main_site()){$ps=get_current_blog_id();}
		else if(defined('BLOG_ID_CURRENT_SITE')){$ps=BLOG_ID_CURRENT_SITE;}
		else{$ps=1;}
		return $ps;
	}
	function ba_get_option($option){
		switch_to_blog(get_ba_main_blog_id());
		$out = get_option($option);
		restore_current_blog();
		return $out;
	}
	function ba_add_option($option,$value){
		switch_to_blog(get_ba_main_blog_id());
		$out = add_option($option,$value);
		restore_current_blog();
		return $out;
	}
	function ba_del_option($option){
		switch_to_blog(get_ba_main_blog_id());
		$out = delete_option($option);
		restore_current_blog();
		return $out;
	}


// Adding meta links in plugins page ------------------->
	function ba_plugin_actions( $links, $file ){
		$plugin = plugin_basename( get_ba_options('path').'index.php');
		if ($file == $plugin) 
		{
			if(ba_main_site() && is_s_admin()){
				$links[] = '<a href="'.admin_url('admin.php?page='.get_ba_options('slug')).'"><span class="dashicons dashicons-admin-settings"></span>'. __('Settings',get_ba_options('slug')).'</a>';
			}
			$links[] = '<a href="'.get_ba_options('donate').'" target="_blank"><span class="dashicons dashicons-heart"></span>'. __('Donate',get_ba_options('slug')).'</a>';
			$links[] = '<a href="'.get_ba_options('support').'" target="_blank"><span class="dashicons dashicons-sos"></span>'. __('Support',get_ba_options('slug')).'</a>';
		}
		return $links;
	}
	add_filter( 'plugin_row_meta', 'ba_plugin_actions', 10, 2 ); 


// initialize Blue admin ------------->
	function init_ba_options()
	{	
		foreach (get_ba_options('settings') as $index=>$option){
			if(!ba_add_option($index,$option['default'])){
				ba_add_option($index,$option['default']);
			}
		}
		add_action('wp_head', 'ba_admin_styles');
		add_action('login_head', 'ba_admin_styles');
		add_action('admin_enqueue_scripts', 'ba_admin_styles');
	}
	add_action('init','init_ba_options');


// Set default css styles ---------------->
	function ba_admin_styles()
	{
		// main admin css styles ---------------->
		if(is_admin() ||  ba_is_login_page() )	{
			wp_enqueue_style( get_ba_options('slug'), get_ba_options('url') . 'assets/default-css/style.css',false,get_ba_options('version'),false );
		}
		// main adminbar css styles ---------------->
		if(is_user_logged_in()){
			 wp_enqueue_style(get_ba_options('slug').'_admin_bar', get_ba_options('url'). 'assets/default-css/adminbar.css',false, get_ba_options('version'),false );
		}
		// BA page styles ---------------->
		if( is_user_logged_in() && is_admin() ){ 
			if(isset($_GET['tab']) && trim($_GET['tab'])=='blue_admin_login_page'){
				wp_enqueue_media();
				wp_enqueue_script( 'ba-color-picker', plugins_url( 'assets/js/ba-color-picker.js', __DIR__ ),'', false, true ); 
			}
    	}
	}
	
	
// Creating custom settings page for Blue Admin -------->
	function ba_admin_page_header()	{
		include(get_ba_options('path').'inc/html/header.php');
		if( isset($_GET['tab']) && ($file=trim($_GET['tab']))){
			include(get_ba_options('path').'inc/html/'.$file.'.php');
		}else{
			include(get_ba_options('path').'inc/html/general.php');
		}
		include(get_ba_options('path').'inc/html/footer.php');
	} 
	function ba_admin_page()	{	
		if(ba_main_site()  && is_s_admin()){
			add_menu_page(get_ba_options('name'),get_ba_options('name'), 'add_users', get_ba_options('slug'), 'ba_admin_page_header', get_ba_options('url').'assets/images/icon.png');
			/*foreach (get_ba_options('settings') as $index=>$value){ 
				if($value['settings_page']){
					add_submenu_page (get_ba_options('slug'), $value['name'], $value['name'], 'manage_options',get_ba_options('slug').'&tab='.$index,'ba_admin_page_header');
				}
			}*/
		}
	}
	add_action('admin_menu', 'ba_admin_page');
	

// Function to display credit text in footer  -------->
	function ba_admin_footer(){
		echo '<span id="footer-thankyou">
				Thank you for creating with <a href="http://wordpress.org/">WordPress</a>. 
				This admin theme by <a href="http://linesh.com/" target="_blank">Linesh Jose</a>.
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
		if($action==''){
			$action='saved=true';	
		}
		if($tab=trim($tab)) { 
			$location=$_SERVER['PHP_SELF'].'?page=blue_admin&tab='.$tab.'&'.$action; 
		}else{
			$location= $_SERVER['PHP_SELF'].'?page=blue_admin&'.$action;
		}
		header("Location:".$location);
		die;
	}
	

function is_enabled($index,$option=''){
	if(ba_get_option($index)=='1' ){
		return true;
	}else{
		return false;
	}
}

// add plugin upgrade notification
add_action('in_plugin_update_message-blue-admin/index.php', 'showUpgradeNotification', 10, 2);
function showUpgradeNotification($currentPluginMetadata, $newPluginMetadata){
   // check "upgrade_notice"
   if (isset($newPluginMetadata->upgrade_notice) && strlen(trim($newPluginMetadata->upgrade_notice)) > 0){
        echo '<p style="background-color: #d54e21; padding: 10px; color: #f9f9f9; margin-top: 10px"><strong>Important Upgrade Notice: </strong>';
        echo esc_html($newPluginMetadata->upgrade_notice), '</p>';
   }
}
?>