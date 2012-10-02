<div class="linkSpecialtiesToDiseases form">
<?php echo $this->Form->create('LinkSpecialtiesToDisease'); ?>
	<fieldset>
		<legend><?php echo __('Edit Link Specialties To Disease'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('specialty_id');
		echo $this->Form->input('disease_id');
		echo $this->Form->input('specialty_disease_link_type_id');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('LinkSpecialtiesToDisease.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('LinkSpecialtiesToDisease.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Link Specialties To Diseases'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Specialties'), array('controller' => 'specialties', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Specialty'), array('controller' => 'specialties', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Diseases'), array('controller' => 'diseases', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Disease'), array('controller' => 'diseases', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Specialty Disease Link Types'), array('controller' => 'specialty_disease_link_types', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Specialty Disease Link Type'), array('controller' => 'specialty_disease_link_types', 'action' => 'add')); ?> </li>
	</ul>
</div>
