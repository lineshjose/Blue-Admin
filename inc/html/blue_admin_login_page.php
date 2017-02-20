<?php
	$ba_lp_opts=array_filter(ba_get_option('ba_lp_attr'),'trim');
	$ba_lp_d_opts=get_ba_options('settings');
	$ba_lp_d_opts=$ba_lp_d_opts['ba_lp_attr']['default'];
	$ba_lp_opts=wp_parse_args($ba_lp_opts,$ba_lp_d_opts);
?>
<script>
	jQuery(document).ready(function(e) {
		// single image  selecting -------->
		jQuery('#wpbody').on('click', 'a.add_lp_bg_image', function(e) 
		{
			e.preventDefault();
			var frame;
			var elem=jQuery(this);
			
			// If the media frame already exists, reopen it.
			if ( frame ) {
			  frame.open();
			  return;
			}
			
			// Create a new media frame
			frame = wp.media({
				title: 'Select or Upload Media Of Your Chosen Persuasion',
				button: {
					text: 'Use this media'
				},
				multiple: false  // Set to true to allow multiple files to be selected
			});
			
			// When an image is selected in the media frame...
			frame.on( 'select', function() {
				var attachment = frame.state().get('selection').first().toJSON();// Get media attachment details from the frame state
				elem.parents('td').find('input.bg_img_id').val( attachment.url );// Send the attachment id to our hidden input
			});
			frame.open();
		});
		jQuery('#wpbody').on('click', 'a.remove_lp_bg_image', function(e) 
		{
			e.preventDefault();
			var elem=jQuery(this);
			elem.parents('td').find('input.bg_img_id').val( ' ' );// Send the attachment id to our hidden input
			return false;
		});
		jQuery('#wpbody').on('click', 'a.reset_color', function(e) 
		{
			var target=jQuery(this).parents('td').find('input');
			target.val(target.data('default-color')).css('background-color','#'+target.data('default-color'));
			return false;
		});
		
	});
</script>
<style>
.ba-lp-d fieldset {
	background: #F9F9F9;
	padding: 20px;
	margin: 25px 0;
	border: 1px solid #ddd;
}
.ba-lp-d fieldset legend {
	background: #ddd;
	padding: 8px 15px;
	border-radius: 0px !important;
	font-size: 14px;
	font-weight: bold;
	color: #000;
}
.ba-lp-d fieldset p {
	font-size: 13px;
	font-style: italic;
}
.ba-lp-d fieldset .button {
	padding: 2px 10px 2px !important;
}
</style>

