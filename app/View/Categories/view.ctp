<div class="categories view">
<h2><?php echo __('Category'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($category['Category']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($category['Category']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Catimage'); ?></dt>
		<dd>
			<?php echo h($category['Category']['catimage']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Status'); ?></dt>
		<dd>
			<?php echo h($category['Category']['status']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Category'), array('action' => 'edit', $category['Category']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Category'), array('action' => 'delete', $category['Category']['id']), array('confirm' => __('Are you sure you want to delete # %s?', $category['Category']['id']))); ?> </li>
		<li><?php echo $this->Html->link(__('List Categories'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Category'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Jobs'), array('controller' => 'jobs', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Job'), array('controller' => 'jobs', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Related Jobs'); ?></h3>
	<?php if (!empty($category['Job'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Title'); ?></th>
		<th><?php echo __('Positions'); ?></th>
		<th><?php echo __('Category Id'); ?></th>
		<th><?php echo __('User Id'); ?></th>
		<th><?php echo __('Status'); ?></th>
		<th><?php echo __('Address1'); ?></th>
		<th><?php echo __('Address2'); ?></th>
		<th><?php echo __('Pincode'); ?></th>
		<th><?php echo __('Description'); ?></th>
		<th><?php echo __('State'); ?></th>
		<th><?php echo __('City'); ?></th>
		<th><?php echo __('Startdate'); ?></th>
		<th><?php echo __('Enddate'); ?></th>
		<th><?php echo __('Starttime'); ?></th>
		<th><?php echo __('Endtime'); ?></th>
		<th><?php echo __('Jobcost'); ?></th>
		<th><?php echo __('Filename'); ?></th>
		<th><?php echo __('Allowbids'); ?></th>
		<th><?php echo __('Idproof'); ?></th>
		<th><?php echo __('Dated'); ?></th>
		<th><?php echo __('Include'); ?></th>
		<th><?php echo __('Iscomplete'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($category['Job'] as $job): ?>
		<tr>
			<td><?php echo $job['id']; ?></td>
			<td><?php echo $job['title']; ?></td>
			<td><?php echo $job['positions']; ?></td>
			<td><?php echo $job['category_id']; ?></td>
			<td><?php echo $job['user_id']; ?></td>
			<td><?php echo $job['status']; ?></td>
			<td><?php echo $job['address1']; ?></td>
			<td><?php echo $job['address2']; ?></td>
			<td><?php echo $job['pincode']; ?></td>
			<td><?php echo $job['description']; ?></td>
			<td><?php echo $job['state']; ?></td>
			<td><?php echo $job['city']; ?></td>
			<td><?php echo $job['startdate']; ?></td>
			<td><?php echo $job['enddate']; ?></td>
			<td><?php echo $job['starttime']; ?></td>
			<td><?php echo $job['endtime']; ?></td>
			<td><?php echo $job['jobcost']; ?></td>
			<td><?php echo $job['filename']; ?></td>
			<td><?php echo $job['allowbids']; ?></td>
			<td><?php echo $job['idproof']; ?></td>
			<td><?php echo $job['dated']; ?></td>
			<td><?php echo $job['include']; ?></td>
			<td><?php echo $job['iscomplete']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'jobs', 'action' => 'view', $job['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'jobs', 'action' => 'edit', $job['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'jobs', 'action' => 'delete', $job['id']), array('confirm' => __('Are you sure you want to delete # %s?', $job['id']))); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Job'), array('controller' => 'jobs', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
