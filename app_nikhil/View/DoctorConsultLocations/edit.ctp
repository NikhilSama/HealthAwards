<div class="doctorConsultLocations form">
<?php echo $this->Form->create('DoctorConsultLocation'); ?>
	<fieldset>
		<legend><?php echo __('Edit Doctor Consult Location'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('location_id');
		echo $this->Form->input('doctor_id');
		echo $this->Form->input('consult_location_type_id');
		echo $this->Form->input('addl');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('DoctorConsultLocation.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('DoctorConsultLocation.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Doctor Consult Locations'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Locations'), array('controller' => 'locations', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Location'), array('controller' => 'locations', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Doctors'), array('controller' => 'doctors', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Doctor'), array('controller' => 'doctors', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Consult Location Types'), array('controller' => 'consult_location_types', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Consult Location Type'), array('controller' => 'consult_location_types', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Consult Timings'), array('controller' => 'consult_timings', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Consult Timing'), array('controller' => 'consult_timings', 'action' => 'add')); ?> </li>
	</ul>
</div>
