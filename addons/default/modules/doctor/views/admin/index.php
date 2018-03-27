<section class="title">
	<h4><?php echo lang('doctor:doctors'); ?></h4>
</section>

<section class="item">
<div class="content">

	<?php if ($doctors['total'] > 0): ?>

            <?php echo $this->load->view('admin/partials/filters') ?>


		<table class="table" cellpadding="0" cellspacing="0">
			<thead>
				<tr>
					<th><?php echo lang('doctor:name'); ?></th>
					<th><?php echo lang('doctor:days'); ?></th>
					<th><?php echo lang('doctor:description'); ?></th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($doctors['entries'] as $doctor): ?>
				<tr>
					<td><?php echo $doctor['name']; ?></td>
					<td><?php 
//                                        echo $doctor['days']; ?></td>
					<td><?php echo $doctor['description']; ?></td>
					<td class="actions">
						<?php echo anchor('admin/doctor/edit/' . $doctor['id'], lang('global:edit'), 'class="button edit"'); ?>
						<?php echo anchor('admin/doctor/delete/' . $doctor['id'], lang('global:delete'), array('class' => 'confirm button delete')); ?>
					</td>
				</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
		
		<?php echo $doctors['pagination']; ?>
		
	<?php else: ?>
		<div class="no_data"><?php echo lang('doctor:no_doctors'); ?></div>
	<?php endif;?>
	
</div>
</section>