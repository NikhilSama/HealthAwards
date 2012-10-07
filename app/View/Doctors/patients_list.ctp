<?php
if ($this->Session->check('Message.flash')) {
    echo $this->Session->flash();
 } ?>
 <link href="/css/calender/dailog.css" rel="stylesheet" type="text/css" />
    <link href="/css/calender/main.css" rel="stylesheet" type="text/css" /> 
    
	<script src="/js/calender/Common.js" type="text/javascript"></script> 
    <script src="/js/calender/jquery.ifrmdailog.js" defer="defer" type="text/javascript"></script>
 <script type="text/javascript">
 var isIframeOpen=0;
        $(document).ready(function() {
			imageLoad();
			$("#add_patient_link").click(function(e) {
				isIframeOpen=1;
                var url ="/doctors/add_patient/";
             	OpenModelWindow(url,{ width: 600, height: 400, caption:"Add New Patient",onclose:function(){
					
					getPatientsList(0);
					   //isIframeOpen=0;
                    }});
            });
			});
			function editPatient(userId){
				var url ="/doctors/add_patient/"+userId;
             	OpenModelWindow(url,{ width: 600, height: 400, caption:"edit Patient",onclose:function(){
					//$("#gridcontainer").reload();
					   //isIframeOpen=0;
					   alert(1);
                    }});
			}
 </script>
<div class="mainpage">
	<div class="left-container"><br><br>
		<input class="search" type="text" name="searchbox" id="searchbox" oldvalue="" onkeyUp="getPatientsList()">
		<br>
		<a class="find-p" href="#">Find a patient</a>
		<a class="add-p" href="#" id="add_patient_link">Add a patient</a>
	</div>
	<div class="right-container"><br><br> 
		<div class="sorting-option"><b>Sort :</b> 
		<?php foreach($sortByArr as $key=>$val){ ?>
			<a href="javascript:void(0);" onclick="setSortBy(<?php echo $key;?>)"><?php echo $val['dName'];?></a> 
		<?php } ?>
		 <?php foreach($sortTypeArr as $key=>$val){ ?>
			<a href="javascript:void(0);" onclick="setSortType(<?php echo $key;?>)"><?php echo $val['dName'];?></a>
		<?php } ?>
		</div>
		<div id="posts-container">
			<?php
				foreach ($patients as $patient) :
						//pr();
			?>
				<div class="patient-box">
					<?php if($patient['pp']['image']){ ?>
						<span class="user-image" src="<?php echo $patient['pp']['image']; ?>"></span>
					<?php }else{ ?>
						<img src="/img/picture.jpg">
					<?php } ?>
					<div class="detail">
						<h3 onclick="editPatient(<?php echo $patient['pp']['user_id']; ?>)"><?php echo $patient['pp']['first_name'] ?> <?php echo $patient['pp']['last_name'] ?></h3>
						<?php echo $patient['pp']['email'] ?><br>
						<?php echo $patient['0']['noOfAppointments'] ?> Appointments
					</div>
					<div class="clear"></div>
					<?php if($patient['0']['lastAppointments']){ ?>
					<span class="dark-grey">Last Visit: <?php echo $this->Util->timeAgo($patient['0']['lastAppointments']); ?> with Dr. Chawla</span>
					<?php } ?>
				</div>
			<?php
				endforeach;
			?>
			<?php
				echo "<div class='paging'>";
				echo $this->Paginator->prev('<< '.__('previous', true), array(), null, array('class'=>'disabled')); 
				echo $this->Paginator->numbers(); 
				echo $this->Paginator->next(__('next', true).' >>', array('id'=>'next'), null, array('class' => 'disabled')); 
				echo "</div>";
			?>

		</div>

	</div>
</div>

<script>
	var sortType =1;
	var sortBy =1;
	function setSortType(val){
		sortType = val;
		getPatientsList(0);
	}
	function setSortBy(val){
		sortBy = val;
		getPatientsList(0);
	}
	
	function getPatientsList(flag){
			var searchboxval = $('#searchbox').val();
			var oldvalue = $('#searchbox').attr('oldvalue');
			if(flag!=0 && (searchboxval==oldvalue || searchboxval.length<3)) return;
			$('#searchbox').attr('oldvalue',searchboxval);
			$(".paging").remove(); // remove the old pagination links because new ones will be loaded via ajax
           	$("#posts-container").load('/doctors/patients_list',  {searchword: searchboxval,sortBy:sortBy,sortType:sortType},function(response, status, xhr) {
				if (status == "error") {
				  var msg = "Sorry but there was an error: ";
				  alert(msg + xhr.status + " " + xhr.statusText);
				}
				else {
				imageLoad();
					$(this).attr("class","loaded"); //change the class name so it will not be confused with the next batch
					$(".paging").hide(); //hide the new paging links
					$(this).fadeIn();

				}
			});
	}

	$(".paging").hide();  //hide the paging for users with javascript enabled
	$(window).scroll(function(){ 
		//if(isIframeOpen) return;
		var position = ($(document).height() - $(window).height());
		console.log($(window).scrollTop()+"=="+ position+"=="+$(document).height() +"=="+ $(window).height());
        if  ($(window).scrollTop() == position){  //If scrollbar is at the bottom
			loadPagingData();			
        }
	});
	 $(document).ready(function() {
		if($(document).height() == $(window).height()){
			loadPagingData();
		}
	 });
	function loadPagingData(){
		var url = $("a#next").attr("href"); //extract the URL from the "next" link
			$(".paging").remove(); // remove the old pagination links because new ones will be loaded via ajax
			if(url){
           	
				var classname='div'+Math.floor(Math.random()*99999999999).toString();
				$("#posts-container").append("<div class='"+classname+"'>loding</div>"); //append a container to hold ajax content
				$("div."+classname).load(url,  {searchword: $('#searchbox').val(),sortBy:sortBy,sortType:sortType},function(response, status, xhr) {
					if (status == "error") {
					  var msg = "Sorry but there was an error: ";
					  alert(msg + xhr.status + " " + xhr.statusText);
					}
					else {
						imageLoad();
						$(this).attr("class","loaded"); //change the class name so it will not be confused with the next batch
						$(".paging").hide(); //hide the new paging links
						$(this).fadeIn();
						if($(document).height() == $(window).height()){
							loadPagingData();
						}
						

					}
				});
				
			}
	}
function imageLoad(){
	$('.user-image').each(
	function(){	
		var obj = $(this);
		var src = obj.attr('src');
		$.ajax({ type: "POST",
		cache: true,
		data: { src: src },
	  url: '/util/getUserImage/',
	  success: function(data) {
			obj.append("<img src='"+data+"' />");
			obj.removeClass('user-image');
	  }
	});
	}
	);
}
</script>