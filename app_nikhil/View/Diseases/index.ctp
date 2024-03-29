<div class="diseases index">
	<h2><?php echo __('Diseases'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('name'); ?></th>
			<th><?php echo $this->Paginator->sort('created'); ?></th>
			<th><?php echo $this->Paginator->sort('modified'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php
	foreach ($diseases as $disease): ?>
	<tr>
		<td><?php echo h($disease['Disease']['id']); ?>&nbsp;</td>
		<td><?php echo h($disease['Disease']['name']); ?>&nbsp;</td>
		<td><?php echo h($disease['Disease']['created']); ?>&nbsp;</td>
		<td><?php echo h($disease['Disease']['modified']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $disease['Disease']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $disease['Disease']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $disease['Disease']['id']), null, __('Are you sure you want to delete # %s?', $disease['Disease']['id'])); ?>
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
		<li><?php echo $this->Html->link(__('New Disease'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Dslinks'), array('controller' => 'dslinks', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Dslink'), array('controller' => 'dslinks', 'action' => 'add')); ?> </li>
	</ul>
</div>
