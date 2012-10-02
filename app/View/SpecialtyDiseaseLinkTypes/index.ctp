<div class="specialtyDiseaseLinkTypes index">
	<h2><?php echo __('Specialty Disease Link Types'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('name'); ?></th>
			<th><?php echo $this->Paginator->sort('created'); ?></th>
			<th><?php echo $this->Paginator->sort('modified'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php
	foreach ($specialtyDiseaseLinkTypes as $specialtyDiseaseLinkType): ?>
	<tr>
		<td><?php echo h($specialtyDiseaseLinkType['SpecialtyDiseaseLinkType']['id']); ?>&nbsp;</td>
		<td><?php echo h($specialtyDiseaseLinkType['SpecialtyDiseaseLinkType']['name']); ?>&nbsp;</td>
		<td><?php echo h($specialtyDiseaseLinkType['SpecialtyDiseaseLinkType']['created']); ?>&nbsp;</td>
		<td><?php echo h($specialtyDiseaseLinkType['SpecialtyDiseaseLinkType']['modified']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $specialtyDiseaseLinkType['SpecialtyDiseaseLinkType']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $specialtyDiseaseLinkType['SpecialtyDiseaseLinkType']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $specialtyDiseaseLinkType['SpecialtyDiseaseLinkType']['id']), null, __('Are you sure you want to delete # %s?', $specialtyDiseaseLinkType['SpecialtyDiseaseLinkType']['id'])); ?>
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
		<li><?php echo $this->Html->link(__('New Specialty Disease Link Type'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Link Specialties To Diseases'), array('controller' => 'link_specialties_to_diseases', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Link Specialties To Disease'), array('controller' => 'link_specialties_to_diseases', 'action' => 'add')); ?> </li>
	</ul>
</div>
