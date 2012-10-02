<div class="consultLocationTypes form">
<?php echo $this->Form->create('ConsultLocationType'); ?>
	<fieldset>
		<legend><?php echo __('Edit Consult Location Type'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('name');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('ConsultLocationType.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('ConsultLocationType.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Consult Location Types'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Doctor Consult Locations'), array('controller' => 'doctor_consult_locations', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Doctor Consult Location'), array('controller' => 'doctor_consult_locations', 'action' => 'add')); ?> </li>
	</ul>
</div>
