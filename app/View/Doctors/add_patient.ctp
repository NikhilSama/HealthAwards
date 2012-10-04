<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title>Add Patient</title>
<link rel="stylesheet" type="text/css" media="screen" href="/css/chosen/chosen.css" />
<script src="/js/jquery-1.8.0.min.js" type="text/javascript"></script>    
<script src="/js/calender/Common.js" type="text/javascript"></script> 
<script src="/js/calender/jquery.validate.js" type="text/javascript"></script>
<script type="text/javascript" >

$(document).ready(function() {


/*$.validator.addMethod("email", function(value, element)
{
	return this.optional(element) || /^[a-zA-Z0-9._-]+@[a-zA-Z0-9-]+\.[a-zA-Z.]{2,5}$/i.test(value);
}, "Please enter a valid email address.");

$.validator.addMethod("username",function(value,element)
{
	return this.optional(element) || /^[a-zA-Z0-9._-]{3,16}$/i.test(value);
},"Username are 3-15 characters");

$.validator.addMethod("password",function(value,element)
{
	return this.optional(element) || /^[A-Za-z0-9!@#$%^&*()_]{6,16}$/i.test(value);
},"Passwords are 6-16 characters");
*/

$.validator.addMethod("mobile",function(value,element)
{
	return this.optional(element) || /^(\+91-|\+91|0)?\d{10}$/.test(value);
},"Passwords are 6-16 characters");

// Validate signup form
$("#addPatient").validate({
rules: {
PatientName: "required",
PatientMobilePrimary:"mobile",
PatientMobileWife:"mobile",
PatientMobileHome:"mobile",
PatientEmailPrimary:"email",
PatientEmailWife:"email"
},
});
});
</script>
</head>
<body>
<?php
if ($this->Session->check('Message.flash')) {
    echo $this->Session->flash();
 } ?>
<form id="addPatient" method="post" enctype="multipart/form-data">
<input type="submit" value="Add Patient"> 
<?php echo $this->Form->File('Patient.photo'); ?>

<div id="main">
	name 
<div class="edit_name" id="name">
<?php echo $this->Form->text('Patient.name'); ?>
</div>

<br><br><br>
 Contact:
 
<br>
<div id="contactBox">
Phone: <span class="edit_mobile" id="mobile_primary">
<?php echo $this->Form->text('Patient.mobile_primary'); ?></span>&nbsp;&nbsp;&nbsp;
(primary)
<span class="edit_mobile" id="mobile_wife"><?php echo $this->Form->text('Patient.mobile_wife'); ?></span>&nbsp;&nbsp;&nbsp;
(wife)
<span class="edit_mobile" id="mobile_home"><?php echo $this->Form->text('Patient.mobile_home'); ?></span>&nbsp;&nbsp;&nbsp;
(home)
<br>
Email:
<span class="edit_email" id="email_primary"><?php echo $this->Form->text('Patient.email_primary'); ?></span>&nbsp;&nbsp;&nbsp;
(primary)
<span class="edit_email" id="email_wife"><?php echo $this->Form->text('Patient.email_wife'); ?></span>&nbsp;&nbsp;&nbsp;
(wife)
<br>

Address<br>
	Address<span class="edit_area" id="address_home"><?php echo $this->Form->text('Patient.address_home'); ?></span>&nbsp;&nbsp;&nbsp;
	City<span class="edit_city" id="city_home"><?php echo $this->Form->text('Patient.city_home'); ?></span>&nbsp;&nbsp;&nbsp;
	Pin<span class="edit_pin" id="pin_home"><?php echo $this->Form->text('Patient.pin_home'); ?></span>&nbsp;&nbsp;&nbsp;
	home
	<br>
	Address<span class="edit_area" id="address_work"><?php echo $this->Form->text('Patient.address_work'); ?></span>&nbsp;&nbsp;&nbsp;
	City<span class="edit_city" id="city_work"><?php echo $this->Form->text('Patient.city_work'); ?></span>&nbsp;&nbsp;&nbsp;
	Pin<span class="edit_pin" id="pin_work"><?php echo $this->Form->text('Patient.pin_work'); ?></span>&nbsp;&nbsp;&nbsp;
	work

	</div>
</form>
</div>
</body>
</html>
