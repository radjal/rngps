<section class="title">
	<h4><?php echo lang('verification:verifications'); ?></h4>
</section>

<section class="item">
<div class="content">

	<?php if ($verifications['total'] > 0): ?>
	
		<table class="table" cellpadding="0" cellspacing="0">
			<thead>
				<tr>
					<th><?php echo lang('verification:days'); ?></th>
					<th><?php echo lang('verification:description'); ?></th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($verifications['entries'] as $verification): ?>
				<tr>
					<td><?php echo $verification['days']; ?></td>
					<td><?php 
                                        echo $verification['description']; ?></td>
					<td class="actions"><?php echo anchor('admin/verification/edit/' . $verification['id'], lang('global:edit'), 'class="button edit"'); ?>
                                            <?php echo anchor('admin/verification/delete/' . $verification['id'], lang('global:delete'), array('class' => 'confirm button delete')); ?>
                                        </td>
				</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
		
		<?php echo $verifications['pagination']; ?>
		
	<?php else: ?>
		<div class="no_data"><?php echo lang('verification:no_verifications'); ?></div>
	<?php endif;?>
	
</div>
</section>