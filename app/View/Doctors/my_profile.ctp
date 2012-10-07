<link rel="stylesheet" type="text/css" media="screen" href="/css/chosen/chosen.css" />
<script src="/js/chosen/chosen.jquery.js" type="text/javascript"></script>
<script src="/js/ajaxupload.js" type="text/javascript"></script>
<script src="/js/jquery.jeditable.js" type="text/javascript"></script>
<script>
function makeEditable(){
	$('.edit_name').editable('/doctors/update_profile', {
         indicator : 'Saving...',
         tooltip   : 'Enter Name',
		 onblur : 'submit',
		 id   : 'field_name',
         name : 'value',
     style   : 'display: inline',
		 onsubmit: function(settings, td) {
				var input = $(td).find('input');
				$(this).validate({
					rules: {
						'value': {
							required: true
						}
					},
					messages: {'value': {required: 'Enter the Name'}}
				});
				return ($(this).valid());
			}
     });
     
	 $('.edit_area').editable('/doctors/update_profile', {
         indicator : 'Saving...',
		 type     : 'textarea',
         tooltip   : 'Click to edit...',
		 onblur : 'submit',
		 id   : 'field_name',
         name : 'value',
     style   : 'display: inline'
     });
	 $('.edit_contact_type').editable('/doctors/update_contact', {
         indicator : 'Saving...',
         tooltip   : 'Contact Type',
		 placeholder : 'Contact Type',
		 onblur : 'submit',
		 id   : 'field_name',
         name : 'value',
     style   : 'display: inline'/*,
		 onsubmit: function(settings, td) {
				var input = $(td).find('input');
				console.log(input);
				$(this).validate({
					rules: {
						'field_name': {
							required: true
						}
					},
					messages: {'field_name': {required: 'Only numbers are allowed'}}
				});
				return ($(this).valid());
			}*/
     });
	 $('.edit_mobile').editable('/doctors/update_contact', {
         indicator : 'Saving...',
         tooltip   : 'Mobile',
		 placeholder : 'Mobile',
		 onblur : 'submit',
		 id   : 'field_name',
         name : 'value',
     style   : 'display: inline',
		 onsubmit: function(settings, td) {
				var input = $(td).find('input');
				$(this).validate({
					rules: {
						'value': {
							mobile: true
						}
					}/*,
					messages: {'value': {mobile: 'Only numbers are allowed'}}*/
				});
				return ($(this).valid());
			}
     });
	 $('.edit_email').editable('/doctors/update_contact', {
         indicator : 'Saving...',
         tooltip   : 'Email',
		 placeholder : 'Email',
		 onblur : 'submit',
		 id   : 'field_name',
         name : 'value',
     style   : 'display: inline',
	 
		 onsubmit: function(settings, td) {
				var input = $(td).find('input');
				$(this).validate({
					rules: {
						'value': {
							email: true
						}
					},
					messages: {'value': {email: 'Enter valid email'}}
				});
				return ($(this).valid());
			}
     });
}

$(document).ready(function() {

		//makeEditable();
 });
</script>
<script type="text/javascript">
$(window).load(function(){
	
	var button = $('#change_button');
	var spinner = $('#spinner');
	
	//set the opacity to 0...
	button.css('opacity', 0);
	spinner.css('top', ($('.profile_pic').height() - spinner.height()) / 2)
	spinner.css('left', ($('.profile_pic').width() - spinner.width()) / 2)
	
	//On mouse over those thumbnail
	$('.profile_pic').hover(function() {
		button.css('opacity', .5);
		button.stop(false,true).fadeIn(200);
	},
	function() {
		button.stop(false,true).fadeOut(200);
	});
	
    new AjaxUpload(button,{
    	action: '/doctors/update_photo/', 
		name: 'myfile',
		onSubmit : function(file, ext){
			spinner.css('display', 'block');
			// you can disable upload button
			this.disable();
			},
		onComplete: function(file, response){
			button.stop(false,true).fadeOut(200);
			spinner.css('display', 'none');
			$('#profile_img').attr('src', response);
			// enable upload button
			this.enable();
		}
	});
	
});
  
