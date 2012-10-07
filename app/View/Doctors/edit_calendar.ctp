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
				$( "#patient_input"  ).hide();
				
				$( "#patient_id_hidden"  ).val(ui.item.id);
				$( "#patient_info_box").show();
				$( "#doctor_notify_email"  ).focus();
				$( "#patient_info_box_inner").html(ui.item.label+"<br>"+ui.item.email+"<br>"+ui.item.mobile);
				
				return false;
				}
		})
		.data( "autocomplete" )._renderItem = function( ul, item ) {
		return $( "<li></li>" )
		.data( "item.autocomplete", item )
		.append( "<a><table><tr><td>" + item.label + "</td><td>" + item.email + "</td> <td>" + item.mobile + "</td></tr></table></a>" )
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
	<script type="text/javascript">
	
	
        if (!DateAdd || typeof (DateDiff) != "function") {
            var DateAdd = function(interval, number, idate) {
                number = parseInt(number);
                var date;
                if (typeof (idate) == "string") {
                    date = idate.split(/\D/);
                    eval("var date = new Date(" + date.join(",") + ")");
                }
                if (typeof (idate) == "object") {
                    date = new Date(idate.toString());
                }
                switch (interval) {
                    case "y": date.setFullYear(date.getFullYear() + number); break;
                    case "m": date.setMonth(date.getMonth() + number); break;
                    case "d": date.setDate(date.getDate() + number); break;
                    case "w": date.setDate(date.getDate() + 7 * number); break;
                    case "h": date.setHours(date.getHours() + number); break;
                    case "n": date.setMinutes(date.getMinutes() + number); break;
                    case "s": date.setSeconds(date.getSeconds() + number); break;
                    case "l": date.setMilliseconds(date.getMilliseconds() + number); break;
                }
                return date;
            }
        }
        function getHM(date)
        {
             var hour =date.getHours();
             var minute= date.getMinutes();
             var ret= (hour>9?hour:"0"+hour)+":"+(minute>9?minute:"0"+minute) ;
             return ret;
        }
		
        $(document).ready(function() {
            //debugger;
            var DATA_FEED_URL = "/doctors/calendar_datafeed/";
            var arrT = [];
            var tt = "{0}:{1}";
            for (var i = 0; i < 24; i++) {
                arrT.push({ text: StrFormat(tt, [i >= 10 ? i : "0" + i, "00"]) }, { text: StrFormat(tt, [i >= 10 ? i : "0" + i, "30"]) });
            }
            $("#timezone").val(new Date().getTimezoneOffset()/60 * -1);
            $("#stparttime").dropdown({
                dropheight: 200,
                dropwidth:60,
                selectedchange: function() { },
                items: arrT
            });
            $("#etparttime").dropdown({
                dropheight: 200,
                dropwidth:60,
                selectedchange: function() { },
                items: arrT
            });
            var check = $("#IsAllDayEvent").click(function(e) {
                if (this.checked) {
                    $("#stparttime").val("00:00").hide();
                    $("#etparttime").val("00:00").hide();
                }
                else {
                    var d = new Date();
                    var p = 60 - d.getMinutes();
                    if (p > 30) p = p - 30;
                    d = DateAdd("n", p, d);
                    $("#stparttime").val(getHM(d)).show();
                    $("#etparttime").val(getHM(DateAdd("h", 1, d))).show();
                }
            });
            if (check[0].checked) {
                $("#stparttime").val("00:00").hide();
                $("#etparttime").val("00:00").hide();
            }
            $("#Savebtn").click(function() { $("#fmEdit").submit(); });
            $("#Closebtn").click(function() { CloseModelWindow(); });
            $("#Deletebtn").click(function() {
                 if (confirm("Are you sure to remove this event")) {  
                    var param = [{ "name": "calendarId", value: 8}];                
                    $.post(DATA_FEED_URL + "/remove/",
                        param,
                        function(data){
                              if (data.IsSuccess) {
                                    alert(data.Msg); 
                                    CloseModelWindow(null,true);                            
                                }
                                else {
                                    alert("Error occurs.\r\n" + data.Msg);
                                }
                        }
                    ,"json");
                }
            });
            
           $("#stpartdate,#etpartdate").datepicker({ picker: "<button class='calpick'></button>"});    
            var cv =$("#colorvalue").val() ;
            if(cv=="")
            {
                cv="-1";
            }
            <!--$("#calendarcolor").colorselect({ title: "Color", index: cv, hiddenid: "colorvalue" });-->
            //to define parameters of ajaxform
            var options = {
                beforeSubmit: function() {
                    return true;
                },
                dataType: "json",
                success: function(data) {
                    //alert(data.Msg);
                    if (data.IsSuccess) {
                        CloseModelWindow(null,true);  
                    }
                }
            };
            $.validator.addMethod("date", function(value, element) {                             
                var arrs = value.split(i18n.datepicker.dateformat.separator);
                var year = arrs[i18n.datepicker.dateformat.year_index];
                var month = arrs[i18n.datepicker.dateformat.month_index];
                var day = arrs[i18n.datepicker.dateformat.day_index];
                var standvalue = [year,month,day].join("-");
                return this.optional(element) || /^(?:(?:1[6-9]|[2-9]\d)?\d{2}[\/\-\.](?:0?[1,3-9]|1[0-2])[\/\-\.](?:29|30))(?: (?:0?\d|1\d|2[0-3])\:(?:0?\d|[1-5]\d)\:(?:0?\d|[1-5]\d)(?: \d{1,3})?)?$|^(?:(?:1[6-9]|[2-9]\d)?\d{2}[\/\-\.](?:0?[1,3,5,7,8]|1[02])[\/\-\.]31)(?: (?:0?\d|1\d|2[0-3])\:(?:0?\d|[1-5]\d)\:(?:0?\d|[1-5]\d)(?: \d{1,3})?)?$|^(?:(?:1[6-9]|[2-9]\d)?(?:0[48]|[2468][048]|[13579][26])[\/\-\.]0?2[\/\-\.]29)(?: (?:0?\d|1\d|2[0-3])\:(?:0?\d|[1-5]\d)\:(?:0?\d|[1-5]\d)(?: \d{1,3})?)?$|^(?:(?:16|[2468][048]|[3579][26])00[\/\-\.]0?2[\/\-\.]29)(?: (?:0?\d|1\d|2[0-3])\:(?:0?\d|[1-5]\d)\:(?:0?\d|[1-5]\d)(?: \d{1,3})?)?$|^(?:(?:1[6-9]|[2-9]\d)?\d{2}[\/\-\.](?:0?[1-9]|1[0-2])[\/\-\.](?:0?[1-9]|1\d|2[0-8]))(?: (?:0?\d|1\d|2[0-3])\:(?:0?\d|[1-5]\d)\:(?:0?\d|[1-5]\d)(?:\d{1,3})?)?$/.test(standvalue);
            }, "Invalid date format");
            $.validator.addMethod("time", function(value, element) {
                return this.optional(element) || /^([0-1]?[0-9]|2[0-3]):([0-5][0-9])$/.test(value);
            }, "Invalid time format");
            $.validator.addMethod("safe", function(value, element) {
                return this.optional(element) || /^[^$\<\>]+$/.test(value);
            }, "$<> not allowed");
            
			$.validator.addMethod("patient", function(value, element) {
                return $("#patient_id_hidden").val()!='' ?true:false;
            }, "Select patient");
			
			$("#fmEdit").validate({
                submitHandler: function(form) { $("#fmEdit").ajaxSubmit(options); },
                errorElement: "div",
                errorClass: "cusErrorPanel",
                errorPlacement: function(error, element) {
                    showerror(error, element);
                }
            });
            function showerror(error, target) {
				var pos = target.position();
				var height = target.height();
		        var newpos = { left: pos.left, top: pos.top + height + 2 }
                var form = $("#fmEdit");             
                error.appendTo(form).css(newpos);
            }
        });
    </script>      
    <style type="text/css">     
    .calpick     {        
        width:16px;   
        height:16px;     
        border:none;        
        cursor:pointer;        
        background:url("/sample-css/cal.gif") no-repeat center 2px;        
        margin-left:-22px;    
    }      
    </style>
  </head>
  <body>    
    <div>      
      <div class="toolBotton">           
        <a id="Savebtn" class="imgbtn" href="javascript:void(0);">                
          <span class="Save"  title="Save the calendar">Save(<u>S</u>)
          </span>          
        </a>                           
        <?php if(isset($event)){ ?>
        <a id="Deletebtn" class="imgbtn" href="javascript:void(0);">                    
          <span class="Delete" title="Cancel the calendar">Delete(<u>D</u>)
          </span>                
        </a>             
        <?php } ?>            
        <a id="Closebtn" class="imgbtn" href="javascript:void(0);">                
          <span class="Close" title="Close the window" >Close
          </span></a>            
        </a>        
      </div>                  
      <div style="clear: both">         
      </div>        
      <div class="infocontainer">            
        <form action="/doctors/calendar_datafeed/adddetails/?<?php echo isset($event)?"&id=".$event['Appointment']['id']:""; ?>" class="fform" id="fmEdit" method="post">                 
                           
          <label>                    
            <span>*Time:
            </span>                    
            <div>  
              <?php if(isset($event)){
                  $sarr = explode(" ", $this->Calendar->php2JsTime($this->Calendar->mySql2PhpTime($event['Appointment']['starttime'])));
                  $earr = explode(" ", $this->Calendar->php2JsTime($this->Calendar->mySql2PhpTime($event['Appointment']['endtime'])));
              }else if(isset($startTime) && isset($endTime)){
				$sarr = explode(" ", $this->Calendar->php2JsTime($this->Calendar->mySql2PhpTime($startTime)));
                  $earr = explode(" ", $this->Calendar->php2JsTime($this->Calendar->mySql2PhpTime($endTime)));
			  }
			  ?>                    
              <input MaxLength="10" class="required date" id="stpartdate" name="stpartdate" style="padding-left:2px;width:90px;" type="text" value="<?php echo isset($sarr)?$sarr[0]:""; ?>" />                       
              <input MaxLength="5" class="required time" id="stparttime" name="stparttime" style="width:40px;" type="text" value="<?php echo isset($sarr)?$sarr[1]:""; ?>" />To                       
              <input MaxLength="10" class="required date" id="etpartdate" name="etpartdate" style="padding-left:2px;width:90px;" type="text" value="<?php echo isset($sarr)?$earr[0]:""; ?>" />                       
              <input MaxLength="50" class="required time" id="etparttime" name="etparttime" style="width:40px;" type="text" value="<?php echo isset($sarr)?$earr[1]:""; ?>" />                                            
              <label class="checkp"> 
                <input id="IsAllDayEvent" name="isalldayevent" type="checkbox" value="1" <?php if(isset($event)&&$event['Appointment']['isalldayevent']!=0) {echo "checked";} ?>/>          All Day Event                      
              </label>
            </div>                
          </label>
		<label>                    
            <span>*Patient:
            </span>                    
				<input id="patient_input" class="patient" style="display:<?php echo isset($event)?"none":"block" ?>;" />
				<input type="hidden"  value="<?php echo isset($event)?$event['Appointment']['patient_id']:"" ?>" id="patient_id_hidden" name="patient_id">
				<div id="patient_info_box" style="display:<?php echo isset($event)?"block":"none" ?>;">
					<div id="patient_info_box_inner">
						<?php echo isset($event)?$event['Patient']['first_name']." ".$event['Patient']['last_name']:"" ?>
						</BR>
						<?php echo isset($event)?$event['Patient']['email']:"" ?>
						</BR>
						<?php echo isset($event)?$event['Patient']['phone']:"" ?>
					</div>
					<a href="#" onclick="change_patient()">Change</a>
				</div>	
                            
          </label>
		  <div>                    
            <span>Doctor Notify:
            </span>                    
				
				<input id="doctor_notify_email" name="doctor_notify_email" type="checkbox" value="1" <?php if(isset($event)&&$event['Appointment']['doctor_notify_email']!=0) {echo "checked";} ?>/> Email &nbsp;&nbsp;
				<input id="doctor_notify_sms" name="doctor_notify_sms" type="checkbox" value="1" <?php if(isset($event)&&$event['Appointment']['doctor_notify_sms']!=0) {echo "checked";} ?>/> SMS    
          </div>
		  <div>                    
            <span>Patient Notify:
            </span>
				<input id="patient_notify_email" name="patient_notify_email" type="checkbox" value="1" <?php if(isset($event)&&$event['Appointment']['patient_notify_email']!=0) {echo "checked";} ?>/> Email &nbsp;&nbsp;
				
				<input id="patient_notify_sms" name="patient_notify_sms" type="checkbox" value="1" <?php if(isset($event)&&$event['Appointment']['patient_notify_sms']!=0) {echo "checked";} ?>/> SMS
          </div>
                        
          <label>                    
            <span>                        Treatments:
            </span>                    
<textarea cols="20" id="Description" name="treatments" rows="2" style="width:95%; height:70px">
<?php echo isset($event)?$event['Appointment']['treatments']:""; ?>
</textarea>                
          </label>                
          <input id="timezone" name="timezone" type="hidden" value="" />           
        </form>         
      </div>         
    </div>
  </body>
</html>