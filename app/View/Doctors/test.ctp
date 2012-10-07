<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" >
  <head>    
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">    
    <title>Calendar Details</title>    
    <link href="/css/calender/main.css" rel="stylesheet" type="text/css" />       
    <link href="/css/calender/dp.css" rel="stylesheet" />    
    <link href="/css/calender/dropdown.css" rel="stylesheet" />    
    <link href="/css/calender/colorselect.css" rel="stylesheet" />   
     
    <script src="/js/jquery-1.8.0.min.js" type="text/javascript"></script>    
    <script src="/js/calender/Common.js" type="text/javascript"></script>        
    <script src="/js/calender/jquery.form.js" type="text/javascript"></script>     
    <script src="/js/calender/jquery.validate.js" type="text/javascript"></script>     
    <script src="/js/calender/datepicker_lang_US.js" type="text/javascript"></script>        
    <script src="/js/calender/jquery.datepicker.js" type="text/javascript"></script>     
    <script src="/js/calender/jquery.dropdown.js" type="text/javascript"></script>     
    <script src="/js/calender/jquery.colorselect.js" type="text/javascript"></script>    
		<link rel="stylesheet" href="/js/development-bundle/themes/base/jquery.ui.all.css">
	
	<script src="/js/development-bundle/ui/jquery.ui.core.js"></script>
	<script src="/js/development-bundle/ui/jquery.ui.widget.js"></script>
	<script src="/js/development-bundle/ui/jquery.ui.position.js"></script>
	<script src="/js/development-bundle/ui/jquery.ui.autocomplete.js"></script>
    <style>
	.ui-autocomplete-loading { background: white url('images/ui-anim_basic_16x16.gif') right center no-repeat; }
	</style>
	<script>
	$(function() {
		

		$( "#patient_input" ).autocomplete({
			source: "/doctors/patient_search_json",
			minLength: 2,
				focus: function( event, ui ) {
				$( "#patient_input" ).val( ui.item.label );
				return false;
				},
				select: function( event, ui ) {
				$( "#patient_input"  ).show();
				
				$( "#patient_input"  ).val('');
				$( "#patient_info_box_inner").append(ui.item.label+"<br>");
				
				return false;
				}
		})
		.data( "autocomplete" )._renderItem = function( ul, item ) {
		return $( "<li></li>" )
		.data( "item.autocomplete", item )
		.append( "<a><table><tr><td>" + item.label + "</td></tr></table></a>" )
		.appendTo( ul );
		};
	});
	function change_patient(){
		$( "#patient_input"  ).show();
		$( "#patient_input"  ).val('');
		$( "#patient_id_hidden"  ).val('');
		$( "#patient_info_box").hide();
		$( "#patient_info_box_inner").html('');
	}

	</script>
	
  </head>
  <body>    
    <div>      
      <div class="infocontainer">            
                      
				<input id="patient_input" class="patient"  />
				                            
					<div id="patient_info_box_inner"></div>
      </div>         
    </div>
  </body>
</html>