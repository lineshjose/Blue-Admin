<?php 
if(ba_get_option('blue_admin_adminbar') =='1')
{
	// Custom Adminbar menu //
	function ba_adminbar_menus() {
		if(ba_main_site()){
	  		register_nav_menus(	array('ba_adminbar_menus' => __( 'Blue Admin: Adminbar Menu','ba' )));
		}
	}
	add_action( 'init', 'ba_adminbar_menus' );
	
	// Adding custom links to adminbar   -------->
	function ba_custom_adminbar_menus() 
	{
		global $wp_admin_bar;
		$menu_name = 'ba_adminbar_menus';
		  switch_to_blog(get_ba_main_blog_id());
		   if ( ( $locations = get_nav_menu_locations() ) && isset( $locations[ $menu_name ] ) )
		   {
			 if( $menu = wp_get_nav_menu_object( $locations[ $menu_name ] ))
			 {
				  $menu_items = wp_get_nav_menu_items($menu->term_id);
				  foreach ( (array) $menu_items as $key => $menu_item )
				  {
					  if($menu_item->classes){$clasess=implode(' ',$menu_item->classes);} else{$clasess="";}
					  $meta=array('class' =>$clasess , 'onclick' => '', 'target' => $menu_item->target, 'title' =>$menu_item->attr_title);
					  //print_r($menu_items);
					  if ($menu_item->menu_item_parent) 
					  { 
						  $wp_admin_bar->add_menu( array(
						  'id' => $menu_item->ID,
						  'parent' => $menu_item->menu_item_parent, 
						  'title' => $menu_item->title,
						  'href' => $menu_item->url,
						  'meta' =>  $meta ) );
						  
					  }else  {
						  $wp_admin_bar->add_menu( array(
						  'id' => $menu_item->ID,
						  'title' => $menu_item->title,
						  'href' => $menu_item->url,
						  'meta' =>  $meta ) );
					  }
				  }
			 }
		  }
			restore_current_blog();
		}
		add_action( 'wp_before_admin_bar_render', 'ba_custom_adminbar_menus' );
	}
?>