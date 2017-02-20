<?php 
// color schemes  ------------------------>
function get_ba_color_schemes($scheme=array()){
	  // Check for transient, if yes, load transient
		if ( ($html = get_transient( 'lj_colors_json'))){
			$data=base64_decode($html);
		}else{
			  // Get remote HTML file
			  $args = array(
				'timeout'     => 120,
				'redirection' => 5,
				'httpversion' => '1.1',
				'user-agent'  => 'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2228.0 Safari/537.36',
				'blocking'    => true,
				'headers'     => array("Content-type" => "application/json"),
				'cookies'     => array(),
				'compress'    => true,
				'decompress'  => false,
				'sslverify'   => false,
				'stream'      => false,
			); 
			$response = wp_remote_get( 'http://apps.lineshjose.com/colors/colors_json.php',$args );
				if ( is_wp_error( $response ) ) {
					return $response;
				}
			 // Parse remote HTML file
			$data = wp_remote_retrieve_body( $response );
				if ( is_wp_error( $data ) ) {
					return false;
				}
			// Store remote HTML file in transient, expire after 24 hours
			set_transient( 'lj_colors_json', base64_encode($data), 24 * HOUR_IN_SECONDS );
		}
		return json_decode($data);
}
if(ba_get_option('blue_admin_color_scheme'))
{
	function ba_color_schemes_style()	
	{
		if(($scheme=@unserialize(@base64_decode(ba_get_option('blue_admin_color_scheme_val')))) && is_object($scheme))
		{
			if(is_user_logged_in()) 
			{
				echo '<!-- Blue Admin '.ucwords($scheme->name).' Color Scheme starts -->
					<style type="text/css">';
				if(isset($scheme->palette[0]))
				{
					echo '
						#wpadminbar,
						.wrap .add-new-h2:hover,
						.wrap .page-title-action:hover ,
						input[type=radio]:checked:before{
							background:'.$scheme->palette[0].' !important;
						}
						.login .message,
						.wrap .add-new-h2:hover, 
						.contextual-help-tabs .active,
						.wrap .page-title-action:hover,
						.drag-drop #drag-drop-area:hover,
						#wpadminbar .menupop .ab-sub-wrapper,
						#wpadminbar .ab-top-menu>.menupop>.ab-sub-wrapper{
							border-color:'.$scheme->palette[0].' !important;
						}
						.wp-core-ui .attachment.details .check, 
						.wp-core-ui .attachment.selected .check:focus, 
						.wp-core-ui .media-frame.mode-grid .attachment.selected .check {
							-webkit-box-shadow: 0 0 0 1px #fff,0 0 0 2px '.$scheme->palette[0].';
							box-shadow: 0 0 0 1px #fff,0 0 0 2px '.$scheme->palette[0].';
						}
						';
				}
				if(isset($scheme->palette[1]) && is_user_logged_in())
				{
					echo '	
						.media-item .bar,
						#adminmenu a:hover,
						.media-progress-bar div,
						#adminmenu li.menu-top:hover,
						.drag-drop #drag-drop-area:hover,
						#adminmenu li > a.menu-top:focus, 
						#adminmenu li.current a.menu-top,
						#adminmenu li.opensub > a.menu-top, 
						.wp-core-ui .attachment.details .check,
						.folded #adminmenu li.current.menu-top,
						.theme-browser .theme.active .theme-name,
						.theme-browser .theme.add-new-theme:hover,
						 .wp-core-ui .attachment.selected .check:focus,
						.theme-browser .theme.add-new-theme a:hover:after,
						.theme-browser .theme.add-new-theme a:focus:after,
						#adminmenu li.wp-has-current-submenu a.wp-has-current-submenu,
						.wp-core-ui .media-frame.mode-grid .attachment.selected .check,
						#adminmenu li.wp-has-current-submenu .wp-submenu .wp-submenu-head
						{
							color: #fff !important;
							background:'.$scheme->palette[1].'!important;
						}
						#adminmenu .wp-submenu li a:hover,
						.theme-browser .theme.add-new-theme:hover span:after,
						input[type=checkbox]:checked:before{
							color: '.$scheme->palette[1].' !important;
						}
						.wp-admin a{
							color: '.$scheme->palette[0].';
						}
						.wp-admin a:hover{
							color: #D52800;
						}
						
					';
				}
				if(isset($scheme->palette[2]))
				{
					echo '	
						.wp-core-ui .button-primary, 
						.media-modal-content .media-toolbar-primary .media-button{
							background:'.$scheme->palette[2].'!important;
						}
						.wp-core-ui .button-primary[disabled], 
						.wp-core-ui .button-primary:disabled, 
						.wp-core-ui .button-primary.button-primary-disabled,
						.wp-core-ui .button-primary.disabled {
							color: #FFF !important; 
							background:'.$scheme->palette[2].' !important; 
							opacity: .3;
						}
					';
				}
				echo '</style>
				<!-- Blue Admin Color Scheme ends --> 
			';
			}else{
				if(ba_is_login_page()){
					echo '
						<style type="text/css">
							.login .message{
								border-color:'.$scheme->palette[0].' !important;
							}
							.login .button-primary{
										background:'.$scheme->palette[2].'!important;
							}
						</style>
					';
				}
			}
		}
	}
	add_action('login_head', 'ba_color_schemes_style');
	add_action('admin_head', 'ba_color_schemes_style');
	add_action('wp_head', 'ba_color_schemes_style');
}
?>