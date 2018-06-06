<div class="jobs index">
	<h2><?php echo __('Jobs'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<thead>
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('title'); ?></th>
			<th><?php echo $this->Paginator->sort('positions'); ?></th>
			<th><?php echo $this->Paginator->sort('category_id'); ?></th>
			<th><?php echo $this->Paginator->sort('user_id'); ?></th>
			<th><?php echo $this->Paginator->sort('status'); ?></th>
			<th><?php echo $this->Paginator->sort('address1'); ?></th>
			<th><?php echo $this->Paginator->sort('address2'); ?></th>
			<th><?php echo $this->Paginator->sort('pincode'); ?></th>
			<th><?php echo $this->Paginator->sort('description'); ?></th>
			<th><?php echo $this->Paginator->sort('state'); ?></th>
			<th><?php echo $this->Paginator->sort('city'); ?></th>
			<th><?php echo $this->Paginator->sort('startdate'); ?></th>
			<th><?php echo $this->Paginator->sort('enddate'); ?></th>
			<th><?php echo $this->Paginator->sort('starttime'); ?></th>
			<th><?php echo $this->Paginator->sort('endtime'); ?></th>
			<th><?php echo $this->Paginator->sort('jobcost'); ?></th>
			<th><?php echo $this->Paginator->sort('filename'); ?></th>
			<th><?php echo $this->Paginator->sort('allowbids'); ?></th>
			<th><?php echo $this->Paginator->sort('idproof'); ?></th>
			<th><?php echo $this->Paginator->sort('dated'); ?></th>
			<th><?php echo $this->Paginator->sort('include'); ?></th>
			<th><?php echo $this->Paginator->sort('iscomplete'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($jobs as $job): ?>
	<tr>
		<td><?php echo h($job['Job']['id']); ?>&nbsp;</td>
		<td><?php echo h($job['Job']['title']); ?>&nbsp;</td>
		<td><?php echo h($job['Job']['positions']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($job['Category']['name'], array('controller' => 'categories', 'action' => 'view', $job['Category']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($job['User']['name'], array('controller' => 'users', 'action' => 'view', $job['User']['id'])); ?>
		</td>
		<td><?php echo h($job['Job']['status']); ?>&nbsp;</td>
		<td><?php echo h($job['Job']['address1']); ?>&nbsp;</td>
		<td><?php echo h($job['Job']['address2']); ?>&nbsp;</td>
		<td><?php echo h($job['Job']['pincode']); ?>&nbsp;</td>
		<td><?php echo h($job['Job']['description']); ?>&nbsp;</td>
		<td><?php echo h($job['Job']['state']); ?>&nbsp;</td>
		<td><?php echo h($job['Job']['city']); ?>&nbsp;</td>
		<td><?php echo h($job['Job']['startdate']); ?>&nbsp;</td>
		<td><?php echo h($job['Job']['enddate']); ?>&nbsp;</td>
		<td><?php echo h($job['Job']['starttime']); ?>&nbsp;</td>
		<td><?php echo h($job['Job']['endtime']); ?>&nbsp;</td>
		<td><?php echo h($job['Job']['jobcost']); ?>&nbsp;</td>
		<td><?php echo h($job['Job']['filename']); ?>&nbsp;</td>
		<td><?php echo h($job['Job']['allowbids']); ?>&nbsp;</td>
		<td><?php echo h($job['Job']['idproof']); ?>&nbsp;</td>
		<td><?php echo h($job['Job']['dated']); ?>&nbsp;</td>
		<td><?php echo h($job['Job']['include']); ?>&nbsp;</td>
		<td><?php echo h($job['Job']['iscomplete']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $job['Job']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $job['Job']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $job['Job']['id']), array('confirm' => __('Are you sure you want to delete # %s?', $job['Job']['id']))); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</tbody>
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
		<li><?php echo $this->Html->link(__('New Job'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Categories'), array('controller' => 'categories', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Category'), array('controller' => 'categories', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Bids'), array('controller' => 'bids', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Bid'), array('controller' => 'bids', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Jobimages'), array('controller' => 'jobimages', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Jobimage'), array('controller' => 'jobimages', 'action' => 'add')); ?> </li>
	</ul>
</div>
