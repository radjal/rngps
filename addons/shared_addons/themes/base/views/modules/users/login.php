
<section id="login">

	<div class="container">
		<div class="">
		<?php 
                //use GET var for redirect via menu
                if(!empty($this->agent->referrer()) ) 
                {
                    $redirect_to = $this->agent->referrer();
                    echo "<!-- ref: $redirect_to -->";
                }
                echo form_open('users/login', array('id' => 'login', 'class' => 'crud_form'), array('redirect_to' => $redirect_to)); ?>
			<div style="margin-top: 5%" class="col-sm-6 col-sm-offset-3 col-lg-4 col-lg-offset-4 ">
                            
                            <div class="simple-header">
                                    <h3>
                                        <?php echo lang('user:login_header') ?>

                                    </h3>
                            </div> 
                            
                            
                            <fieldset class="">
	        		
	        		
		<?php if (validation_errors()): ?>
		      
                                <div class="alert alert-danger alert-dismissable">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">
						&times;
					</button>
					<?php echo validation_errors(); ?>
				</div>


		<?php endif; ?>

	        		<div class="form-group">
						<label for="email"><?php echo lang('global:email') ?></label>
			            <div class="controls">
			            	<?php echo form_input('email', $this->input->post('email') ? $this->input->post('email') : '', 'class="form-control"')?>
			            </div>
		          	</div>

	        		<div class="form-group">
						<label class="control-label" for="password"><?php echo lang('global:password') ?></label>
			            <div class="controls">
			            	<input type="password" id="password" name="password" maxlength="20" class="form-control" />
			            </div>
		          	</div>

		          	<div class="form-group">
						
			            	
			            <label class="control-label" >
                                        <?php echo form_checkbox('remember', '1', FALSE); ?>
                                        <?php echo lang('user:remember'); ?></label>

		          	</div>

		          	<div align="center" class="form-actions">
                                    <div>
                                        <?php echo form_submit('btnSubmit', lang('user:login_btn'), 'class="btn btn-primary"'); ?> 
                                    </div>
                                    <div>
                                        <?php echo anchor('users/reset_pass', lang('user:reset_password_link'), 'class="btn btn-link"'); ?> 
                                    </div>
                                    <div>
                                        <?php echo anchor('register', lang('user:register_btn'), 'class="btn btn-link"'); ?></a> 
                                    </div>
	          		</div>

                            </fieldset>
			</div>
		<?php echo form_close(); ?>
		</div>
	</div>
</section>