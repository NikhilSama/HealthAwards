<div class="doctors view">
<h2><?php  echo __('Doctor'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($doctor['Doctor']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('User'); ?></dt>
		<dd>
			<?php echo $this->Html->link($doctor['User']['id'], array('controller' => 'users', 'action' => 'view', $doctor['User']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('First Name'); ?></dt>
		<dd>
			<?php echo h($doctor['Doctor']['first_name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Middle Name'); ?></dt>
		<dd>
			<?php echo h($doctor['Doctor']['middle_name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Last Name'); ?></dt>
		<dd>
			<?php echo h($doctor['Doctor']['last_name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Phone'); ?></dt>
		<dd>
			<?php echo h($doctor['Doctor']['phone']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Email'); ?></dt>
		<dd>
			<?php echo h($doctor['Doctor']['email']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($doctor['Doctor']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($doctor['Doctor']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Doctor'), array('action' => 'edit', $doctor['Doctor']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Doctor'), array('action' => 'delete', $doctor['Doctor']['id']), null, __('Are you sure you want to delete # %s?', $doctor['Doctor']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Doctors'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Doctor'), array('action' => 'add')); ?> </li>
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
<div class="related">
	<h3><?php echo __('Related Doctor Consult Locations'); ?></h3>
	<?php if (!empty($doctor['DoctorConsultLocation'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Location Id'); ?></th>
		<th><?php echo __('Doctor Id'); ?></th>
		<th><?php echo __('Consult Location Type Id'); ?></th>
		<th><?php echo __('Addl'); ?></th>
		<th><?php echo __('Created'); ?></th>
		<th><?php echo __('Modified'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($doctor['DoctorConsultLocation'] as $doctorConsultLocation): ?>
		<tr>
			<td><?php echo $doctorConsultLocation['id']; ?></td>
			<td><?php echo $doctorConsultLocation['location_id']; ?></td>
			<td><?php echo $doctorConsultLocation['doctor_id']; ?></td>
			<td><?php echo $doctorConsultLocation['consult_location_type_id']; ?></td>
			<td><?php echo $doctorConsultLocation['addl']; ?></td>
			<td><?php echo $doctorConsultLocation['created']; ?></td>
			<td><?php echo $doctorConsultLocation['modified']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'doctor_consult_locations', 'action' => 'view', $doctorConsultLocation['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'doctor_consult_locations', 'action' => 'edit', $doctorConsultLocation['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'doctor_consult_locations', 'action' => 'delete', $doctorConsultLocation['id']), null, __('Are you sure you want to delete # %s?', $doctorConsultLocation['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Doctor Consult Location'), array('controller' => 'doctor_consult_locations', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?php echo __('Related Experiences'); ?></h3>
	<?php if (!empty($doctor['Experience'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('From'); ?></th>
		<th><?php echo __('To'); ?></th>
		<th><?php echo __('Dept'); ?></th>
		<th><?php echo __('Doctor Id'); ?></th>
		<th><?php echo __('Location Id'); ?></th>
		<th><?php echo __('Created'); ?></th>
		<th><?php echo __('Modified'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($doctor['Experience'] as $experience): ?>
		<tr>
			<td><?php echo $experience['id']; ?></td>
			<td><?php echo $experience['from']; ?></td>
			<td><?php echo $experience['to']; ?></td>
			<td><?php echo $experience['dept']; ?></td>
			<td><?php echo $experience['doctor_id']; ?></td>
			<td><?php echo $experience['location_id']; ?></td>
			<td><?php echo $experience['created']; ?></td>
			<td><?php echo $experience['modified']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'experiences', 'action' => 'view', $experience['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'experiences', 'action' => 'edit', $experience['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'experiences', 'action' => 'delete', $experience['id']), null, __('Are you sure you want to delete # %s?', $experience['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Experience'), array('controller' => 'experiences', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?php echo __('Related Qualifications'); ?></h3>
	<?php if (!empty($doctor['Qualification'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Doctor Id'); ?></th>
		<th><?php echo __('Degree Id'); ?></th>
		<th><?php echo __('Location Id'); ?></th>
		<th><?php echo __('Year'); ?></th>
		<th><?php echo __('Dept'); ?></th>
		<th><?php echo __('Created'); ?></th>
		<th><?php echo __('Modified'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($doctor['Qualification'] as $qualification): ?>
		<tr>
			<td><?php echo $qualification['id']; ?></td>
			<td><?php echo $qualification['doctor_id']; ?></td>
			<td><?php echo $qualification['degree_id']; ?></td>
			<td><?php echo $qualification['location_id']; ?></td>
			<td><?php echo $qualification['year']; ?></td>
			<td><?php echo $qualification['dept']; ?></td>
			<td><?php echo $qualification['created']; ?></td>
			<td><?php echo $qualification['modified']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'qualifications', 'action' => 'view', $qualification['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'qualifications', 'action' => 'edit', $qualification['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'qualifications', 'action' => 'delete', $qualification['id']), null, __('Are you sure you want to delete # %s?', $qualification['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Qualification'), array('controller' => 'qualifications', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?php echo __('Related Link Doctors To Specialties'); ?></h3>
	<?php if (!empty($doctor['LinkDoctorsToSpecialty'])): ?>
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
		foreach ($doctor['LinkDoctorsToSpecialty'] as $linkDoctorsToSpecialty): ?>
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
