<section id="login">
    <div class="col-sm-6 col-sm-offset-3 " style="margin-top: 5%;">
        
                            <div class="module-header">
                                    <h3>
                                        <?php echo lang('user:reset_password_title');?>
                                    </h3>
                            </div> 
        
		<!--<h2><?php // echo lang('user:reset_password_title');?></h2>-->
		<?php if (!empty($error_string)): ?>
		<!-- Woops... -->
		<div class="row-fluid">
		    <div class="span12">
		      <div class="alert alert-danger">
		        <a class="close">&times;</a>
		        <?php echo $error_string;?>
		      </div>
		    </div>
		</div>
		<?php endif; ?>
		<?php if (!empty($success_string)): ?>
		<div>
		    <div class="span12">
		      <div class="alert alert-success">
		        <a class="close">&times;</a>
		        <?php echo $success_string; ?>
		      </div>
		    </div>
		</div>
		<?php endif; ?>
		<div class="row-fluid well">
			<?php echo form_open('users/reset_pass', array('id'=>'reset-pass', 'class' => 'crud_form')); ?>
			<div>
				<fieldset>
	        		<legend><?php echo lang('user:reset_instructions'); ?></legend>
	        		<div class="control-group">
						<label class="control-label" for="email"><?php echo lang('global:email') ?></label>
					    <div class="controls">
                                                <input type="text" name="email" maxlength="100" value="<?php echo set_value('email'); ?>" class="form-control"/>
					    </div>
					</div>
					<div class="control-group">
						<label class="control-label" for="username"><?php echo lang('user:username') ?></label>
					    <div class="controls">
					      	<input type="text" name="user_name" maxlength="40" value="<?php echo set_value('user_name'); ?>"  class="form-control"/>
					    </div>
					</div>
	        		<div class="form-actions" style="margin-top: 10px;">
	            		<?php echo form_submit('btnSubmit', lang('user:reset_pass_btn'), 'class="btn btn-primary"') ?>
	          		</div>
	        	</fieldset>
			</div>
		<?php echo form_close(); ?>
		</div>
	</div>
</section>