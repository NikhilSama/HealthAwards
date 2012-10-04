<div class="diseases view">
<h2><?php  echo __('Disease'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($disease['Disease']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($disease['Disease']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($disease['Disease']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($disease['Disease']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Disease'), array('action' => 'edit', $disease['Disease']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Disease'), array('action' => 'delete', $disease['Disease']['id']), null, __('Are you sure you want to delete # %s?', $disease['Disease']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Diseases'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Disease'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Link Specialties To Diseases'), array('controller' => 'link_specialties_to_diseases', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Link Specialties To Disease'), array('controller' => 'link_specialties_to_diseases', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Related Link Specialties To Diseases'); ?></h3>
	<?php if (!empty($disease['LinkSpecialtiesToDisease'])): ?>
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
		foreach ($disease['LinkSpecialtiesToDisease'] as $linkSpecialtiesToDisease): ?>
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
