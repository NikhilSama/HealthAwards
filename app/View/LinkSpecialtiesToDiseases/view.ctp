<div class="linkSpecialtiesToDiseases view">
<h2><?php  echo __('Link Specialties To Disease'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($linkSpecialtiesToDisease['LinkSpecialtiesToDisease']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Specialty'); ?></dt>
		<dd>
			<?php echo $this->Html->link($linkSpecialtiesToDisease['Specialty']['name'], array('controller' => 'specialties', 'action' => 'view', $linkSpecialtiesToDisease['Specialty']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Disease'); ?></dt>
		<dd>
			<?php echo $this->Html->link($linkSpecialtiesToDisease['Disease']['name'], array('controller' => 'diseases', 'action' => 'view', $linkSpecialtiesToDisease['Disease']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Specialty Disease Link Type'); ?></dt>
		<dd>
			<?php echo $this->Html->link($linkSpecialtiesToDisease['SpecialtyDiseaseLinkType']['name'], array('controller' => 'specialty_disease_link_types', 'action' => 'view', $linkSpecialtiesToDisease['SpecialtyDiseaseLinkType']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($linkSpecialtiesToDisease['LinkSpecialtiesToDisease']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($linkSpecialtiesToDisease['LinkSpecialtiesToDisease']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Link Specialties To Disease'), array('action' => 'edit', $linkSpecialtiesToDisease['LinkSpecialtiesToDisease']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Link Specialties To Disease'), array('action' => 'delete', $linkSpecialtiesToDisease['LinkSpecialtiesToDisease']['id']), null, __('Are you sure you want to delete # %s?', $linkSpecialtiesToDisease['LinkSpecialtiesToDisease']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Link Specialties To Diseases'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Link Specialties To Disease'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Specialties'), array('controller' => 'specialties', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Specialty'), array('controller' => 'specialties', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Diseases'), array('controller' => 'diseases', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Disease'), array('controller' => 'diseases', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Specialty Disease Link Types'), array('controller' => 'specialty_disease_link_types', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Specialty Disease Link Type'), array('controller' => 'specialty_disease_link_types', 'action' => 'add')); ?> </li>
	</ul>
</div>
