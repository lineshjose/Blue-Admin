<style>
.ba_box {
	width: 30%;
	margin-right: 15px;
	min-height: 160px;
}
.ba_box h3 {
	padding: 8px;
	font-size: 13px;
	cursor: default !important;
	margin: 0;
}
.ba_box.disable {
	background: none;
	position: relative;
	width: 30.6%;
	border: 1px solid #dedede;
	-webkit-box-shadow: 0 1px 1px -1px rgba(0,0,0,.1);
	box-shadow: 0 1px 1px -1px rgba(0,0,0,.1);
	-webkit-box-sizing: border-box;
	-moz-box-sizing: border-box;
	box-sizing: border-box;
	border: 5px dashed #d5d2ca;
	text-align: center;
}
.ba_box.disable h3 {
	position: absolute;
	top: 50%;
	margin-top: -25px;
	left: 50%;
	font-size: 30px;
	margin-left: -100px;
}
</style>

<!-- General settings page starts -->
<div> <img src="<?php  echo  get_ba_options('url'); ?>assets/images/banner.jpg" alt="<?php echo get_ba_options('name'); ?>" title="<?php echo get_ba_options('name'); ?>" width="500" height="160" class="alignleft" style="margin-right:20px;   border: 1px solid rgb(181, 181, 181);"/>
  <p>Thanks for downloading <strong> <?php echo get_ba_options('name'); ?> </strong>(ver. <?php echo get_ba_options('version'); ?>) by <a href="https://lineshjose.com/" style="font-size:13px">Linesh Jose</a>. This is a simple and clear admin design that makes your WordPress administration section more clear and relaxed. Hope you enjoy using it!. There are a bunch of cool features that will surely help you get your admin panel looking and working it's best.</p>
  <h4 class="" style="margin:0;">Donate <?php echo get_ba_options('name');?></h4>
  <p>A lot of hard work went in to programming and designing <strong> <?php echo get_ba_options('name'); ?> </strong> plugin, and if you would like to support please use the <a href="http://bit.ly/donate-blue-admin" style="font-size:13px">donate</a> here.  If you have any questions, comments, or if you encounter a bug, please <a href="https://lineshjose.com/contact//" style="font-size:13px">contact me</a>.</p>
  <h4 class="" style="margin:0;">Have feedback on <?php echo get_ba_options('name');?>?</h4>
  <p>Answer a short survey to let us know how we're doing and what to add in the future.<a target="_blank" href="http://bit.ly/Blue-Admin-Survey">Take Survey</a></p>
</div>
<div style="width:100%; margin-top:30px; clear:both;">
  <h3>Add-ons:</h3>
  <form method="post"  action="" name="ba_settings_form">
    <?php foreach (get_ba_options('settings') as $value)
	{ 
	if($value['settings_type']=='common') {?>
    <div class="ba_box alignleft dime postbox">
      <h3 class="hndle ui-sortable-handle"><span><?php echo $value['name']; ?></span></h3>
      <div class="inside">
        <p class="description"><?php echo $value['desc']; ?></p>
        <p>
          <?php
		 if(($value['input_type']=='button') && (ba_get_option($value['id'])=='1')){?>
          	<input type="submit" name="<?php echo $value['id']; ?>_disable" id="ID_<?php echo $value['id']; ?>" value="Disable"	 class="button-primary disable"/>
          <?php } else if(($value['input_type']=='button') && (ba_get_option($value['id'])=='')){?>
          	<input type="submit" name="<?php echo $value['id']; ?>_enable" id="ID_<?php echo $value['id']; ?>" value="Enable"	class="button-primary enable" />
          <?php } ?>
          <?php if($value['learn_more']) { ?>
          <a href="<?php echo $value['learn_more'];?>" target="_blank" class="button-secondary">Learn More</a>
          <?php }?>
        </p>
      </div>
    </div>
    <?php } } ?>
  </form>
  <div class="ba_box alignleft disable dime postbox">
    <h3>Coming soon</h3>
  </div>
</div>
<!-- General settings page Ends -->

<div style="clear:both"></div>
<div class="" style="margin:40px auto 0px; text-align:center;"> 
	<a href="http://lineshjose.com/" target="_blank" style="margin:5px auto;"> <img src="<?php  echo  get_ba_options('url'); ?>assets/images/lin_logo.png" alt="A LineshJose.com Magic" title="A LineshJose.com Magic" width="200" height="29" class=""/></a>
    
  <p style="margin:0; padding:0;"> 
  	<a target="_blank" href="http://wordpress.org/extend/plugins/blue-admin/changelog/" title="Visit plugin site">Ver. <?php echo get_ba_options('version'); ?></a> | 
    <a target="_blank" href="http://wordpress.org/extend/plugins/blue-admin/" title="Visit plugin site"><span class="dashicons dashicons-admin-external"></span>Visit plugin site</a> | 
    <a target="_blank" href="<?php echo get_ba_options('donate');?>"><span class="dashicons dashicons-admin-heart"></span>Donate</a> | 
    <a target="_blank" href="<?php echo get_ba_options('support');?>"><span class="dashicons dashicons-admin-sos"></span>Support</a> </p>
  <div style="clear:both"></div>
</div>
