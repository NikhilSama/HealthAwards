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
},"Mobile should be +912230333333");
$.validator.addMethod("pin", function(value, element)
{
	return this.optional(element) || /^[0-9]{6,10}$/i.test(value);
}, "Please enter a valid pin code.");

});
function changeCity(stateId,divID){
	
	$.ajax({
		url: '/util/gat_city_list/'+stateId,
        type:'post',
		//data:'phone_number='+ $('#phone_number').val(),
        success:function(data){
			$("#"+divID).html(data);
		}
    });
}

function changeState(countryId,divID,childDivId){
	$.ajax({
		url: '/util/gat_state_list/'+countryId+'/'+childDivId,
        type:'post',
		//data:'phone_number='+ $('#phone_number').val(),
        success:function(data){
			$("#"+divID).html(data);
		}
    });
}



function toggleText(cond,obj, defaultText) {
    if(cond==0 && obj.value == defaultText) {
        obj.value = '';
        $(obj).css('color','#000000');
        
        
    }else if(cond==1 && obj.value == '') {
        obj.value = defaultText;
        $(obj).css('color','#767676');
    }else {
}

}

function toggleCss(cond,obj, defaultClass) {
    
    if(cond==0 && obj.value == '' &&  $(obj).hasClass(defaultClass)) {
        $(obj).removeClass(defaultClass);
    }
    else if(cond==0 && obj.value != '' &&  $(obj).hasClass(defaultClass)) {
        $(obj).removeClass(defaultClass);//this for when user save password in browser with email address and email has typed in browser
    }else if(cond==1 && obj.value == '' &&  !$(obj).hasClass(defaultClass)) {
        $(obj).addClass(defaultClass);
    }else {
}
}


/* i add two function for iframe wise paging */
var flagOverView=false;
function getPagingLinkData(loction,updatingDivID){

    if($("#mnPagingFrame").get(0) == undefined) {
        $('<iframe id="mnPagingFrame" name="mnPagingFrame" height="0" width="0" onload="parent.updateParent(\''+updatingDivID+'\');">').appendTo('html');
    }
    if($('#LoadingDiv')){
        $('#LoadingDiv').show();
    }

    $('#mnPagingFrame').attr('src', loction);
    flagOverView = true;
    return false;
}
function updateParent(updatingDivID){
    var iframeId='mnPagingFrame';
    if(arguments.length==2)
        iframeId=arguments[1];
    $('#'+updatingDivID).html($('#'+iframeId).contents().find("body").html());
    if($('#LoadingDiv')){
        $('#LoadingDiv').hide();
    }
}
function is_ie6(){
    return (((window.XMLHttpRequest == undefined) && (ActiveXObject != undefined)));
}
function isEmail(email) {
    var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    return regex.test(email);
}
var jsDomainName;
function createCookie(name,value,days,seconds,domain) {
    if (days) {
        var date = new Date();
        date.setTime(date.getTime()+(days*24*60*60*1000));
        var expires = "; expires="+date.toGMTString();
    }
    else if (seconds) {
        var date = new Date();
        date.setTime(date.getTime()+(seconds*1000));
        var expires = "; expires="+date.toGMTString();
    }
    else var expires = "";

    if(domain)
        document.cookie = name+"="+value+expires+"; path=/; domain="+domain;
    else if(jsDomainName)
        document.cookie = name+"="+value+expires+"; path=/; domain="+jsDomainName;
    else 
        document.cookie = name+"="+value+expires+"; path=/";
}
function readCookie(name) {
    var nameEQ = name + "=";
    var ca = document.cookie.split(';');
    for(var i=0;i < ca.length;i++) {
        var c = ca[i];
        while (c.charAt(0)==' ') c = c.substring(1,c.length);
        if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
    }
    return null;
}

function eraseCookie(name) {
    createCookie(name,"",-1);
}


/* pop login function for ajax login*/

