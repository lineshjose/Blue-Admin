<style>
.clear {
	clear: both;
	float: none;
}
.ba-info p {
	font-size: 15px;
}
.ba_boxes {
	display: -webkit-flex;
	-webkit-flex-wrap: wrap;
	display: flex;
	flex-wrap: wrap;
	display: -ms-flexbox;
	-ms-flex-wrap: wrap;
	position: relative;
}
.ba_box {
	width: 23.5%;
	margin-right: 15px;
	min-height: 160px;
	overflow: inherit !important;
	display: block;
	float: left;
	position: relative;
}
.ba_box h3 {
	padding: 8px;
	font-size: 13px;
	cursor: default !important;
	margin: 0;
	position: relative;
}
.ba_box.disable {
	background: none;
	position: relative;
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
.ba_box .button-primary {
	margin-bottom: 5px !important;
}
.ba_box .button-primary.disable {
	background: #C11215 !important;
}
.ba_box .button-primary.disable:hover {
	background: #E44245 !important;
}
.ba-footer {
	text-align: center;
	margin-top: 25px;
}
.ba-footer p {
	margin: 10px
}
.ba-footer .logo a {
	margin: 0 auto;
	display: block;
	width: 32px;
	height: 32px;
}
.ba-info img {
	margin-right: 15px;
	margin-bottom: 15px;
	border: 1px solid #C7C7C7;
}
</style>
<div class="ba-info"> <img src="<?php  echo  get_ba_options('url'); ?>assets/images/icon-big.png" alt="<?php echo get_ba_options('name'); ?>" title="<?php echo get_ba_options('name'); ?>" width="128" height="128" class="alignleft"/>
  <p>Thanks for downloading <strong> <?php echo get_ba_options('name'); ?> </strong>(ver. <?php echo get_ba_options('version'); ?>) by <a href="http://linesh.com/">Linesh Jose</a>. This is a simple and clear admin design that makes your WordPress administration section more clear and relaxed. Hope you enjoy using it!. There are a bunch of cool features that will surely help you get your admin panel looking and working it's best.</p>
  <p>A lot of hard work went in to programming and designing <strong> <?php echo get_ba_options('name'); ?> </strong> plugin, and if you would like to support please use the <a href="http://linesh.com/make-a-donation/">donate</a> here.  If you have any questions, comments, or if you encounter a bug, please <a href="http://linesh.com/forums/forum/plugins/blue-admin/">contact me</a>. Answer a short survey to let us know how we're doing and what to add in the future.<a target="_blank" href="http://lineshjose.polldaddy.com/s/blue-admin/">Take Survey</a></p>
</div>
<div class="clear"></div>
<div class="addons">
  <h3>Add-ons:</h3>
  <form method="post"  action="" name="ba_settings_form">
    <div class="ba_boxes">
      <?php foreach (get_ba_options('settings') as $index=>$value)
	{ 
	if($value['settings_type']=='common') {?>
      <div class="ba_box alignleft dime postbox">
        <h3 class="hndle ui-sortable-handle"><?php echo $value['name']; ?></h3>
        <div class="inside">
          <p class="description"><?php echo $value['desc']; ?></p>
          <p>
            <?php
		 if($value['input_type']=='button' && is_enabled($index,$value)){?>
            <input type="submit" name="<?php echo $index; ?>_disable" id="ID_<?php echo $index; ?>" value="Disable"	 class="button-primary disable"/>
            <?php } else if(($value['input_type']=='button') && (ba_get_option($index)=='')){?>
            <input type="submit" name="<?php echo $index; ?>_enable" id="ID_<?php echo $index; ?>" value="Enable"	class="button-primary enable" />
            <?php } ?>
            <?php if(isset($value['settings_page']) && $value['settings_page']==true && is_enabled($index,$value) ) { ?>
            <a href="./admin.php?page=<?php echo get_ba_options('slug');?>&tab=<?php echo $index; ?>"  class="button-secondary">Settings</a>
            <?php }?>
            <?php if($value['learn_more']) { ?>
            <a href="<?php echo $value['learn_more'];?>" target="_blank" class="button-secondary">Learn More</a>
            <?php }?>
          </p>
        </div>
      </div>
      <?php } } ?>
      <div class="ba_box alignleft disable dime postbox">
        <h3>Coming soon</h3>
      </div>
    </div>
  </form>
</div>
<!-- General settings page Ends -->
<div class="clear"></div>
<div class="ba-footer">
  <p class="logo"> <a href="http://linesh.com/" target="_blank"> <img src="<?php  echo  get_ba_options('url'); ?>assets/images/lin_logo.png" alt="Linesh.com" title="A Linesh Magic" width="32" height="32" class=""/> </a> </p>
  <p class="links"> <a target="_blank" href="http://wordpress.org/extend/plugins/blue-admin/changelog/" title="Visit plugin site">Ver. <?php echo get_ba_options('version'); ?></a> <a target="_blank" href="http://wordpress.org/extend/plugins/blue-admin/" title="Visit plugin site"><span class="dashicons dashicons-admin-external"></span>Visit plugin site</a> <a target="_blank" href="<?php echo get_ba_options('donate');?>"><span class="dashicons dashicons-admin-heart"></span>Donate</a> <a target="_blank" href="<?php echo get_ba_options('support');?>"><span class="dashicons dashicons-admin-sos"></span>Support</a> </p>
  <div class="clear"></div>
</div>