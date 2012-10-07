<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title>Add Patient</title>
<link rel="stylesheet" type="text/css" media="screen" href="/css/chosen/chosen.css" />
<script src="/js/jquery-1.8.0.min.js" type="text/javascript"></script>    
<script src="/js/calender/Common.js" type="text/javascript"></script> 
<script src="/js/calender/jquery.validate.js" type="text/javascript"></script>
<script src="/js/calender/jquery.form.js" type="text/javascript"></script>   
<script src="/js/main.js" type="text/javascript"></script> 
<link rel="stylesheet" href="/js/development-bundle/themes/base/jquery.ui.all.css">
<script src="/js/development-bundle/ui/jquery.ui.core.js"></script>
<script src="/js/development-bundle/ui/jquery.ui.widget.js"></script>
<script src="/js/development-bundle/ui/jquery.ui.position.js"></script>
<script src="/js/development-bundle/ui/jquery.ui.autocomplete.js"></script>

<script type="text/javascript" >

$(function() {
		var searchCity= $( "#PatientCity" ).autocomplete({
			source: "/util/city_search_json",
			minLength: 2,
				focus: function( event, ui ) {
				$( "#PatientCity" ).val( ui.item.label );
				return false;
				},
				select: function( event, ui ) {
					
					$( "#PatientCityId"  ).val(ui.item.id);
					return false;
				}
		});
		searchCity.data("autocomplete").search=function(value, event){ 
				$( "#PatientCityId"  ).val('');
				value = value != null ? value : this.element.val();

				// always save the actual value, not the one passed as an argument
				this.term = this.element.val();

				if ( value.length < this.options.minLength ) {
					return this.close( event );
				}

				clearTimeout( this.closing );
				if ( this._trigger( "search", event ) === false ) {
					return;
				}

				return this._search( value );
		};
		searchCity.data( "autocomplete" )._renderItem = function( ul, item ) {
		return $( "<li></li>" )
		.data( "item.autocomplete", item )
		.append( "<a><table><tr><td>" + item.label + "</td><td>" + item.state + "</td> </tr></table></a>" )
		.appendTo( ul );
		};
		
		var searchPinCode= $( "#PatientPinCode" ).autocomplete({
			source: "/util/pincode_search_json",
			minLength: 2,
				focus: function( event, ui ) {
				$( "#PatientPinCode" ).val( ui.item.label );
				return false;
				},
				select: function( event, ui ) {
					
					$( "#PatientPinCodeId"  ).val(ui.item.id);
					return false;
				}
		});
		searchPinCode.data("autocomplete").search=function(value, event){ 
				$( "#PatientPinCodeId"  ).val('');
				value = value != null ? value : this.element.val();

				// always save the actual value, not the one passed as an argument
				this.term = this.element.val();

				if ( value.length < this.options.minLength ) {
					return this.close( event );
				}

				clearTimeout( this.closing );
				if ( this._trigger( "search", event ) === false ) {
					return;
				}

				return this._search( value );
		};
		var searchCountry= $( "#PatientCountry" ).autocomplete({
			source: "/util/country_search_json",
			minLength: 2,
				focus: function( event, ui ) {
				$( "#PatientCountry" ).val( ui.item.label );
				return false;
				},
				select: function( event, ui ) {
					
					$( "#PatientCountryId"  ).val(ui.item.id);
					return false;
				}
		});
		searchCountry.data("autocomplete").search=function(value, event){ 
				$( "#PatientCountryId"  ).val('');
				value = value != null ? value : this.element.val();

				// always save the actual value, not the one passed as an argument
				this.term = this.element.val();

				if ( value.length < this.options.minLength ) {
					return this.close( event );
				}

				clearTimeout( this.closing );
				if ( this._trigger( "search", event ) === false ) {
					return;
				}

				return this._search( value );
		};
	});


$(document).ready(function() {


// Validate signup form
/*$("#addPatient").validate({
rules: {
PatientFirstName: "required",
PatientPhone:"mobile",
PatientEmail:"email"
}

});*/
var options = {
                beforeSubmit: function() {
                    return true;
                },
                dataType: "json",
                success: function(data) {
                   // alert(data.Msg);
                    if (data.IsSuccess) {
                        CloseModelWindow(null,true);  
                    }else
					if (data.error) {
					var ii=0;
					var error="Errors:<br>";
						for(var i in data.error){
						ii++;
							error+=ii+"."+data.error[i]+"<br>";
							
						}
						$("#error_div").html(error);
					}
                }
            };
 //form validation rules
            $("#addPatient").validate({
                
                messages: {
                    PatientFirstName: "Please enter your firstname",
                    
                    PatientEmail: "Please enter a valid email address",
                    PatientEmail: "Please accept our policy"
                },
                submitHandler: function(form) {
					$("#error_div").html('');
					 $("#addPatient").ajaxSubmit(options); 
                    //form.submit();
                }
            });
});
</script>
</head>
<body>
<div id="error_div">

</div>
<form id="addPatient" method="post" enctype="multipart/form-data" >
<input type="submit" value="Add Patient"> 
<?php echo $this->Form->File('Patient.image'); ?>

<div id="main">
Name 
<div class="edit_name" id="name">
<?php echo $this->Form->text('Patient.fullname',array('class'=>'required')); ?>
</div>
<br>
 Contact:
 
<br>
<div id="contactBox">
Phone: <span class="edit_mobile" id="phone">
<?php echo $this->Form->text('Patient.phone',array('class'=>'mobile')); ?></span>&nbsp;&nbsp;&nbsp;

<br>
Email:
<span class="edit_email" id="email"><?php echo $this->Form->text('Patient.email',array('class'=>'email')); ?></span>&nbsp;&nbsp;&nbsp;

<br>
	Address<span class="edit_area" id="address"><?php echo $this->Form->text('Patient.address'); ?></span>&nbsp;&nbsp;&nbsp;<br>
	City<span class="edit_city" id="city_home"><?php echo $this->Form->hidden('Patient.city_id'); ?><?php echo $this->Form->text('Patient.city'); ?></span>&nbsp;&nbsp;&nbsp;<br>
	Pin Code<span class="edit_pin" id="pin_home"><?php echo $this->Form->hidden('Patient.pin_code_id'); ?><?php echo $this->Form->text('Patient.pin_code',array('class'=>'pin')); ?></span>&nbsp;&nbsp;&nbsp;<br>
	
	Country<span class="edit_city" id="city_work"><?php echo $this->Form->hidden('Patient.country_id'); ?><?php echo $this->Form->text('Patient.country'); ?></span>&nbsp;&nbsp;&nbsp;
	</div>
</form>
</div>
</body>
</html>
