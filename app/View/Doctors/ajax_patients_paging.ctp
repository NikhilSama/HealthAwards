<?php
	foreach ($patients as $patient) :
		//	pr($patient);
?>
	<div class="patient-box">
			<?php if($patient['pp']['photo']){ ?>
				<span class="user-image" src="<?php echo $patient['pp']['photo']; ?>"></span>
				<!--<img src="/img/patient_pics/<?php echo $patient['pp']['photo']; ?>">-->
			<?php }else{ ?>
				<img src="/img/picture.jpg">
			<?php } ?>
		<div class="detail">
			<h3><?php echo $patient['pp']['name'] ?></h3>
			<?php echo $patient['pp']['email_primary'] ?><br>
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