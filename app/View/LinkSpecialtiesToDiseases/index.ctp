<div class="linkSpecialtiesToDiseases index">
	<h2><?php echo __('Link Specialties To Diseases'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('specialty_id'); ?></th>
			<th><?php echo $this->Paginator->sort('disease_id'); ?></th>
			<th><?php echo $this->Paginator->sort('specialty_disease_link_type_id'); ?></th>
			<th><?php echo $this->Paginator->sort('created'); ?></th>
			<th><?php echo $this->Paginator->sort('modified'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php
	foreach ($linkSpecialtiesToDiseases as $linkSpecialtiesToDisease): ?>
	<tr>
		<td><?php echo h($linkSpecialtiesToDisease['LinkSpecialtiesToDisease']['id']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($linkSpecialtiesToDisease['Specialty']['name'], array('controller' => 'specialties', 'action' => 'view', $linkSpecialtiesToDisease['Specialty']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($linkSpecialtiesToDisease['Disease']['name'], array('controller' => 'diseases', 'action' => 'view', $linkSpecialtiesToDisease['Disease']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($linkSpecialtiesToDisease['SpecialtyDiseaseLinkType']['name'], array('controller' => 'specialty_disease_link_types', 'action' => 'view', $linkSpecialtiesToDisease['SpecialtyDiseaseLinkType']['id'])); ?>
		</td>
		<td><?php echo h($linkSpecialtiesToDisease['LinkSpecialtiesToDisease']['created']); ?>&nbsp;</td>
		<td><?php echo h($linkSpecialtiesToDisease['LinkSpecialtiesToDisease']['modified']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $linkSpecialtiesToDisease['LinkSpecialtiesToDisease']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $linkSpecialtiesToDisease['LinkSpecialtiesToDisease']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $linkSpecialtiesToDisease['LinkSpecialtiesToDisease']['id']), null, __('Are you sure you want to delete # %s?', $linkSpecialtiesToDisease['LinkSpecialtiesToDisease']['id'])); ?>
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
		<li><?php echo $this->Html->link(__('New Link Specialties To Disease'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Specialties'), array('controller' => 'specialties', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Specialty'), array('controller' => 'specialties', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Diseases'), array('controller' => 'diseases', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Disease'), array('controller' => 'diseases', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Specialty Disease Link Types'), array('controller' => 'specialty_disease_link_types', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Specialty Disease Link Type'), array('controller' => 'specialty_disease_link_types', 'action' => 'add')); ?> </li>
	</ul>
</div>
