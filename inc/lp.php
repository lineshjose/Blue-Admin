<?php 
// login page design ------------------------>
if(ba_get_option('blue_admin_login_page') =='1')
{
	//ba_del_option('ba_lp_attr');
	global $ba_lp_options;
	$ba_lp_options=ba_get_option('ba_lp_attr');
	if( empty($ba_lp_options)){
		$ba_lp_options=get_ba_options('settings');
		$ba_lp_options=$ba_lp_options['ba_lp_attr'];
	}
	
	// logo --------------->
	function ba_login_logo()	
	{
		global $ba_lp_options;
		if(isset($ba_lp_options['fm_no_bg_color']) && $ba_lp_options['fm_no_bg_color']=='1'){
			$bg_color='none';
		}else{
			$bg_color='#'.trim($ba_lp_options['fm_bg_color'])	;
		}
			echo '
			<style type="text/css">
				.login form{
					background:'.$bg_color.'!important;
					color:#'.trim($ba_lp_options['fm_color']).'!important;
				}
				.login form label{
					color:#'.trim($ba_lp_options['fm_color']).'!important;
				}
				body,
				#login,
				#login a,
				.login #backtoblog a, 
				.login #nav a, 
				.login h1 a{
					color: #'.trim($ba_lp_options['text_color']).'!important;
				}
				.login #login_error, 
				.login .message,
				.login .message a,
				.login #login_error a{
					color: #000!important;
				}
			';
			if(isset($ba_lp_options['logo_img']) && ( $logo_img= trim($ba_lp_options['logo_img']) ))
			{
				$size=array();
				echo '
					h1{
						width: 100px !important;
						height: 100px !important;
						margin: 0 auto 10px !important;
					}
					h1 a { 
						background:url('.$logo_img.') center no-repeat !important; 
						margin: 0 auto 10px!important;
						outline:none !important;
						/*width: 100px !important;
						height: 100px !important;*/
						max-width: 100px !important;
						max-height: 100px !important;
						
						overflow: initial !important;
						background-size: cover !important;
					}
					.login form {
						padding:20px !important;
						margin-top:0px !important;
					}
					.login #login_error, 
					.login .message{
						margin: 0 auto 10px!important;	
					}
				';
			}
			if($ba_lp_options['no_logo']=='1'){
				echo 'h1{ display:none !important;} ';
			}
			echo ' </style>';
	}
	add_action('login_head', 'ba_login_logo');
	
	
	// logo url ------------------>
	function ba_lp_logo_url() {
		global $ba_lp_options;
		if(isset($ba_lp_options['logo_url']) && ( $logo_url= trim($ba_lp_options['logo_url']) )){
			return $logo_url;
		}
	}
	add_filter('login_headerurl','ba_lp_logo_url');
	
	
	// logo title ------------------>
	function ba_lp_logo_text() {
		global $ba_lp_options;
		if(isset($ba_lp_options['logo_text']) && ( $logo_text= trim($ba_lp_options['logo_text']) )){
			return $logo_text;
		}
	}
	add_filter('login_headertitle','ba_lp_logo_text');
	
	
	
	// logo --------------->
	function ba_login_bg()	{
		global $ba_lp_options;
			echo '
				<style type="text/css">
				body,
				body.login{ ';
					if(isset($ba_lp_options['bg_color']) && ( $bg_color= trim($ba_lp_options['bg_color']) )){
						echo 'background-color:#'.$bg_color.' !important;';
					}
					if(isset($ba_lp_options['bg_img']) && ( $bg_img= trim($ba_lp_options['bg_img']) )){
						echo 'background-image:url(\''.$bg_img.'\') !important;';
					}
					
					if(isset($ba_lp_options['bg_img_pos']) && ( $bg_img_pos= trim($ba_lp_options['bg_img_pos']) )){
						echo 'background-position:'.$bg_img_pos.' !important;';
					}
					
					if(isset($ba_lp_options['bg_img_rep']) && ( $bg_img_rep= trim($ba_lp_options['bg_img_rep']) )){
						if($bg_img_rep=='tile'){
							echo 'background-repeat:repeat!important;';
						}else{
							echo 'background-attachment: fixed !important;;
								  background-size:cover !important;';
						}
					}
			echo '
				}
				</style>
			';
			
		}	
	add_action('login_head', 'ba_login_bg');
}
?>