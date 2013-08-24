<?php
	
// Genearl settings updation //
	/*if($_SERVER['REQUEST_METHOD'] == 'POST')
	{*/
		foreach ($lj_options as $value)
		{
			if($value['settings_type']=='common')
			{
			if ( $_POST[$value['id'].'_enable']){ update_option( $value['id'], '1'); lj_redirect('','saved=true');}
			else if ( $_POST[$value['id'].'_disable']){ update_option( $value['id'], ''); lj_redirect('','saved=true');}
			}
		}
		//
	//}	
	
	
	// Settings Page  //
	if(!function_exists('lj_bd_admin_header'))
	{
		function lj_bd_admin_header() 
		{
			global $lj_options,$wp_lj_plugin; ?>
			<div class="wrap">
			<?php if ( $_REQUEST['saved'] ) echo '<div id="message" class="updated fade"><p><strong>'.$themename.' settings saved.</strong></p></div>';	?>
			<?php if ( $_REQUEST['error'] ) echo '<div id="message" class="error fade"><p><strong>Something went wrong please try again.</strong></p></div>';	?>
				
				<div id="icon" class="icon32 blue-admin-32"><br></div>
				<h2 ><?php echo $wp_lj_plugin['name']; ?> Settings</h2>
				
				<div style="float: left;height: 10px;margin: 10px 8px 0 0;width: 10px;">&nbsp;</div>
				<h3 class="nav-tab-wrapper" style="margin: 7px 8px 0 0;">
					<a href="./admin.php?page=<?php echo  $wp_lj_plugin['slug'];?>" class="nav-tab <?php lj_nav_tab_active(array($_GET['tab'],''));?> ">Dashboard</a>
				</h3>
		<div class="blue_admin_settings" style="margin:0; padding:10px">
<?php 	
		include($wp_lj_plugin['path'].'inc/gen_form.php');
 ?>
			<div style="clear:both"></div>
			</div>
			</div>
			
<?php } } ?>