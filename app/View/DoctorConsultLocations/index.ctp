<div class="doctorConsultLocations index">
	<h2><?php echo __('Doctor Consult Locations'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('location_id'); ?></th>
			<th><?php echo $this->Paginator->sort('doctor_id'); ?></th>
			<th><?php echo $this->Paginator->sort('consult_location_type_id'); ?></th>
			<th><?php echo $this->Paginator->sort('addl'); ?></th>
			<th><?php echo $this->Paginator->sort('created'); ?></th>
			<th><?php echo $this->Paginator->sort('modified'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php
	foreach ($doctorConsultLocations as $doctorConsultLocation): ?>
	<tr>
		<td><?php echo h($doctorConsultLocation['DoctorConsultLocation']['id']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($doctorConsultLocation['Location']['name'], array('controller' => 'locations', 'action' => 'view', $doctorConsultLocation['Location']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($doctorConsultLocation['Doctor']['id'], array('controller' => 'doctors', 'action' => 'view', $doctorConsultLocation['Doctor']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($doctorConsultLocation['ConsultLocationType']['name'], array('controller' => 'consult_location_types', 'action' => 'view', $doctorConsultLocation['ConsultLocationType']['id'])); ?>
		</td>
		<td><?php echo h($doctorConsultLocation['DoctorConsultLocation']['addl']); ?>&nbsp;</td>
		<td><?php echo h($doctorConsultLocation['DoctorConsultLocation']['created']); ?>&nbsp;</td>
		<td><?php echo h($doctorConsultLocation['DoctorConsultLocation']['modified']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $doctorConsultLocation['DoctorConsultLocation']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $doctorConsultLocation['DoctorConsultLocation']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $doctorConsultLocation['DoctorConsultLocation']['id']), null, __('Are you sure you want to delete # %s?', $doctorConsultLocation['DoctorConsultLocation']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
	));
	?>	</p>

	<div class="paging">
	<?php
		echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ''));
		echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
	?>
	</div>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New Doctor Consult Location'), array('action' => 'add')); ?></li>
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
