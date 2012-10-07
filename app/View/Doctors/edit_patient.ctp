<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title>Add Patient</title>

<link rel="stylesheet" type="text/css" media="screen" href="/css/chosen/chosen.css" />
<script src="/js/jquery-1.8.0.min.js" type="text/javascript"></script>    
<script src="/js/main.js" type="text/javascript"></script> 
<script src="/js/jquery.jeditable.js" type="text/javascript"></script>
<script src="/js/calender/jquery.validate.js" type="text/javascript"></script>
<script src="/js/ajaxupload.js" type="text/javascript"></script>

<link rel="stylesheet" href="/js/development-bundle/themes/base/jquery.ui.all.css">
<script src="/js/development-bundle/ui/jquery.ui.core.js"></script>
<script src="/js/development-bundle/ui/jquery.ui.widget.js"></script>
<script src="/js/development-bundle/ui/jquery.ui.position.js"></script>
<script src="/js/development-bundle/ui/jquery.ui.autocomplete.js"></script>
<script>
function makeEditable(){
	$('.edit_name').editable('/doctors/update_patient_info', {
		 submitdata : {patient_id: "<?php echo $patientInfo['Patient']['user_id'];?>"},
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
	 $('.edit_city').editable('/doctors/update_patient_info', {
		 submitdata : {patient_id: "<?php echo $patientInfo['Patient']['user_id'];?>"},
         indicator : 'Saving...',
         tooltip   : 'Click to edit...',
		 placeholder : 'City',
		 onblur : 'submit',
		 id   : 'field_name',
         name : 'value',
		 'autoc':'deepak',
		style   : 'display: inline',
		 onsubmit: function(settings, td) {
			
			settings.submitdata.city_id=$("#PatientCityId").val();
		 },
		 onedit:function(settings, td){ 
		 		 //return false;
		// alert(1);
		 }
     });
	  $('.edit_country').editable('/doctors/update_patient_info', {
		 submitdata : {patient_id: "<?php echo $patientInfo['Patient']['user_id'];?>"},
         indicator : 'Saving...',
         tooltip   : 'Click to edit...',
		 placeholder : 'City',
		 onblur : 'submit',
		 id   : 'field_name',
         name : 'value',
		style   : 'display: inline'
     });
	 $('.edit_pin').editable('/doctors/update_patient_info', {
		 submitdata : {patient_id: "<?php echo $patientInfo['Patient']['user_id'];?>"},
         indicator : 'Saving...',
         tooltip   : 'Click to edit...',
		 placeholder : 'Pin',
		 onblur : 'submit',
		 id   : 'field_name',
         name : 'value',
		style   : 'display: inline'
     });
     $('.edit_area').editable('/doctors/update_patient_info', {
		 submitdata : {patient_id: "<?php echo $patientInfo['Patient']['user_id'];?>"},
         indicator : 'Saving...',
		 type     : 'textarea',
         tooltip   : 'Click to edit...',
		  placeholder : 'Address',
		 onblur : 'submit',
		 id   : 'field_name',
         name : 'value',
		style   : 'display: inline'
     });
	 $('.edit_mobile').editable('/doctors/update_patient_info', {
		 submitdata : {patient_id: "<?php echo $patientInfo['Patient']['user_id'];?>"},
         indicator : 'Saving...',
         tooltip   : 'Mobile',
		 placeholder : 'Mobile',
		 onblur : 'submit',
		 id   : 'field_name',
         name : 'value',
		style   : 'display: inline',
		 onsubmit: function(settings, td) {
				var input = $(td).find('input');
				console.log(input);
				$(this).validate({
					rules: {
						'value': {
							mobile: true
						}
					}/*,
					messages: {'value': {mobile: 'Please enter valid mobile number'}}*/
				});
				return ($(this).valid());
			}
     });
	 $('.edit_email').editable('/doctors/update_patient_info', {
		 submitdata : {patient_id: "<?php echo $patientInfo['Patient']['user_id'];?>"},
         indicator : 'Saving...',
         tooltip   : 'Email',
		 placeholder : 'Email',
		 onblur : 'submit',
		 id   : 'field_name',
         name : 'value',
     style   : 'display: inline',
	 
		 onsubmit: function(settings, td) {
				var input = $(td).find('input');
				console.log(input);
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
		makeEditable();
 });
</script>
<script type="text/javascript">
$(window).load(function(){
	
	var button = $('#change_button');
	var spinner = $('#spinner');
	
	//set the opacity to 0...
	//button.css('opacity', 10);
	spinner.css('top', ($('.profile_pic').height() - spinner.height()) / 2)
	spinner.css('left', ($('.profile_pic').width() - spinner.width()) / 2)
	
	//On mouse over those thumbnail
	$('.profile_pic').hover(function() {
		//button.css('opacity', 10);
		button.stop(false,true).fadeIn(200);
	},
	function() {
		//button.stop(false,true).fadeOut(200);
	});
	
    new AjaxUpload(button,{
    	action: '/doctors/update_patient_photo/<?php echo $patientInfo['Patient']['user_id'];?>', 
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
</head>
<body>




<div class="img-outer">
			<!---->
 	<div class='profile_pic'>
		<!-- // Spinner -->
		<div id="spinner" style="display:none">
			<img src="/img/spinner_large.gif" border="0">
		</div>
		<!-- // Profile picture -->
			<?php if(!$patientInfo['Patient']['image']){ ?>
			<img class="float-l mr-10" src="/img/picture1.jpg" id="profile_img">
			<?php }else{ ?>
			<img class="float-l mr-10" src="/img/patient_pics/<?php echo $patientInfo['Patient']['image']; ?>" id="profile_img">
			<?php } ?>

	</div>

			<a class="link edit" href="#" id='change_button'>Change</a>
		</div>


<div id="main">
name 
<div class="edit_name" id="fullname"><?php echo $patientInfo['Patient']['first_name'];?> <?php echo $patientInfo['Patient']['last_name'];?></div>

<br><br><br>
 Contact:
 
<br>
<div id="contactBox">
Phone: <span class="edit_mobile" id="phone"><?php echo $patientInfo['Patient']['phone'];?></span>
<br>
Email:
<span class="edit_email" id="email"><?php echo $patientInfo['Patient']['email'];?></span>
<br>
<?php //pr($patientInfo); ?>
Address
	<span class="edit_area" id="address"><?php echo $patientInfo['Patient']['address'];?></span>
	<span class="edit_city" id="city"><?php echo $patientInfo['City']['name'];?></span><?php echo $this->Form->hidden('Patient.city_id',array('value'=>$patientInfo['Patient']['city_id'])); ?>&nbsp;&nbsp;&nbsp;
	<span class="edit_pin" id="pin_code"><?php echo $patientInfo['PinCode']['pin_code'];?></span><?php echo $this->Form->hidden('Patient.pin_code_id',array('value'=>$patientInfo['Patient']['pin_code_id'])); ?>&nbsp;&nbsp;&nbsp;
	<span class="edit_country" id="country"><?php echo $patientInfo['Country']['name'];?></span><?php echo $this->Form->hidden('Patient.country_id',array('value'=>$patientInfo['Patient']['country_id'])); ?>&nbsp;&nbsp;&nbsp;
	</div>

</div>
</body>
</html>
