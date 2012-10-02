<div class="consultLocationTypes view">
<h2><?php  echo __('Consult Location Type'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($consultLocationType['ConsultLocationType']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($consultLocationType['ConsultLocationType']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($consultLocationType['ConsultLocationType']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($consultLocationType['ConsultLocationType']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Consult Location Type'), array('action' => 'edit', $consultLocationType['ConsultLocationType']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Consult Location Type'), array('action' => 'delete', $consultLocationType['ConsultLocationType']['id']), null, __('Are you sure you want to delete # %s?', $consultLocationType['ConsultLocationType']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Consult Location Types'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Consult Location Type'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Doctor Consult Locations'), array('controller' => 'doctor_consult_locations', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Doctor Consult Location'), array('controller' => 'doctor_consult_locations', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Related Doctor Consult Locations'); ?></h3>
	<?php if (!empty($consultLocationType['DoctorConsultLocation'])): ?>
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
		foreach ($consultLocationType['DoctorConsultLocation'] as $doctorConsultLocation): ?>
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
