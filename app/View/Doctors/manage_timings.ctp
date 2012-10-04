<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title>Add Patient</title>

<link rel="stylesheet" type="text/css" media="screen" href="/css/chosen/chosen.css" />

<script src="/js/jquery-1.8.0.min.js" type="text/javascript"></script>    
<script src="/js/chosen/chosen.jquery.js" type="text/javascript"></script>
<script src="/js/jquery.jeditable.js" type="text/javascript"></script>
<script src="/js/calender/jquery.validate.js" type="text/javascript"></script>

</head>
<body>

<div id="main">


Manage Location & Timings:
<table width="100%">
<?php
foreach($address as $val){
	$flag=1;
	foreach($val['DoctorTiming'] as $val1){
?>
	<tr><td>
	<?php 
		echo $this->Util->daysNameList($val1['days']);
	?>
	</td><td><?php echo $val1['time_form']; ?>-<?php echo $val1['time_to']; ?></td><td><?php echo $val1['details']; ?></td>
	<?php if($flag){ ?>
	<td rowspan="<?php echo count($val['DoctorTiming']); ?>" valign="center"><?php echo $val['DoctorAddress']['address']; ?> <?php echo $val['DoctorAddress']['city']; ?> <?php echo $val['DoctorAddress']['pin']; ?></td>
	
	<td rowspan="<?php echo count($val['DoctorTiming']); ?>" valign="center"><?php  echo $this->Html->link('edit','manage_timings/'.$val['DoctorAddress']['id']); ; ?> </td>
	
	<?php } ?>
	</tr>
<?php
	$flag=0;
	}
}
?>
</table>
<?php if(isset($selectedAddress)){echo "Edit"; }else{ echo "Add"; } ?> Address



</div>
<script>
$(".chzn-select").chosen(); 
$(".chzn-select-deselect").chosen({allow_single_deselect:true}); 
</script>
</body>
</html>
