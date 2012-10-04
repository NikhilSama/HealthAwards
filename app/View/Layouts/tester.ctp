<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $title_for_layout;?></title>
<link rel="icon" href="<?php echo $this->request->webroot . 'meritnation.ico';?>" type="image/x-icon" />
<link rel="shortcut icon" href="<?php echo $this->request->webroot . 'meritnation.ico';?>" type="image/x-icon" />
<?php	
	$str= $this->Html->css('style');
	echo str_replace('style.css','style.css?version='.MN_CSS_VERSION,$str);
	echo $this->Javascript->link('jquery-1.7.min.js');
	$mainJs = $this->Html->script('main.js');
	echo str_replace('main.js','main.js?version='.MN_JS_VERSION,$mainJs);
?>
</head>
<head>
<body>
<div class="background">
	<div class="main">
        <div class="header">
			<div class="topnav">
				<?php if($this->Session->check('Tester')){ ?>
					<?php  echo $this->Html->image('home-img.jpg',array('hspace'=>'7','border'=>'0','alt'=>'','url'=>'/testers/index'));?>
					<?php  echo $this->Html->link("Tester's zone",'/testers/index',array("class"=>"current"),null,false);?>
					<?php  echo $this->Html->link('Logout','/testers/logout',null,null,false);?>
				<?php }else{ ?>
					<span>
					<?php  echo $this->Html->image('home-img.jpg',array('hspace'=>'7','border'=>'0','alt'=>'','url'=>'/testers/login'));?>
					<?php  echo $this->Html->link("Tester's zone",'/testers/login',array("class"=>"current"),null,false);?>
					<?php  echo $this->Html->link('Login','/testers/login',null,null,false);?>
					</span>
					
				<?php } ?>
			</div>
			<div style="margin-top:30px">
				<?php echo $this->Html->image('fore-logo2.jpg',array('hspace'=>'20'));?>
			</div>
		</div>
		<span id="TIME"></span>
		<?php  echo $this->Element('tester_mainmenu');?>
		<?php echo $this->Element('tester_submenu');?>
        <div class="left_layout"></div>
		<div class="content">
			<?php
				if(isset($isTesterAccessible) && $isTesterAccessible=='0'){
					echo '<div align="center"style="padding-top:150px" class="textRed"><h1>Action Prohibited!!!</h1></div>';
				}else{
					echo $content_for_layout;
				}
			?>
		</div>
		<?php echo $this->Element('footer');?>
		<?php echo $this->element('sql_dump'); ?>
	</div>
</div>
<script>
	function updateTime(){
		date.setSeconds (1+date.getSeconds());
		document.getElementById('TIME').innerHTML = formatDate(date);
	}

	function formatDate(d){
		var m_names = new Array("January", "February", "March", 
			"April", "May", "June", "July", "August", "September", 
			"October", "November", "December");
		var a_p = "";
		
		var curr_hour = d.getHours();
		//alert(curr_hour);
		if (curr_hour < 12) {
			a_p = "AM";
		}else {
			a_p = "PM";
		}
		if (curr_hour == 0){
			curr_hour = 12;
		}
		if (curr_hour > 12){
			curr_hour = curr_hour - 12;
		}

		var curr_min = d.getMinutes();
		curr_min = curr_min + "";

		if (curr_min.length == 1) {
			curr_min = "0" + curr_min;
		}
		var curr_sec = d.getSeconds();

		curr_sec = curr_sec + "";

		if (curr_sec.length == 1) {
			curr_sec= "0" + curr_sec;
		}

		output = m_names[d.getMonth()]+" "+d.getDate()+", "+d.getFullYear();
		output += "  "+curr_hour + ":" + curr_min  + ":" + curr_sec  + " " + a_p
		return output;
	}
	var date = new Date(<?php echo date("Y,m-1,d,H,i,s") ?>);
	updateTime();
	setInterval('updateTime()', 1000 );
</script>
</body>
</html>