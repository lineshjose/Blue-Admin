<?php
/*
	Plugin Name: Blue Admin
	Version: 16.10
	Plugin URI: http://linesh.com/projects/blue-admin/
	Description: This is a simple admin design that makes your WordPress administration section more clear and relaxed.
	Author: Linesh Jose
	Author URI: http://linesh.com/
	License: GPL2
*/

//  Blue Admin options ------------------->
function get_ba_options($option)
{
	$options= array(
					'name'=>"Blue Admin",
					'slug'=>"blue_admin", 
					'version'=>'16.10', 
					'url'=> plugin_dir_url(__FILE__),
					'path'=> plugin_dir_path(__FILE__),
					'donate'=>'http://linesh.com/make-a-donation/',
					'support'=> 'http://linesh.com/forums/forum/plugins/blue-admin/',
					'settings'=>array (	
	
							 		'blue_admin_adminbar'=>array(  
										  "name" => "Custom Adminbar Menus",
										  "desc" => "Enable or disable custom Adminbar menus. You can add your own links to WordPress adminbar or toolbar",
										  "default" => false, 	
										  "input_type" => "button",
										  "settings_type"=>'common',
										  "settings_page"=>false,  
										  "learn_more"=>'http://bit.ly/1rCaAzf'
									  ),
									'blue_admin_login_page'=> array(  
										  "name" => 'Login Page',
										  "desc" => "You can costomize WordPress login page style here.",
										  "default" => false, 	
										  "input_type" => "button",
										  "settings_type"=>'common', 
										  "settings_page"=>true, 
										  "learn_more"=>'http://bit.ly/1Wi8iC0'
									  ),
									 'blue_admin_color_scheme'=>array(  
										  "name" =>'Color Schemes',
										  "desc" => "Enable or disable Blue Admin color schemes.",
										  "default" => false, 	
										  "input_type" => "button",
										  "settings_type"=>'common',
										  "settings_page"=>true,  
										  "learn_more"=>''
									  ),
									  
									   'blue_admin_color_scheme_val'=>array(  
										   	"default"=>'',
											"settings_type"=>'',
											"settings_page"=>false,  
										  ),
									  	  
									 'ba_lp_attr'=>  array(  
										  "default" => array(	'bg_img'=>'', 
										  						'bg_color'=>'#eee', 
																'text_color'=>'#222', 
																'bg_img_pos'=>'',
																'bg_img_rep'=>'',
																'fm_bg_color'=>'#fff',
																'fm_color'=>'#777',
																'fm_no_bg_color'=>'', 
																'no_logo'=>'',
																'logo_img'=>'', 
																'logo_url'=>get_bloginfo('url'), 
																'logo_text'=>get_bloginfo('name')
															), 	
										  "settings_type"=>'', 
										  "settings_page"=>false, 
									  ),
							  )
					);
	if($option=trim($option)){
		return $options[$option];
	}
}

// Loading funtions and settings ------------->
require_once(get_ba_options('path').'./inc/inc.php');

// Loading color scheme settings ------------->
require_once(get_ba_options('path').'./inc/color-scheme.php');

// Loading Custom Adminbar menus settings ------------->
require_once(get_ba_options('path').'./inc/cam.php');

// Loading login page customization settings ------------->
require_once(get_ba_options('path').'./inc/lp.php');
?>