function startLogin(username,password,loader,err){
    var url='/users/login/ajax/'+new Date().getTime();
    $('#'+loader).src='/img/loader1.gif';
    $('#'+loader).show();
    $.ajax({
        type: "POST",
        url: url,
        data:'data[User][username]='+username+"&data[User][password]="+password,
        success: function(response){
            var obj = jQuery.parseJSON(response);
            if(obj.User.Error!=null)
            {
                document.getElementById(err).innerHTML=obj.User.Error;
                if(err=='login_error'&& document.getElementById('loginPopup').style.display=='none')
                {
                    document.getElementById('directLogin').style.display='inline';
                    $('#loginLoaderdirect').hide();
                    showPopupLogin();
                }
            }
            else{
                $('#loginPopup').css({
                    'height':'100px',
                    'color':'green'
                });
                $('#loginPopup').html('<div style="padding:20px">You are successful loggedin. And being redirect.<br /><b>Please wait...</b></div>');
                userLogin=true;
                Meritnation.userLogin=true; tb_remove();
                if(typeof(btnaction) != "undefined" && (btnaction=='ask' || btnaction=='expert')){ // Default action is Expert. So School talk is also working as expert action
                    if(btnaction=='ask')
                        submitReply('ask');
                    else if(btnaction=='expert' && Meritnation.loginFrom=='forceAsk'){
                        Meritnation.loginFrom='popup';
                        submitReply('forceAsk');
                    }
                    else
                        location.reload();
                }else{
                    if(Meritnation.lastAction=='submitReply'){
                         submitReply(Meritnation.messageId);
                         return false;
                    }else
                        location.reload();
                }
            }
            $('#'+loader).hide();

        }
    });
}

function LoginUser(){

    var username = $.trim($("#useridpop").val()) ;
    var password=$.trim($("#UserPasswordpop").val()) ;
    var length =  username.length;
    startLogin(username,password,'loginLoader','login_error');
    return false;
}
function doLogin(){

    var username = $.trim($("#userid").val()) ;
    var password=$.trim($("#userPassword").val()) ;
    var length =  username.length;
    startLogin(username,password,'loginLoaderNormal','login_error_normal');
    return false;
}

function showPopupLogin(){
    $('#loginPopup').slideToggle('fast');
    return false;
}
function directLogin(el){
    el.style.display='none';
    $('#loginLoaderdirect').src='/img/loader1.gif';
    $('#loginLoaderdirect').css("display","inline");

    var username = $.trim($("#userid1").val()) ;
    var password=$.trim($("#password1").val()) ;
    $("#useridpop").val(username);
    $("#UserPasswordpop").val(password);
    startLogin(username,password,'loginLoader','login_error');


    return false;
}
// end popup login

function urlencode(str) {
    str = (str + '').toString();
    return  encodeURIComponent(str).replace(/!/g, '%21').replace(/'/g, '%27').replace(/\(/g, '%28')
    .replace(/\)/g, '%29').replace(/\*/g, '%2A').replace(/~/g, '%7E').replace(/%20/g, '-');
}