<div class="ba-lp-d">
  <form method="post" class="jqtransform" id="myForm" enctype="multipart/form-data" action="">
    <fieldset>
      <legend>Login Form</legend>
      <table class="form-table">
        <tr>
          <th scope="row"><label for="fm-bg-color">Backround Color</label></th>
          <td><input name="ba_lp_attr[fm_bg_color]" type="text" id="fm-bg-color" value="<?php echo $ba_lp_opts['fm_bg_color']?>" class="regular-text jscolor" data-default-color="FFFFFF">
            <a href="#" class="button reset_color">Reset</a>
            <p>
              <label>
                <input name="ba_lp_attr[fm_no_bg_color]" type="checkbox" id="fm-no-bg-color" value="1" <?php if($ba_lp_opts['fm_no_bg_color']=='1'){ echo 'checked';} ?>>
                No background color?</label>
            </p></td>
        </tr>
        <tr>
          <th scope="row"><label for="fm-color">Foreground Color</label></th>
          <td><input name="ba_lp_attr[fm_color]" type="text" id="fm-color" value="<?php echo $ba_lp_opts['fm_color']?>" class="regular-text jscolor" data-default-color="777777">
            <a href="#" class="button reset_color">Reset</a></td>
        </tr>
        <tr>
          <th scope="row"><label for="logo-title">Logo Title</label></th>
          <td><input name="ba_lp_attr[logo_text]" type="text" id="logo-title" value="<?php echo $ba_lp_opts['logo_text']?>" class="regular-text"></td>
        </tr>
        <tr>
          <th scope="row"><label for="logo-url">Logo Url</label></th>
          <td><input name="ba_lp_attr[logo_url]" type="url" id="logo-url" value="<?php echo $ba_lp_opts['logo_url']?>" class="regular-text"></td>
        </tr>
        <tr>
          <th scope="row"><label for="logo-image">Logo Image</label></th>
          <td><input name="ba_lp_attr[logo_img]" type="url" id="logo-image" value="<?php echo $ba_lp_opts['logo_img']?>" class="regular-text bg_img_id">
            <a href="#" class="button add_lp_bg_image">Seleact an Image</a> <a href="#" class="button remove_lp_bg_image">Remove</a>
            <p>image with size 150px X 150px</p>
            <br>
            <p>
              <label>
                <input name="ba_lp_attr[no_logo]" type="checkbox" id="no-logo" value="1"  <?php if($ba_lp_opts['no_logo']=='1'){ echo 'checked';} ?>>
                Hide Logo?</label>
            </p></td>
        </tr>
      </table>
    </fieldset>
    <fieldset>
      <legend>Backround</legend>
      <table class="form-table">
        <tr>
          <th scope="row"><label for="bg-color">Background Color</label></th>
          <td><input name="ba_lp_attr[bg_color]" type="text" id="bg-color" value="<?php echo $ba_lp_opts['bg_color']?>" class="regular-text jscolor" data-default-color="EEEEEE">
            <a href="#" class="button reset_color">Reset</a></td>
        </tr>
        <tr>
          <th scope="row"><label for="text-color">Text Color</label></th>
          <td><input name="ba_lp_attr[text_color]" type="text" id="text-color" value="<?php echo $ba_lp_opts['text_color']?>" class="regular-text jscolor" data-default-color="222222">
            <a href="#" class="button reset_color">Reset</a></td>
        </tr>
        <tr>
          <th scope="row"><label for="bg-image">Image</label></th>
          <td><input name="ba_lp_attr[bg_img]" type="url" id="bg-image" value="<?php echo $ba_lp_opts['bg_img']?>" class="regular-text bg_img_id">
            <a href="#" class="button add_lp_bg_image">Seleact an Image</a> <a href="#" class="button remove_lp_bg_image">Remove</a></td>
        </tr>
        <tr>
          <th scope="row"><label for="bg-img-pos">Image Position</label></th>
          <td><select name="ba_lp_attr[bg_img_pos]">
              <option value="" >Select an option</option>
              <?php 
		  	foreach( array('left top', 'left center', 'left bottom', 'right top', 'right center', 'right bottom', 'center') as $pos){
				if( trim($ba_lp_opts['bg_img_pos'])==$pos){
					echo '<option value="'.$pos.'" selected>'.ucwords($pos).'</option>';	
				}else{
					echo '<option value="'.$pos.'">'.ucwords($pos).'</option>';	
				}
			}
		  ?>
            </select>
        </tr>
        <tr>
          <th scope="row"><label for="bg-img-rep">Tile background</label></th>
          <td><select name="ba_lp_attr[bg_img_rep]">
              <option value="" >Select an option</option>
              <?php 
		  	foreach( array('tile', 'fixed') as $pos){
				if( trim($ba_lp_opts['bg_img_rep'])==$pos){
					echo '<option value="'.$pos.'" selected>'.ucwords($pos).'</option>';	
				}else{
					echo '<option value="'.$pos.'">'.ucwords($pos).'</option>';	
				}
			}
		  ?>
            </select>
        </tr>
      </table>
    </fieldset>
    <div id="major-publishing-actions" class="submit" style="background:none; border:none; padding:0">
      <input name="ba_lp_options_save" type="submit" id="submit" value="Save changes"  class="button button-primary button-hero"/>
    </div>
  </form>
</div>