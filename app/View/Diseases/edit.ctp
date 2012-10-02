<div class="diseases form">
<?php echo $this->Form->create('Disease'); ?>
	<fieldset>
		<legend><?php echo __('Edit Disease'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('name');
		echo $this->Form->input('LinkSpecialtiesToDisease');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('Disease.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('Disease.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Diseases'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Link Specialties To Diseases'), array('controller' => 'link_specialties_to_diseases', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Link Specialties To Disease'), array('controller' => 'link_specialties_to_diseases', 'action' => 'add')); ?> </li>
	</ul>
</div>