function removeSpecialChars(elId) {
    var outputHtml = $("#"+elId).html();
    var iesearchvars = Array(
        '&there4;',
        '&perp;',
        '&rArr;',
        '&ang;',
        '&cong;',
        '&sim;',
        '&isin;',
        '&notin;',
        '&cup;',
        '&oplus;',
        '&sdot;',
        '&hArr;',
        '&prop;',
        '&nsub;',
        '&sub;',
        '&otimes;',
        '&and;',
        '&or;',
        '&sube;'
        );

    var iereplacevars = Array(
        '<span class="splChar">&#92;</span>',
        '<span class="splChar">&#94;</span>',
        '<span class="splChar">&#222;</span>',
        '<span class="splChar">&#208;</span>',
        '<span class="splChar">&#64;</span>',
        '<span class="splChar">&#126;</span>',
        '<span class="splChar">&#206;</span>',
        '<span class="splChar">&#207;</span>',
        '<span class="splChar">&#200;</span>',
        '<span class="splChar">&#197;</span>',
        '&bull;',
        '<span class="splChar">&#219;</span>',
        '<span class="splChar">&#181;</span>',
        '<span class="splChar">&#203;</span>',
        '<span class="splChar">&#204;</span>',
        '<span class="splChar">&#196;</span>',
        '<span class="splChar">&#217;</span>',
        '<span class="splChar">&#218;</span>',
        '<span class="splChar">&#205;</span>'
        );

    var othersearchvars = Array('&sim;',
        '&nu;',
        '&alpha;',
        '&gamma;',
        '&tau;'
        );

    var otherreplacevars = Array(  '<span class="splChar">&#126;</span>',
        '<span class="splChar">&#110;</span>',
        '<span class="splChar">&#97;</span>',
        '<span class="splChar">&#103;</span>',
        '<span class="splChar">&#116;</span>'
        );

    var allBrowsersSrc = Array(
        '&mnCross;',
        '&mnTick;',
        '&mnSq1;',
        '&mnSq2;',
        '&mnForE;',
        '&mnSuper;',
        '[[Page-break]]',
        '[[page-break]]',
        '[[Page-Break]]',
        '[[Page Break]]',
        '[[Page break]]',
        '[[page break]]'
        );

    var allBrowsersTarget = Array(
        '<img src="/img/text_cross.gif" align="absmiddle" />',
        '<img src="/img/text_tick.gif" align="absmiddle" />',
        '<span class="splChar">&#240;</span>',
        '<span class="splChar">&#128;</span>',
        '<span class="splChar">&#34;</span>',
        '<span class="splChar">&#202;</span>',
        '','','','','',''
        );
            
            
        
    if(/MSIE (\d+\.\d+);/.test(navigator.userAgent)) { // browser = IE 6
        var ieSearchVarLength = iesearchvars.length;
        var otherSearchVarLength = othersearchvars.length;
        for(i=0; i < ieSearchVarLength; i++) {
            outputHtml  = outputHtml.replace(iesearchvars[i],iereplacevars[i]);
        }
        for(j=0; j < otherSearchVarLength; j++) {
            outputHtml  = outputHtml.replace(othersearchvars[i],otherreplacevars[i]);
        }
    }
         
    // replace items for all browsers
    var allBrowsersSrcLength = allBrowsersSrc.length;
    for(k=0; k < allBrowsersSrcLength; k++) {
        outputHtml  = outputHtml.replace(allBrowsersSrc[k],allBrowsersTarget[k]);
    }
         
    $("#"+elId).html(outputHtml)  ;
      
}
var delayLayout = 3000;
var eleCountLayout = 0;
var showingLayout = 5;
var mniLayout = 0;
var toShowLayout = 0;
function moveLayout(mni) { 
	$('#activityItems').prepend($('#recent'+mni));
}
function shiftLayout() {
	toShowLayout = eval((parseInt(mniLayout) + parseInt(showingLayout)) % parseInt(eleCountLayout));	
	$('#recent'+toShowLayout).slideDown('slow');
	setTimeout('moveLayout('+mniLayout+')', 1000);		
	$('#recent'+mniLayout).slideUp('slow');
	setTimeout('moveLayout('+mniLayout+')',1000);
	mniLayout = eval((parseInt(mniLayout) + 1) % parseInt(eleCountLayout));
	setTimeout('shiftLayout()', delayLayout);
}















 
/* ############    Start code for  Error handling in user registration  ####################### */
var correctIcon = '<img border="0" align="absmiddle" src="/img/correct-icon.gif">';
var MSGTIMER = 20;
var errPointer = 'Right';
var MNMessageCss = 'MNMessageRight';
var MNMessageContentCss = 'MNMessageContentRight';
var MSGSPEED = 5;
var MSGOFFSET = 3;
var MSGHIDE = 3;
var TIMERVALUE=null;
var emailRegex = /^[a-z0-9!#$%&'*+\/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+\/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+(?:[a-z]{2,4}|museum|travel)$/i;
var mobileRegex =/^[0-9-()+ ]{10,15}$/;
var repeatedRegex =  /(.)\1{7}/;
var incrementRegex = /^((12345678)||(01234567)||(98765432))([0-9]{2,7})$/;
var existEmail = 0;
var tooltipShowStartTime;

function validMobile(mobile,len){
    if(len == undefined)
        len = 7;
    if (!isNaN(len)) {
        var numbers = "0123456789";
        var descending   = "9876543210";
        var start   = len - 1;
        var seq = "_" + mobile.slice(0, start);
        for (i = start; i < mobile.length; i++) {
            seq = seq.slice(1) + mobile.charAt(i);
            if (numbers.indexOf(seq) > -1 || descending.indexOf(seq) > -1) {
                return false;
            }
        }
    }
    return true;
}

var ieBrowserVersion = false;
if(is_ie6()){
    ieBrowserVersion = 6;
}
function validateRegForm(obj,errType){
    if(errType!='Email' && $('#forgotPwdLink').length){
        return;
    }
    var MNMessage;
    var MNMessageContent;
    var errMsg='';
    var tooltipShowAgainDate = new Date();
    tooltipShowStartTime=tooltipShowAgainDate.getTime();
    setTimeout('closeREegToolTip()',5000);
    
    if(arguments.length==3){
       
        if(arguments[2]=='d' && (ieBrowserVersion!=6 || (ieBrowserVersion==6 && errType!='Email' && errType!='Password'))){
            preverrPointer = errPointer
            errPointer = obj.id;
            MNMessageCss = 'MNMessageDown';
            MNMessageContentCss = 'MNMessageContentDown';
        }
        else if(arguments[2]=='u'  || (arguments[2]=='d' && ieBrowserVersion==6 && (errType=='Email' || errType=='Password'))){
            preverrPointer = errPointer
            errPointer = obj.id;
            MNMessageCss = 'MNMessageUp';
            MNMessageContentCss = 'MNMessageContentUp';
                
        }
        else if(arguments[2]=='Fd'){
            preverrPointer = errPointer
            errPointer = obj.id;
            MNMessageCss = 'MNMessageDown';
            MNMessageContentCss = 'MNMessageContentDown';
        }
        else{
            preverrPointer = errPointer
            errPointer = obj.id;
            MNMessageCss = 'MNMessageLeft';
            MNMessageContentCss = 'MNMessageContentLeft';
        }
        
        
    }else{
        preverrPointer = errPointer
        // errPointer = obj.id;
        errPointer = 'Right';
        MNMessageCss = 'MNMessageRight';
        MNMessageContentCss = 'MNMessageContentRight';
    }
    if($('#MNMessage'+preverrPointer))
        $('#MNMessage'+preverrPointer).hide();

    if(!$('#emailLoader')) {
        var src_name = $('#emailLoader').attr('src','/img/loader1.gif');
        if($('#emailLoader') && src_name!='-1')
            $('#emailLoader').hide();
    }
    if(!document.getElementById('MNMessage'+errPointer) ) {
        MNMessage = document.createElement('div');
        MNMessage.id = 'MNMessage'+errPointer;
        MNMessageContent = document.createElement('div');
        MNMessageContent.id = 'MNMessageContent'+errPointer;
        MNMessage.className =MNMessageCss;
        MNMessageContent.className  =MNMessageContentCss;
        MNMessage.style.zIndex='9999';
        document.body.appendChild(MNMessage);
        
       
        
        
        if(arguments[2]=='d' && (ieBrowserVersion!=6 || (ieBrowserVersion==6 && errType!='Email' && errType!='Password'))){
            var showArrows='<div class="formErrorArrow formErrorArrowBottom"><div class="line1"><!-- --></div><div class="line2"><!-- --></div><div class="line3"><!-- --></div><div class="line4"><!-- --></div><div class="line5"><!-- --></div><div class="line6"><!-- --></div><div class="line7"><!-- --></div><div class="line8"><!-- --></div><div class="line9"><!-- --></div><div class="line10"><!-- --></div></div>';
            $(MNMessage).append(showArrows);
        }
        if(arguments[2]=='Fd'){
            var showArrows='<div class="formErrorArrow formErrorArrowBottom"><div class="line1"><!-- --></div><div class="line2"><!-- --></div><div class="line3"><!-- --></div><div class="line4"><!-- --></div><div class="line5"><!-- --></div><div class="line6"><!-- --></div><div class="line7"><!-- --></div><div class="line8"><!-- --></div><div class="line9"><!-- --></div><div class="line10"><!-- --></div></div>';
            $(MNMessage).append(showArrows);
        }
        MNMessage.appendChild(MNMessageContent);
        if(arguments[2]=='u'  || (arguments[2]=='d' && ieBrowserVersion==6 && (errType=='Email' || errType=='Password'))){
            var showArrows='<div class="formErrorArrow formErrorArrowBottom"><div class="line10"><!-- --></div><div class="line9"><!-- --></div><div class="line8"><!-- --></div><div class="line7"><!-- --></div><div class="line6"><!-- --></div><div class="line5"><!-- --></div><div class="line4"><!-- --></div><div class="line3"><!-- --></div><div class="line2"><!-- --></div><div class="line1"><!-- --></div></div>';
            $(MNMessage).append(showArrows);
        }
    } else {
        MNMessage = document.getElementById('MNMessage'+errPointer);
        MNMessageContent = document.getElementById('MNMessageContent'+errPointer);
        MNMessage.className =MNMessageCss;
        MNMessageContent.className  =MNMessageContentCss;
        MNMessage.style.zIndex='9999';
    }
    if($('#errId'+errType)){
        $('#errId'+errType).hide();
    }
   
    if(errType=='Name'){
        var varNameRegExp=/[^a-zA-Z \.]+/g;
        //obj.value = obj.value.replace(varNameRegExp,'');/[^a-zA-Z \.]+/g
        if(obj.value=='' || (arguments[2]=='d' && obj.value=='Name'))
            errMsg = 'Name field is empty';
        else if(varNameRegExp.test(obj.value))
            errMsg = 'Name should contain a-z characters';
		
    }else if(errType=='Email'){
        $('#emailLoader').hide();
        var sobjValue=obj.value;
        iobjLength=sobjValue.length;
        iFposition=sobjValue.indexOf("@");
        iSposition=sobjValue.indexOf(".");
        iTmp=sobjValue.lastIndexOf(".");	
        iPosition=sobjValue.indexOf(",");
        iPos=sobjValue.indexOf(";");
        if(sobjValue==''){
            errMsg = 'E-mail id field is empty';
        }else if(sobjValue.indexOf("/")!= -1 || sobjValue.indexOf("#")!= -1 || sobjValue.indexOf("%")!= -1){
            errMsg = 'Email should not contain special character.';
        }else if(sobjValue.indexOf(" ")!= -1){
            errMsg = 'Email should not contain any spaces.';
        }else if(sobjValue.charAt(0) == "@" || sobjValue.charAt(0)=="."){
            errMsg = 'Email cannot start with "@" or "."';				
        }else if ((iobjLength-(iTmp+1)<2)||(iobjLength-(iTmp+1)>3)){
            errMsg = 'Your E-mail id is not complete. It should be like abc@example<span class="textRed bold">.com</span>';
        }else if(iSposition == -1){
            errMsg = 'You forgot to include .(dot) in your E-mail id.<br> For eg. abc@example<span class="textRed bold">.</span>com';
        }else if(iFposition == -1){
            errMsg = 'You forgot to include @ in your E-mail id. For eg. abc<span class="textRed bold">@</span>example.com';
        }else if ((iPosition!=-1) || (iPos!=-1)){
            errMsg = 'Email should not contain special characters like "," or ";"';
        }else if((sobjValue.indexOf("@",(iFposition+1)))!=-1){	
            errMsg = 'Your E-mail id cannot contain more than one <span class="textRed bold">@</span> character. For eg. abc@example.com';
        }else if(sobjValue=='abc@example.com') {
            errMsg = 'Please enter your own email id';
        }else if(!sobjValue.match(emailRegex)) {
            errMsg = 'Invalid E-mail id. E-mail should be like abc@example.com';
        }

    }else if(errType=='Password'){
        errMsg = passwordValidate(obj.value);
        if(errMsg=='') {
            showImage(errType);
        }
        if($('#UserConfirmpassword') && $('#UserConfirmpassword').val()!='' && obj.value==$('#UserConfirmpassword').val()){
            $('#MNMessageUserConfirmpassword').hide();
            if($('#UserConfirmpassword').attr('class')=='errClass') {
                $('#UserConfirmpassword').removeClass('errClass');
                showImage('Confirmpassword');
            }
        }

    }else if(errType=='Confirmpassword'){
        if(obj.value==''){
            errMsg = 'Confirm password field is empty';
        }else if(obj.value!=$('#UserPassword').val()){
            errMsg = 'Passwords do not match';
        }else if(obj.value==$('#UserPassword').val()){
            if(passwordValidate($('#UserPassword').val())==''){
                $('#MNMessageUserPassword').hide();
                if($('#UserPassword').attr('class')=='errClass') {
                    $('#UserPassword').removeClass('errClass');
                    showImage('Password');
                }
            }
            showImage(errType);
        }
    }else if(errType=='Board'){
        if(obj.value==''){
            errMsg = 'Select your Board from the list';
        }else if(errMsg=='') {
            showImage(errType);
        }
    }else if(errType=='Class'){
        if(obj.value==''){	
            errMsg = 'Select your class from the list';
        }else if(errMsg=='') {
            showImage(errType);
        }
    }else if(errType=='userType'){
        if(obj.value==''){    
            errMsg = 'Describe yourself using any one of the options';
        }else if(errMsg=='') {
            showImage(errType);
        }
    }else if(errType=='Mobile'){
        if(obj.value=='')
            errMsg = 'Type your mobile number';
        else if(!obj.value.match(mobileRegex) || obj.value.match(repeatedRegex) || !validMobile(obj.value))
            errMsg = 'Invalid mobile number';
        else if(errMsg=='') {
            showImage(errType);
        }
    }else if(errType=='OldPassword') {
        errMsg = passwordValidate(obj.value);
        if(errMsg=='')
            showImage(errType);
    }else if(errType=='Country'){
        if(obj.value==''|| obj.value=='0'){    
            errMsg = 'Select Country';
        }else if(errMsg=='') {
            showImage(errType);
        }
    }else if(errType=='State'){
        if(obj.value==''|| obj.value=='0'){
            errMsg = 'Select State';
        }else if(errMsg=='') {
            showImage(errType);
        }
    }
    if($('#chkAvail') && errType=='Email')
        $('#chkAvail').hide();
    if(obj.value=='' || errMsg!=''){
        if($('#'+obj.id+' span')) 
            $('#'+obj.id+' span').addClass('errClass');
        else    
            $('#'+obj.id).addClass('errClass');
        MNMessageContent.innerHTML=(errMsg!='' ? errMsg : errType+' is empty.');
        MNMessage.style.display='block';
        var msgheight = MNMessage.offsetHeight;
        var msgwidth = MNMessage.offsetWidth;
        var targetheight = obj.offsetHeight;
        var targetwidth = obj.offsetWidth;
        
        var topposition = topPosition(obj) - ((msgheight - targetheight) / 2);
        var leftposition = leftPosition(obj);
        if(errType=='userType'){
            if(errPointer != 'Right')
                leftposition =leftposition+30;
        }
        if(errPointer == 'Right')
            leftposition = leftposition-msgwidth-10;
        else{
                        
            if(arguments[2]=='d' && (ieBrowserVersion!=6 || (ieBrowserVersion==6 && errType!='Email' && errType!='Password'))){
                leftposition = leftposition;
                topposition=topPosition(obj)+targetheight;
            }
            else if(arguments[2]=='Fd'){
                leftposition = leftposition;
                topposition=topPosition(obj)+targetheight;
            }
            else if(arguments[2]=='u'  || (arguments[2]=='d' && ieBrowserVersion==6 && (errType=='Email' || errType=='Password'))){
                leftposition = leftposition;
                topposition=topPosition(obj)-msgheight;
            }
            else{
                leftposition = leftposition + targetwidth + MSGOFFSET;
            }
        }
            
        MNMessage.style.top = topposition + 'px';
        MNMessage.style.left = leftposition + 'px';
        return false;
    }else{
        if($('#'+obj.id).parent('span') && $('#'+obj.id).parent('span').attr('class')=='errClass')
            $('#'+obj.id).parent('span').removeClass('errClass');
        else if($(obj).attr('class')=='errClass')
            $('#'+obj.id).removeClass('errClass');

        MNMessage.style.display='none';
        MNMessageContent.innerHTML='';
    }
    return true;
}
function closeREegToolTip(){
    var currentime=new Date();
    currentime=currentime.getTime();
    var seconds=(currentime-tooltipShowStartTime)/(1000);
    if(seconds>=5){
        if($('#MNMessage'+errPointer)){
            $('#MNMessage'+errPointer).hide();
        }
        if($('#forgotPwdLink').length && $('#forgotPwdLink').parent(0).attr('id')=='MNMessageContentUserEmail')
            $('#forgotPwdLink').parent(0).html('');
    }
    setTimeout('closeREegToolTip()',1000);
        
}
function passwordValidate(val){
    var err='';
    if(val==''){
        err = 'Password field is empty';
    }else if(val.length < 4) {
        err = 'Password should have minimum 4 characters';
    }else if(val.indexOf(" ")!= -1) {
        err = 'Spaces not allowed in password';
    }else if(val.length > 20) {
        err = 'Password should not exceed more than 20 characters';
    }
    return err;
}
function showImage(errType) {
    if($('#errId'+errType)){
        $('#errId'+errType).attr('style','display:inline');
        $('#errId'+errType).html(correctIcon);
        $('#errId'+errType).attr('class','');
    }
}
// calculate the position of the element in relation to the left of the browser //
function leftPosition(target) {
    var left = 0;
    if(target.offsetParent) {
        while(1) {
            left += target.offsetLeft;
            if(!target.offsetParent) {
                break;
            }
            target = target.offsetParent;
        }
    } else if(target.x) {
        left += target.x;
    }
    return left;
}

// calculate the position of the element in relation to the top of the browser window //
function topPosition(target) {
    var top = 0;
    if(target.offsetParent) {
        while(1) {
            top += target.offsetTop;
            if(!target.offsetParent) {
                break;
            }
            target = target.offsetParent;
        }
    } else if(target.y) {
        top += target.y;
    }
    return top;
}

// preload the arrow //
if(document.images) {
    arrow = new Image(7,80); 
    arrow.src = "/img/home/msg_arrow_right.gif"; 
    arrow1 = new Image(7,80); 
    arrow1.src = "/img/home/msg_arrow_left.gif"; 
    loader = new Image(88,88); 
    loader.src = "/img/loader.gif"; 
    loader2 = new Image(60,60); 
    loader2.src = "/img/loader2.gif"; 
}



function checkAvalability(obj,pos){
    var email = obj.value;
    email = $.trim(email);
    var length = email.length;
    if(length>0){
        var url='/util/checkAvalibility/'+new Date().getTime();
        
        if($('#emailLoader')){
            $('#emailLoader').src='/img/loader1.gif';
            $('#emailLoader').show();
        }
        
        $.ajax({
            type: "POST",
            url: url,
            data:'email='+email,
            success: function(response){
                var errType='Email';
                if(response.indexOf('success')>=0) {
                    existEmail = 0;
                    if($('#emailLoader'))
                        $('#emailLoader').attr('src','/img/correct-icon.gif');
                }else{
                    if($('#emailLoader'))
                        $('#emailLoader').hide();
                    /////////////////////////////
                    existEmail = 1;
                    errPointer = 'Right';
                    MNMessageCss = 'MNMessageRight';
                    MNMessageContentCss = 'MNMessageContentRight';
                    
                    if(pos=='1') {
                        preverrPointer = errPointer
                        errPointer = obj.id;
                        MNMessageCss = 'MNMessageLeft';
                        MNMessageContentCss = 'MNMessageContentLeft';
                        if($('#MNMessage'+preverrPointer))
                            $('#MNMessage'+preverrPointer).hide();
                    }
                    else if(pos=='d' && (ieBrowserVersion!=6 || (ieBrowserVersion==6 && errType!='Email'))) {
                        preverrPointer = errPointer
                        errPointer = obj.id;
                        MNMessageCss = 'MNMessageDown';
                        MNMessageContentCss = 'MNMessageContentDown';
                        if($('#MNMessage'+preverrPointer))
                            $('#MNMessage'+preverrPointer).hide();
                    }
                    else if(pos=='u'  || (pos=='d' && ieBrowserVersion==6 && (errType=='Email'))){
                        preverrPointer = errPointer
                        errPointer = obj.id;
                        MNMessageCss = 'MNMessageUp';
                        MNMessageContentCss = 'MNMessageContentUp';
                        if($('#MNMessage'+preverrPointer))
                            $('#MNMessage'+preverrPointer).hide();
                    }
                    else{
                        preverrPointer = errPointer
                        // errPointer = obj.id;
                        errPointer = 'Right';
                        MNMessageCss = 'MNMessageRight';
                        MNMessageContentCss = 'MNMessageContentRight';
                    }
                    if(!document.getElementById('MNMessage'+errPointer)) {
                        MNMessage = document.createElement('div');
                        MNMessage.id = 'MNMessage'+errPointer;
                        MNMessageContent = document.createElement('div');
                        MNMessageContent.id = 'MNMessageContent'+errPointer;
                        MNMessage.className =MNMessageCss;
                        MNMessageContent.className  =MNMessageContentCss;
                        document.body.appendChild(MNMessage);
                       
                        if(pos=='d' && (ieBrowserVersion!=6 || (ieBrowserVersion==6 && errType!='Email'))){
                            var showArrows='<div class="formErrorArrow formErrorArrowBottom"><div class="line1"><!-- --></div><div class="line2"><!-- --></div><div class="line3"><!-- --></div><div class="line4"><!-- --></div><div class="line5"><!-- --></div><div class="line6"><!-- --></div><div class="line7"><!-- --></div><div class="line8"><!-- --></div><div class="line9"><!-- --></div><div class="line10"><!-- --></div></div>';
                            $(MNMessage).append(showArrows);
                        }
                        
                        
                        
                        MNMessage.appendChild(MNMessageContent);
                        if(pos=='u'  || (pos=='d' && ieBrowserVersion==6 && (errType=='Email'))){
                            var showArrows='<div class="formErrorArrow formErrorArrowBottom"><div class="line10"><!-- --></div><div class="line9"><!-- --></div><div class="line8"><!-- --></div><div class="line7"><!-- --></div><div class="line6"><!-- --></div><div class="line5"><!-- --></div><div class="line4"><!-- --></div><div class="line3"><!-- --></div><div class="line2"><!-- --></div><div class="line1"><!-- --></div></div>';
                            $(MNMessage).append(showArrows);
                        }
                        MNMessage.style.zIndex='9999';
                    } else {
                        MNMessage = document.getElementById('MNMessage'+errPointer);
                        MNMessageContent = document.getElementById('MNMessageContent'+errPointer);
                        MNMessage.className =MNMessageCss;
                        MNMessageContent.className  =MNMessageContentCss;
                        MNMessage.style.zIndex='9999';
                    }
                   
                    errMsg = 'You already have an account.<br /><a id="forgotPwdLink" style="color:#ffffff;text-decoration:underline;" href="/users/forgotpassword/'+email+'?mncid=regForgotLink">Click here to get your password</a>';
                    
                    if($('#'+obj.id).parent('span'))
                        $('#'+obj.id).parent('span').addClass('errClass');	
                    else    
                        $('#'+obj.id).addClass('errClass');
                    
                    
                    MNMessageContent.innerHTML = (errMsg!='' ? errMsg : errType+' is empty.');
                    MNMessage.style.display = 'block';
                    var msgheight = MNMessage.offsetHeight;
                    var msgwidth = MNMessage.offsetWidth;
                    var targetheight = obj.offsetHeight;
                    var targetwidth = obj.offsetWidth;
                    var topposition = topPosition(obj) - ((msgheight - targetheight) / 2);
                    var leftposition = leftPosition(obj);
                    if(errPointer == 'Right')
                        leftposition = leftposition-msgwidth-10;
                    else if(pos=='d' && (ieBrowserVersion!=6 || (ieBrowserVersion==6 && errType!='Email'))){
                        leftposition = leftposition;
                        topposition=topPosition(obj)+targetheight;
                    }
                    else if(pos=='u'  || (pos=='d' && ieBrowserVersion==6 && (errType=='Email'))){
                        leftposition = leftposition;
                        topposition=topPosition(obj)-msgheight;
                    }
                    else
                        leftposition = leftposition + targetwidth + MSGOFFSET;
                    MNMessage.style.top = topposition + 'px';
                    MNMessage.style.left = leftposition + 'px';
                    return false;
                /////////////////////////////
                }
            }
        });
    }
}

/* ############    End code for  Error handling in user registration  ####################### */
