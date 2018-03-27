<div class="col-lg-4 col-lg-offset-4 col-sm-6 col-sm-offset-3 well" style="margin-top: 5%">

    <style>
    #login > ul > li { list-style: none;}    
    #login > ul { padding: 0;}    
    </style>

    <h2 class="page-title" id="page_title"><?php echo lang('user:login_header') ?></h2>

    <div class="success-box">
            <?php echo $this->lang->line('user:activated_message') ?>
    </div>

    <?php echo form_open('users/login', array('id'=>'login')) ?>
    <ul>
            <li>
                    <label for="email"><?php echo lang('global:email') ?></label>
                    <?php echo form_input('email') ?>
            </li>

            <li>
                    <label for="password"><?php echo lang('global:password') ?></label>
                    <?php echo form_password('password') ?>
            </li>

            <li class="form_buttons">
                <input type="submit" value="<?php echo lang('user:login_btn') ?>" name="btnLogin" class="btn btn-primary" style="margin-top:10px"/>
            </li>
    </ul>
    <?php echo form_close() ?>
</div>
<script>
	jQuery('#login input[type=text], #login input[type=password]').addClass('form-control');
	
</script>