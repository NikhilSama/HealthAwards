<div class="specialties form">
<?php echo $this->Form->create('Specialty'); ?>
	<fieldset>
		<legend><?php echo __('Add Specialty'); ?></legend>
	<?php
		echo $this->Form->input('name');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Specialties'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Link Doctors To Specialties'), array('controller' => 'link_doctors_to_specialties', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Link Doctors To Specialty'), array('controller' => 'link_doctors_to_specialties', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Link Specialties To Diseases'), array('controller' => 'link_specialties_to_diseases', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Link Specialties To Disease'), array('controller' => 'link_specialties_to_diseases', 'action' => 'add')); ?> </li>
	</ul>
</div>
