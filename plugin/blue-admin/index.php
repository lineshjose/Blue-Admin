<?php
/*
	Plugin Name: Blue Admin
	Version: 12.12.21
	Plugin URI: http://tech.lineshjose.com/introducing-blue-admin/
	Description: This is a simple and clear admin design that makes your WordPress administration section more clear and relaxed.
	Author: Linesh Jose
	Author URI: http://lineshjose.com
	License: GPL2
*/
	global $wp_lj_plugin;
	$wp_lj_plugin= array(
						'name'=>"Blue Admin",
						'slug'=>"blue_admin", 
						'version'=>'12.12.21', 
						'url'=> plugin_dir_url(__FILE__),
						'path'=> plugin_dir_path(__FILE__),
						'donate'=>'http://bit.ly/donate-blue-admin',
						'support'=> 'http://tech.lineshjose.com/introducing-blue-admin/#comments'
						);
	require_once($wp_lj_plugin['path'].'./inc/inc.php');
	include( $wp_lj_plugin['path'].'./inc/settings.php');
	
	
	


// Add meta links
if(!function_exists(lj_plugin_actions))
{
	function lj_plugin_actions( $links, $file )
	{
		global $wp_lj_plugin;
		$plugin = plugin_basename($wp_lj_plugin['path'].'index.php');
		if ($file == $plugin) {
			$links[] = '<a href="' . admin_url( 'admin.php?page='.$wp_lj_plugin['slug'] ) . '">' . __('Settings', TPTN_LOCAL_NAME ) . '</a>';
			$links[] = '<a href="'.$wp_lj_plugin['donate'].'" target="_blank">' . __('Donate', TPTN_LOCAL_NAME ) . '</a>';
			$links[] = '<a href="'.$wp_lj_plugin['support'].'" target="_blank">' . __('Support', TPTN_LOCAL_NAME ) . '</a>';
		}
		return $links;
	}
	
	global $wp_version;
	
	// only 2.8 and higher
	if ( version_compare( $wp_version, '3.2', '>' ) ){
		add_filter( 'plugin_row_meta', 'lj_plugin_actions', 10, 2 ); 
	} 
	else {
		add_filter( 'plugin_action_links', 'lj_plugin_actions', 10, 2 );
	}
} 
	
?>