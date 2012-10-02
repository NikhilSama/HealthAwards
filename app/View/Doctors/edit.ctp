<div class="doctors form">
<?php echo $this->Form->create('Doctor'); ?>
	<fieldset>
		<legend><?php echo __('Edit Doctor'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('user_id');
		echo $this->Form->input('first_name');
		echo $this->Form->input('middle_name');
		echo $this->Form->input('last_name');
		echo $this->Form->input('phone');
		echo $this->Form->input('email');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('Doctor.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('Doctor.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Doctors'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Doctor Consult Locations'), array('controller' => 'doctor_consult_locations', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Doctor Consult Location'), array('controller' => 'doctor_consult_locations', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Experiences'), array('controller' => 'experiences', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Experience'), array('controller' => 'experiences', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Qualifications'), array('controller' => 'qualifications', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Qualification'), array('controller' => 'qualifications', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Link Doctors To Specialties'), array('controller' => 'link_doctors_to_specialties', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Link Doctors To Specialty'), array('controller' => 'link_doctors_to_specialties', 'action' => 'add')); ?> </li>
	</ul>
</div>
