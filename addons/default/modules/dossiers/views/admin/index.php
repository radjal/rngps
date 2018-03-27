<section class="title">
	<h4><?php echo lang('dossiers:docteurs'); ?></h4>
</section>

<section class="item">
<div class="content">

	<?php if ($dossiers['total'] > 0): ?>

            <?php echo $this->load->view('admin/partials/filters') ?>


		<table class="table" cellpadding="0" cellspacing="0">
			<thead>
				<tr>
					<th><?php echo lang('dossiers:name'); ?></th>
					<th><?php echo lang('dossiers:days'); ?></th>
					<th><?php echo lang('dossiers:description'); ?></th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($dossiers['entries'] as $dossiers): ?>
				<tr>
					<td><?php echo $dossiers['name']; ?></td>
					<td><?php 
//                                        echo $dossiers['days']; ?></td>
					<td><?php echo $dossiers['description']; ?></td>
					<td class="actions">
						<?php echo anchor('admin/dossiers/edit/' . $dossiers['id'], lang('global:edit'), 'class="button edit"'); ?>
						<?php echo anchor('admin/dossiers/delete/' . $dossiers['id'], lang('global:delete'), array('class' => 'confirm button delete')); ?>
					</td>
				</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
		
		<?php echo $dossiers['pagination']; ?>
		
	<?php else: ?>
		<div class="no_data"><?php echo lang('dossiers:no_dossiers'); ?></div>
	<?php endif;?>
	
</div>
</section>