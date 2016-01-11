<?php
/*
	Plugin Name: Blue Admin
	Version: 16.01
	Plugin URI: https://lineshjose.com/projects/blue-admin/
	Description: This is a simple admin design that makes your WordPress administration section more clear and relaxed.
	Author: Linesh Jose
	Author URI: https://lineshjose.com
	License: GPL2
*/
//  Blue Admin Options ------------------->
function get_ba_options($option){
	$options= array(
					'name'=>"Blue Admin",
					'slug'=>"blue_admin", 
					'version'=>'16.01', 
					'url'=> plugin_dir_url(__FILE__),
					'path'=> plugin_dir_path(__FILE__),
					'donate'=>'http://bit.ly/donate-blue-admin',
					'support'=> 'https://lineshjose.com/projects/blue-admin/',
					'settings'=>array (	
							 		array(  
									  "name" => "Custom Adminbar Menus",
									  "desc" => "Enable or disable custom Adminbar menus. You can add your own links to WordPress adminbar or toolbar",
									  "id" => "blue_admin_adminbar",
									  "default" => '', 	
									  "input_type" => "button",
									  "settings_type"=>'common', 
									  "learn_more"=>'https://youtu.be/3vkTCEsZSfY?t=30'
									  ),
							  )
					);
	if($option=trim($option)){
		return $options[$option];
	}
}

// Adding meta links ------------------->
function ba_plugin_actions( $links, $file )
{
	$plugin = plugin_basename( get_ba_options('path').'index.php');
	if ($file == $plugin) {
		if(ba_main_site()){
	$links[] = '<a href="'.admin_url('admin.php?page='.get_ba_options('slug')).'"><span class="dashicons dashicons-admin-settings"></span>'. __('Settings',get_ba_options('slug')).'</a>';
		}
	$links[] = '<a href="'.get_ba_options('donate').'" target="_blank"><span class="dashicons dashicons-heart"></span>'. __('Donate',get_ba_options('slug')).'</a>';
	$links[] = '<a href="'.get_ba_options('support').'" target="_blank"><span class="dashicons dashicons-sos"></span>'. __('Support',get_ba_options('slug')).'</a>';
	}
	return $links;
}
add_filter( 'plugin_row_meta', 'ba_plugin_actions', 10, 2 ); 


// loading more funtions ------------->
require_once(get_ba_options('path').'./inc/inc.php');

// loading Custom Adminbar/Toolbar menus ------------->
require_once(get_ba_options('path').'./inc/cas.php');
?>