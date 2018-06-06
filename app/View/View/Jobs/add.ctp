<div class="jobs form">
<?php echo $this->Form->create('Job'); ?>
	<fieldset>
		<legend><?php echo __('Add Job'); ?></legend>
	<?php
		echo $this->Form->input('title');
		echo $this->Form->input('positions');
		echo $this->Form->input('category_id');
		echo $this->Form->input('user_id');
		echo $this->Form->input('status');
		echo $this->Form->input('address1');
		echo $this->Form->input('address2');
		echo $this->Form->input('pincode');
		echo $this->Form->input('description');
		echo $this->Form->input('state');
		echo $this->Form->input('city');
		echo $this->Form->input('startdate');
		echo $this->Form->input('enddate');
		echo $this->Form->input('starttime');
		echo $this->Form->input('endtime');
		echo $this->Form->input('jobcost');
		echo $this->Form->input('filename');
		echo $this->Form->input('allowbids');
		echo $this->Form->input('idproof');
		echo $this->Form->input('dated');
		echo $this->Form->input('include');
		echo $this->Form->input('iscomplete');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Jobs'), array('action' => 'index')); ?></li>
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
