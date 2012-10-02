<div class="specialtyDiseaseLinkTypes form">
<?php echo $this->Form->create('SpecialtyDiseaseLinkType'); ?>
	<fieldset>
		<legend><?php echo __('Edit Specialty Disease Link Type'); ?></legend>
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

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('SpecialtyDiseaseLinkType.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('SpecialtyDiseaseLinkType.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Specialty Disease Link Types'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Link Specialties To Diseases'), array('controller' => 'link_specialties_to_diseases', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Link Specialties To Disease'), array('controller' => 'link_specialties_to_diseases', 'action' => 'add')); ?> </li>
	</ul>
</div>