</script>
<style type="text/css">
	div.profile_pic{
		position:relative;
		width:125px;	
	}
	div.change_button{
		position:absolute;
		bottom:0px;
		left:0px;
		display:none;
		background-color:black;
		font-family: 'tahoma';
		font-size:11px;
		text-decoration:underline;
		color:white;
		width:125px;
	}
	div.change_button_text{
		padding:10px;
	}
	#spinner{
		position:absolute;
	}
</style>


<!-- // Container -->
	


<div class="mainpage"><br><br>
 	<div class="doctor-profile" style="font-size:12px">
		<div class="img-outer">
			<!---->
 	<div class='profile_pic'>
		<!-- // Spinner -->
		<div id="spinner" style="display:none">
			<img src="/img/spinner_large.gif" border="0">
		</div>
		<!-- // Profile picture -->
			<?php if(!$user['userInfo']['image']){ ?>
			<img class="float-l mr-10" src="/img/picture1.jpg" id="profile_img">
			<?php }else{ ?>
			<img class="float-l mr-10" src="/img/doctors_pics/<?php echo $user['userInfo']['image']; ?>" id="profile_img">
			<?php } ?>

	</div>

			<a class="link edit" href="#" id='change_button'>Change</a>
		</div>
		<div class="top">
			<h3 class="ml-10"><div class="edit_name" id="name"><?php echo $user['userInfo']['first_name']; if($user['userInfo']['middle_name']){echo "  ".$user['userInfo']['middle_name'];} if($user['userInfo']['last_name']){echo " ".$user['userInfo']['last_name'];}?></div></h3>
			<div class="section">
				<table width="100%" cellpadding="5">
					<tr>
						<td width="33%" valign="top"><span class="text14"><b>Specialization:</b></span></td>
						<td valign="top">
						<?php 
						$tmp=array();
						foreach($specialties as $val){
						$tmp[]=$val['Specialty']['name'];
						}
						echo implode(', ',$tmp);
						?>
						</td>
					</tr>
					<tr>
						<td valign="top"><span class="text14"><b>Education & Training:</b></span></td>
						<td valign="top"><div class="edit_area" id="education"><?php 
						$tmp=array();
						foreach($qualifications as $val){
						$tmp[]=$val['Degree']['name'];
						}
						echo implode(', ',$tmp);
						?></div></td>
					</tr>
				</table>
			</div>
			<div class="section ml-20">
				<table width="100%" cellpadding="5">
					<tr>
						<td width="33%" valign="top"><span class="text14"><b>Certifications & Awards</b></span></td>
						<td valign="top"><div class="edit_area" id="awards"><?php echo $user['userInfo']['awards'];?></div></td>
					</tr>
				</table>
			</div>
		</div>
	</div>
	
	<div class="clear"></div>
	
	<div class="doctor-contact mt-40">
		<h3>Contact:</h3>
		<div id="contactBox">
		<?php
				foreach($address as $tmp){
					$flag=1;
					foreach($tmp['ConsultTiming'] as $val){
				?>
			<div id="contact<?php echo $val['id'];?>">
				<div class="type"><div class="edit_contact_type" id="contact_type-<?php echo $val['id'];?>"><?php echo $tmp['ConsultLocationType']['name'];?></div></div>
				<div class="phone"><div class="edit_mobile" id="phone-<?php echo $val['id'];?>"><?php echo $val['phone'];?></div></div>
				<div class="mail"><div class="edit_email" id="email-<?php echo $val['id'];?>"><?php echo $val['email'];?></div></div>
				<!--<img class="float-l" src="/img/cross-mark.gif" onclick="delete_contact(<?php echo $val['id'];?>)">-->
				<div class="clear"></div><br>
			</div>
		<?php }} ?>
		</div>
		<!--<a class="edit" href="javascript:void(0);" onclick="add_contact()">add new</a>-->
	</div>
	
	<div class="doctor-location mt-50">
		<h3>Location & Timings:</h3>
		<div class="float-l" style="width:950px">
			<table border="1" cellpadding="15" cellspacing="0"; width="600" style="float:left">
				<?php
				foreach($address as $val){
					$flag=1;
					foreach($val['ConsultTiming'] as $val1){
				?>
					<tr>
						<td width="25%" align="center" valign="middle">
						<?php
						$days=array();						
						if($val1['monday']){ $days[] = 'Monday'; }
						if($val1['tuesday']){ $days[] = 'Tuesday'; }
						if($val1['wednesday']){ $days[] = 'Wednesday'; }
						if($val1['thursday']){ $days[] = 'Thursday'; }
						if($val1['friday']){ $days[] = 'Friday'; }
						if($val1['saturday']){ $days[] = 'Saturday'; }
						if($val1['sunday']){ $days[] = 'Sunday'; }
						echo implode(', ',$days);
						?>
						</td>
						<td width="25%" align="center" valign="middle"><?php echo $val1['start']; ?>-<?php echo $val1['end']; ?></td>
						<td width="25%" align="center" valign="middle"><?php echo $val1['ConsultType']['name']; ?></td>
						<?php if($flag){ ?>
						<td  width="25%" align="center" valign="middle" rowspan="<?php echo count($val['ConsultTiming']); ?>" valign="center"><?php echo $val['Location']['address']; ?> <?php echo $val['Location']['City']['name']; ?> <?php echo $val['Location']['City']['state']; ?> <?php echo $val['Location']['PinCode']['pin_code']; ?> <?php echo $val['Location']['Country']['name']; ?></td>
						<?php } ?>
					</tr>
					
				<?php
					$flag=0;
					}
				}
				?>
			</table>
			<div class="float-r" style="width:340px; height:220px">
			<img src="/img/map.jpg" width="100%" height="100%">
			</div>
			
		
