<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title>Add Patient</title>

<link rel="stylesheet" type="text/css" media="screen" href="/css/chosen/chosen.css" />
<script src="/js/jquery-1.8.0.min.js" type="text/javascript"></script>    
<script src="/js/jquery.jeditable.js" type="text/javascript"></script>
<script src="/js/calender/jquery.validate.js" type="text/javascript"></script>
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

</head>
<body>
<div id="main">
name 
<div class="edit_name" id="name"><?php echo $patientInfo['Patient']['name'];?> </div>

<br><br><br>
 Contact:
 
<br>
<div id="contactBox">
Phone: <span class="edit_mobile" id="mobile_primary"><?php echo $patientInfo['Patient']['mobile_primary'];?></span>&nbsp;&nbsp;&nbsp;
(primary)
<span class="edit_mobile" id="mobile_wife"><?php echo $patientInfo['Patient']['mobile_wife'];?></span>&nbsp;&nbsp;&nbsp;
(wife)
<span class="edit_mobile" id="mobile_home"><?php echo $patientInfo['Patient']['mobile_home'];?></span>&nbsp;&nbsp;&nbsp;
(home)
<br>
Email:
<span class="edit_email" id="email_primary"><?php echo $patientInfo['Patient']['email_primary'];?></span>&nbsp;&nbsp;&nbsp;
(primary)
<span class="edit_email" id="email_wife"><?php echo $patientInfo['Patient']['email_wife'];?></span>&nbsp;&nbsp;&nbsp;
(wife)
<br>

Address
	<span class="edit_area" id="address_home"><?php echo $patientInfo['Patient']['address_home'];?></span>&nbsp;&nbsp;&nbsp;
	<span class="edit_city" id="city_home"><?php echo $patientInfo['Patient']['city_home'];?></span>&nbsp;&nbsp;&nbsp;
	<span class="edit_pin" id="pin_home"><?php echo $patientInfo['Patient']['pin_home'];?></span>&nbsp;&nbsp;&nbsp;
	home
	<br>
	<span class="edit_area" id="address_work"><?php echo $patientInfo['Patient']['address_work'];?></span>&nbsp;&nbsp;&nbsp;
	<span class="edit_city" id="city_work"><?php echo $patientInfo['Patient']['city_work'];?></span>&nbsp;&nbsp;&nbsp;
	<span class="edit_pin" id="pin_work"><?php echo $patientInfo['Patient']['pin_work'];?></span>&nbsp;&nbsp;&nbsp;
	work

	</div>

</div>
</body>
</html>
