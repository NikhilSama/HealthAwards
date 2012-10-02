<div class="linkDoctorsToSpecialties form">
<?php echo $this->Form->create('LinkDoctorsToSpecialty'); ?>
	<fieldset>
		<legend><?php echo __('Edit Link Doctors To Specialty'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('doctor_id');
		echo $this->Form->input('specialty_id');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('LinkDoctorsToSpecialty.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('LinkDoctorsToSpecialty.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Link Doctors To Specialties'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Doctors'), array('controller' => 'doctors', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Doctor'), array('controller' => 'doctors', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Specialties'), array('controller' => 'specialties', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Specialty'), array('controller' => 'specialties', 'action' => 'add')); ?> </li>
	</ul>
</div>
