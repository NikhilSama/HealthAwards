<div class="linkDoctorsToSpecialties view">
<h2><?php  echo __('Link Doctors To Specialty'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($linkDoctorsToSpecialty['LinkDoctorsToSpecialty']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Doctor'); ?></dt>
		<dd>
			<?php echo $this->Html->link($linkDoctorsToSpecialty['Doctor']['id'], array('controller' => 'doctors', 'action' => 'view', $linkDoctorsToSpecialty['Doctor']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Specialty'); ?></dt>
		<dd>
			<?php echo $this->Html->link($linkDoctorsToSpecialty['Specialty']['name'], array('controller' => 'specialties', 'action' => 'view', $linkDoctorsToSpecialty['Specialty']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($linkDoctorsToSpecialty['LinkDoctorsToSpecialty']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($linkDoctorsToSpecialty['LinkDoctorsToSpecialty']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Link Doctors To Specialty'), array('action' => 'edit', $linkDoctorsToSpecialty['LinkDoctorsToSpecialty']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Link Doctors To Specialty'), array('action' => 'delete', $linkDoctorsToSpecialty['LinkDoctorsToSpecialty']['id']), null, __('Are you sure you want to delete # %s?', $linkDoctorsToSpecialty['LinkDoctorsToSpecialty']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Link Doctors To Specialties'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Link Doctors To Specialty'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Doctors'), array('controller' => 'doctors', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Doctor'), array('controller' => 'doctors', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Specialties'), array('controller' => 'specialties', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Specialty'), array('controller' => 'specialties', 'action' => 'add')); ?> </li>
	</ul>
</div>
