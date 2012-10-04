<div class="specialties view">
<h2><?php  echo __('Specialty'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($specialty['Specialty']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($specialty['Specialty']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($specialty['Specialty']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($specialty['Specialty']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Specialty'), array('action' => 'edit', $specialty['Specialty']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Specialty'), array('action' => 'delete', $specialty['Specialty']['id']), null, __('Are you sure you want to delete # %s?', $specialty['Specialty']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Specialties'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Specialty'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Link Doctors To Specialties'), array('controller' => 'link_doctors_to_specialties', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Link Doctors To Specialty'), array('controller' => 'link_doctors_to_specialties', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Link Specialties To Diseases'), array('controller' => 'link_specialties_to_diseases', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Link Specialties To Disease'), array('controller' => 'link_specialties_to_diseases', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Related Link Doctors To Specialties'); ?></h3>
	<?php if (!empty($specialty['LinkDoctorsToSpecialty'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Doctor Id'); ?></th>
		<th><?php echo __('Specialty Id'); ?></th>
		<th><?php echo __('Created'); ?></th>
		<th><?php echo __('Modified'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($specialty['LinkDoctorsToSpecialty'] as $linkDoctorsToSpecialty): ?>
		<tr>
			<td><?php echo $linkDoctorsToSpecialty['id']; ?></td>
			<td><?php echo $linkDoctorsToSpecialty['doctor_id']; ?></td>
			<td><?php echo $linkDoctorsToSpecialty['specialty_id']; ?></td>
			<td><?php echo $linkDoctorsToSpecialty['created']; ?></td>
			<td><?php echo $linkDoctorsToSpecialty['modified']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'link_doctors_to_specialties', 'action' => 'view', $linkDoctorsToSpecialty['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'link_doctors_to_specialties', 'action' => 'edit', $linkDoctorsToSpecialty['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'link_doctors_to_specialties', 'action' => 'delete', $linkDoctorsToSpecialty['id']), null, __('Are you sure you want to delete # %s?', $linkDoctorsToSpecialty['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Link Doctors To Specialty'), array('controller' => 'link_doctors_to_specialties', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?php echo __('Related Link Specialties To Diseases'); ?></h3>
	<?php if (!empty($specialty['LinkSpecialtiesToDisease'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Specialty Id'); ?></th>
		<th><?php echo __('Disease Id'); ?></th>
		<th><?php echo __('Specialty Disease Link Type Id'); ?></th>
		<th><?php echo __('Created'); ?></th>
		<th><?php echo __('Modified'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($specialty['LinkSpecialtiesToDisease'] as $linkSpecialtiesToDisease): ?>
		<tr>
			<td><?php echo $linkSpecialtiesToDisease['id']; ?></td>
			<td><?php echo $linkSpecialtiesToDisease['specialty_id']; ?></td>
			<td><?php echo $linkSpecialtiesToDisease['disease_id']; ?></td>
			<td><?php echo $linkSpecialtiesToDisease['specialty_disease_link_type_id']; ?></td>
			<td><?php echo $linkSpecialtiesToDisease['created']; ?></td>
			<td><?php echo $linkSpecialtiesToDisease['modified']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'link_specialties_to_diseases', 'action' => 'view', $linkSpecialtiesToDisease['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'link_specialties_to_diseases', 'action' => 'edit', $linkSpecialtiesToDisease['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'link_specialties_to_diseases', 'action' => 'delete', $linkSpecialtiesToDisease['id']), null, __('Are you sure you want to delete # %s?', $linkSpecialtiesToDisease['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Link Specialties To Disease'), array('controller' => 'link_specialties_to_diseases', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
