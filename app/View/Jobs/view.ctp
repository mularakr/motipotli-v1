<div class="jobs view">
<h2><?php echo __('Job'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($job['Job']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Title'); ?></dt>
		<dd>
			<?php echo h($job['Job']['title']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Positions'); ?></dt>
		<dd>
			<?php echo h($job['Job']['positions']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Category'); ?></dt>
		<dd>
			<?php echo $this->Html->link($job['Category']['name'], array('controller' => 'categories', 'action' => 'view', $job['Category']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('User'); ?></dt>
		<dd>
			<?php echo $this->Html->link($job['User']['name'], array('controller' => 'users', 'action' => 'view', $job['User']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Status'); ?></dt>
		<dd>
			<?php echo h($job['Job']['status']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Address1'); ?></dt>
		<dd>
			<?php echo h($job['Job']['address1']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Address2'); ?></dt>
		<dd>
			<?php echo h($job['Job']['address2']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Pincode'); ?></dt>
		<dd>
			<?php echo h($job['Job']['pincode']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Description'); ?></dt>
		<dd>
			<?php echo h($job['Job']['description']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('State'); ?></dt>
		<dd>
			<?php echo h($job['Job']['state']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('City'); ?></dt>
		<dd>
			<?php echo h($job['Job']['city']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Startdate'); ?></dt>
		<dd>
			<?php echo h($job['Job']['startdate']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Enddate'); ?></dt>
		<dd>
			<?php echo h($job['Job']['enddate']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Starttime'); ?></dt>
		<dd>
			<?php echo h($job['Job']['starttime']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Endtime'); ?></dt>
		<dd>
			<?php echo h($job['Job']['endtime']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Jobcost'); ?></dt>
		<dd>
			<?php echo h($job['Job']['jobcost']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Filename'); ?></dt>
		<dd>
			<?php echo h($job['Job']['filename']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Allowbids'); ?></dt>
		<dd>
			<?php echo h($job['Job']['allowbids']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Idproof'); ?></dt>
		<dd>
			<?php echo h($job['Job']['idproof']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Dated'); ?></dt>
		<dd>
			<?php echo h($job['Job']['dated']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Include'); ?></dt>
		<dd>
			<?php echo h($job['Job']['include']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Iscomplete'); ?></dt>
		<dd>
			<?php echo h($job['Job']['iscomplete']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Job'), array('action' => 'edit', $job['Job']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Job'), array('action' => 'delete', $job['Job']['id']), array('confirm' => __('Are you sure you want to delete # %s?', $job['Job']['id']))); ?> </li>
		<li><?php echo $this->Html->link(__('List Jobs'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Job'), array('action' => 'add')); ?> </li>
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
<div class="related">
	<h3><?php echo __('Related Bids'); ?></h3>
	<?php if (!empty($job['Bid'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Job Id'); ?></th>
		<th><?php echo __('Status'); ?></th>
		<th><?php echo __('User Id'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($job['Bid'] as $bid): ?>
		<tr>
			<td><?php echo $bid['id']; ?></td>
			<td><?php echo $bid['job_id']; ?></td>
			<td><?php echo $bid['status']; ?></td>
			<td><?php echo $bid['user_id']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'bids', 'action' => 'view', $bid['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'bids', 'action' => 'edit', $bid['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'bids', 'action' => 'delete', $bid['id']), array('confirm' => __('Are you sure you want to delete # %s?', $bid['id']))); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Bid'), array('controller' => 'bids', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?php echo __('Related Jobimages'); ?></h3>
	<?php if (!empty($job['Jobimage'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Job Id'); ?></th>
		<th><?php echo __('Images'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($job['Jobimage'] as $jobimage): ?>
		<tr>
			<td><?php echo $jobimage['id']; ?></td>
			<td><?php echo $jobimage['job_id']; ?></td>
			<td><?php echo $jobimage['images']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'jobimages', 'action' => 'view', $jobimage['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'jobimages', 'action' => 'edit', $jobimage['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'jobimages', 'action' => 'delete', $jobimage['id']), array('confirm' => __('Are you sure you want to delete # %s?', $jobimage['id']))); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Jobimage'), array('controller' => 'jobimages', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
