DOCTOR FORM
<section class="title">
	<!-- We'll use $this->method to switch between doctor.create & doctor.edit -->
	<h4><?php echo lang('doctor:'.$this->method); ?></h4>
</section>

<section class="item">

	<?php echo form_open_multipart($this->uri->uri_string(), 'class="crud"'); ?>
		
		<div class="form_inputs">
	
		<ul>
			<li class="<?php echo alternator('', 'even'); ?>">
                            <?php echo $this->doctor_m->form_checkbox_days('f'); ?>
                            
				<label for="days"><?php echo lang('doctor:days'); ?> <span>*</span></label>
				<div class="input"><?php echo form_input('days', set_value('days', $days), 'class="width-15"'); ?></div>
			</li>

			<li class="<?php echo alternator('', 'even'); ?>">
				<label for="description"><?php echo lang('doctor:description'); ?> <span>*</span></label>
				<div class="input"><?php echo form_textarea('description', set_value('description', $description), 'class="width-15"'); ?></div>
			</li>
		</ul>
		
		</div>
		
		<div class="buttons">
			<?php $this->load->view('admin/partials/buttons', array('buttons' => array('save', 'cancel') )); ?>
		</div>
		
	<?php echo form_close(); ?>

</section>