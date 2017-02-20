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
.palettes .palette {
	width: 15%;
	background: #eee;
	float: left;
	position: relative;
	margin: 10px 11px;
	overflow: hidden;
}
.palettes .palette.wide {
	width: 100%;
	margin: 0;
}
.palettes .palette table {
	width: 100%;
	table-layout: fixed;
	border-collapse: collapse;
	position: relative;
	z-index: 1;
}
.palettes .palette table td {
	height: 80px;
	user-select: none;
	-webkit-user-select: none;
}
.palettes .palette.wide, .palettes .palette table td {
	height: 100px;
}
.palettes .palette label {
	position: absolute;
	top: 0px;
	left: 0px;
	right: 0px;
	bottom: 0px;
	z-index: 99;
	display: block;
	color: #fff;
	padding: 10px;
	user-select: none;
	-webkit-user-select: none;
	font-weight: bold;
	font-size: 15px;
	cursor: copy;
	letter-spacing: 0.6px;
}
.palettes .palette.wide label {
	padding: 20px;
	cursor: default;
}
.palettes .palette label span {
	display: block;
	margin-bottom: 5px;
}
.palettes .palette.wide label span {
	font-size: 20px;
}
.palettes .palette label a {
	color: #fff;
	font-size: 12px;
	text-decoration: none;
	position: absolute;
	bottom: 10px;
	opacity: 0.7;
	z-index: 999;
}
.palettes .palette label a:hover {
	opacity: 1;
}
.palettes .palette label:after {
	font-family: dashicons;
	content: "\f147";
	font-size: 25px;
	color: #fff;
	bottom: 5px;
	position: absolute;
	z-index: 999;
	right: 10px;
	opacity: 0;
}
.palettes .palette label, .palettes .palette label:after {
	-webkit-transition: 0.25s all ease!important;
	-moz-transition: 0.25s all ease!important;
	-ms-transition: 0.25s all ease!important;
	-o-transition: 0.25s all ease!important;
	transition: 0.25s all ease!important;
}
.palettes .palette input {
	position: absolute;
	top: 0px;
	left: 0px;
	z-index: -1;
}
.palettes .palette input[type="radio"]:checked+label {
	font-size: 14px;
}
.palettes .palette input[type="radio"]:checked+label:after {
	opacity: 1;
}

@media only screen and (max-width: 1440px) {
.palettes .palette {
	width: 14.8%;
}
}

@media only screen and (max-width: 1366px) {
.palettes .palette {
	width: 14.6%;
}
}

@media only screen and (max-width: 1024px) {
.palettes .palette {
	width: 17%;
}
}

@media only screen and (max-width: 800px) {
.palettes .palette {
	width: 21.5%;
}
}

@media only screen and (max-width: 640px) {
.palettes .palette {
	width: 20.5%;
}
}

@media only screen and (max-width: 640px) {
.palettes .palette {
	width: 30%;
	margin: 5px;
}
}

@media only screen and (max-width: 320px) {
.palettes .palette {
	width: 46%;
	margin: 5px;
}
}
</style>
<div class="ba-lp-d">
  <form method="post" action="">
    <?php 	
	  	if( ($scheme=ba_get_option('blue_admin_color_scheme_val')) && ($c_scheme=@unserialize(@base64_decode($scheme))) && is_object($c_scheme))
		{  
	  ?>
    <fieldset>
      <legend>Current Scheme</legend>
      <div class="palettes">
        <div class="palette wide">
          <input type="radio" name="blue_admin_color_scheme_val" value="<?php echo $scheme;?>" checked id="ba-c-scheme-current">
          <table>
            <tr>
              <td style="background:<?php echo $c_scheme->palette[0];?>;">&nbsp;</td>
              <td style="background:<?php echo $c_scheme->palette[1];?>;">&nbsp;</td>
              <td style="background:<?php echo $c_scheme->palette[2];?>;">&nbsp;</td>
            </tr>
          </table>
          <label><span><?php echo $c_scheme->name;?></span><a href="<?php echo $c_scheme->author_url;?>" target="_blank"><?php echo $c_scheme->author;?></a> </label>
        </div>
        <div class="clear"></div>
      </div>
    </fieldset>
    <?php 
	 	} 
  ?>
    <?php
		if( ($schemes=get_ba_color_schemes()) && !isset($schemes->errors) )
		{
?>
    <fieldset>
      <legend>Select a color scheme</legend>
      <div class="palettes">
        <div class="loaded-palettes">
          <?php
	  
			foreach($schemes as $index=>$scheme)
			{
				if($index=='div'){
					echo'<div class="clear"></div><br><hr>';
				}else{
					echo '<h3>'.ucwords(str_replace('_',' ',$index)).' Schemes</h3><div class="clear"></div>';
					
					foreach($scheme as $ind=>$val)
					{
						$new_val=base64_encode(serialize($val));
						echo'<div class="palette"><table><tr>';
							  foreach($val->palette as $color){
								  echo '<td style="background:'.$color.';">&nbsp;</td>';
							  }
						  echo'</tr></table>';
							  if(ba_get_option('blue_admin_color_scheme_val') ==$new_val ){
								  echo '<input type="radio" name="blue_admin_color_scheme_val" value="'.$new_val.'" checked id="ba-c-scheme-'.$ind.'">';
							  }else{
								  echo '<input type="radio" name="blue_admin_color_scheme_val" value="'.$new_val.'" id="ba-c-scheme-'.$ind.'">';
							  }
						  echo'
							  <label for="ba-c-scheme-'.$ind.'" >
								  <span>'.$val->name.'</span>
								  <a href="'.$val->author_url.'" target="_blank">'.$val->author.'</a>
							  </label>	
							  </div>	
						  ';
					}
				}
			}
		?>
        </div>
        <div class="clear"></div>
      </div>
      <br>
      <hr>
      <br>
      <p>More colors are coming soon... Stay tuned on <a href="http://linesh.com/" target="_blank">Linesh.Com</a></p>
    </fieldset>
    <div id="major-publishing-actions" class="submit" style="background:none; border:none; padding:0">
      <input name="ba_cs_options_save" type="submit" id="submit" value="Save changes"  class="button button-primary button-hero"/>
    </div>
    <?php 
		}else{?>
    <fieldset>
      <div style="background:#ff5c5c;color:#fff;padding:10px 20px;">
        <p><strong>Oops..</strong> We could not fetch color schemes from our server.</p>
        <?php if(isset($schemes->errors)){ 
				 foreach($schemes->errors as $_in=>$val){
					echo '<p><strong>'.ucwords(str_replace('_',' ',$_in)).':</strong> '.$val[0].'.</p>';	 
				 }
			 }?>
      </div>
    </fieldset>
    <?php }	?>
  </form>
</div>