<div class="doctorConsultLocations view">
<h2><?php  echo __('Doctor Consult Location'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($doctorConsultLocation['DoctorConsultLocation']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Location'); ?></dt>
		<dd>
			<?php echo $this->Html->link($doctorConsultLocation['Location']['name'], array('controller' => 'locations', 'action' => 'view', $doctorConsultLocation['Location']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Doctor'); ?></dt>
		<dd>
			<?php echo $this->Html->link($doctorConsultLocation['Doctor']['id'], array('controller' => 'doctors', 'action' => 'view', $doctorConsultLocation['Doctor']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Consult Location Type'); ?></dt>
		<dd>
			<?php echo $this->Html->link($doctorConsultLocation['ConsultLocationType']['name'], array('controller' => 'consult_location_types', 'action' => 'view', $doctorConsultLocation['ConsultLocationType']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Addl'); ?></dt>
		<dd>
			<?php echo h($doctorConsultLocation['DoctorConsultLocation']['addl']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($doctorConsultLocation['DoctorConsultLocation']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($doctorConsultLocation['DoctorConsultLocation']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Doctor Consult Location'), array('action' => 'edit', $doctorConsultLocation['DoctorConsultLocation']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Doctor Consult Location'), array('action' => 'delete', $doctorConsultLocation['DoctorConsultLocation']['id']), null, __('Are you sure you want to delete # %s?', $doctorConsultLocation['DoctorConsultLocation']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Doctor Consult Locations'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Doctor Consult Location'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Locations'), array('controller' => 'locations', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Location'), array('controller' => 'locations', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Doctors'), array('controller' => 'doctors', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Doctor'), array('controller' => 'doctors', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Consult Location Types'), array('controller' => 'consult_location_types', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Consult Location Type'), array('controller' => 'consult_location_types', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Consult Timings'), array('controller' => 'consult_timings', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Consult Timing'), array('controller' => 'consult_timings', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Related Consult Timings'); ?></h3>
	<?php if (!empty($doctorConsultLocation['ConsultTiming'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Monday'); ?></th>
		<th><?php echo __('Tuesday'); ?></th>
		<th><?php echo __('Wednesday'); ?></th>
		<th><?php echo __('Thursday'); ?></th>
		<th><?php echo __('Friday'); ?></th>
		<th><?php echo __('Saturday'); ?></th>
		<th><?php echo __('Sunday'); ?></th>
		<th><?php echo __('Start'); ?></th>
		<th><?php echo __('End'); ?></th>
		<th><?php echo __('Consult Type Id'); ?></th>
		<th><?php echo __('Doctor Consult Location Id'); ?></th>
		<th><?php echo __('Phone'); ?></th>
		<th><?php echo __('Email'); ?></th>
		<th><?php echo __('Created'); ?></th>
		<th><?php echo __('Modified'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($doctorConsultLocation['ConsultTiming'] as $consultTiming): ?>
		<tr>
			<td><?php echo $consultTiming['id']; ?></td>
			<td><?php echo $consultTiming['monday']; ?></td>
			<td><?php echo $consultTiming['tuesday']; ?></td>
			<td><?php echo $consultTiming['wednesday']; ?></td>
			<td><?php echo $consultTiming['thursday']; ?></td>
			<td><?php echo $consultTiming['friday']; ?></td>
			<td><?php echo $consultTiming['saturday']; ?></td>
			<td><?php echo $consultTiming['sunday']; ?></td>
			<td><?php echo $consultTiming['start']; ?></td>
			<td><?php echo $consultTiming['end']; ?></td>
			<td><?php echo $consultTiming['consult_type_id']; ?></td>
			<td><?php echo $consultTiming['doctor_consult_location_id']; ?></td>
			<td><?php echo $consultTiming['phone']; ?></td>
			<td><?php echo $consultTiming['email']; ?></td>
			<td><?php echo $consultTiming['created']; ?></td>
			<td><?php echo $consultTiming['modified']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'consult_timings', 'action' => 'view', $consultTiming['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'consult_timings', 'action' => 'edit', $consultTiming['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'consult_timings', 'action' => 'delete', $consultTiming['id']), null, __('Are you sure you want to delete # %s?', $consultTiming['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Consult Timing'), array('controller' => 'consult_timings', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
