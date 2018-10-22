<div class="listings view">
<h2><?php echo __('Listing'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($listing['Listing']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('List Name'); ?></dt>
		<dd>
			<?php echo h($listing['Listing']['list_name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Distance'); ?></dt>
		<dd>
			<?php echo h($listing['Listing']['distance']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('User'); ?></dt>
		<dd>
			<?php echo $this->Html->link($listing['User']['id'], array('controller' => 'users', 'action' => 'view', $listing['User']['id'])); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Listing'), array('action' => 'edit', $listing['Listing']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Listing'), array('action' => 'delete', $listing['Listing']['id']), array('confirm' => __('Are you sure you want to delete # %s?', $listing['Listing']['id']))); ?> </li>
		<li><?php echo $this->Html->link(__('List Listings'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Listing'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
	</ul>
</div>