<?php  echo $this->Html->link('Change','manage_timings',array('class'=>'edit'));?>
		</div>
		
		<div class="float-r">
		
		</div>
	</div>
 
 
 </div>





<!--

	Specialization:
 <select id="specialization" name="specialization[]" data-placeholder="Choose a Country..." class="chzn-select" multiple style="width:350px;" tabindex="4" onchange="savespecialization();">
          <option value=""></option> 
          <option value="United States">United States</option> 
          <option value="United Kingdom">United Kingdom</option> 
          <option value="Afghanistan">Afghanistan</option> 
          <option value="Albania">Albania</option> 
          <option value="Algeria">Algeria</option> 
          <option value="American Samoa">American Samoa</option> 
          <option value="Andorra">Andorra</option> 
          <option value="Angola">Angola</option> 
          <option value="Anguilla">Anguilla</option> 
 </select>



<br>

Location & Timings:

<br>
<?php  echo $this->Html->link('Change','manage_timings');?>
</div>-->
<script type="text/javascript"> 
function add_contact(){
	$.ajax({
	  url: '/doctors/add_contact/',
	  success: function(data) {
			$("#contactBox").append("<div id='contact"+data+"'></div>");
			var text ='<div class="type"><div class="edit_contact_type" id="contact_type-'+data+'"></div></div>';
			text +='<div class="phone"><div class="edit_mobile" id="mobile-'+data+'"></div></div>';
			text +='<div class="mail"><div class="edit_email" id="email-'+data+'"></div></div>';
			text +='<img class="float-l" src="/img/cross-mark.gif" onclick="delete_contact('+data+')">';
			text +='<div class="clear"></div><br>';
			$("#contact"+data).html(text);
			makeEditable();
	  }
	});	
}


function delete_contact(id){
	$("#contact"+id).remove();
	$.ajax({
	  url: '/doctors/delete_contact/'+id,
	  success: function(data) {
	  }
	});
}

$(".chzn-select").chosen(); 
$(".chzn-select-deselect").chosen({allow_single_deselect:true}); 
</script>
