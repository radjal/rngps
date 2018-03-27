{{ custom:disable_theme_if_ajax }}
 
<div class="col-lg-4 col-lg-offset-4 col-sm-6 col-sm-offset-3" style="margin-top: 5%">

    <div class="module-header">
            <h3>
                <?php echo lang('user:register_header') ?>
            </h3>
    </div> 
    <div class="well">
        
    <style>
    #register > ul > li { list-style: none;}    
    #register > ul { padding: 0;}    
    </style>
    <!--<h2 class="page-title" id="page_title"><?php // echo lang('user:register_header') ?></h2>-->

    <p>
            <span id="active_step"><?php echo lang('user:register_step1') ?></span> -&gt;
            <span><?php echo lang('user:register_step2') ?></span>
    </p>

    <?php if ( ! empty($error_string)):?>
    <!-- Woops... -->
    <div class="alert alert-danger">
            <?php echo $error_string;?>
    </div>
    <?php endif;?>
    <?php echo form_open('register', array('id' => 'register')) ?>
    <ul>

            <?php if ( ! Settings::get('auto_username')): ?>
            <li>
                    <label for="username"><?php echo lang('user:username') ?></label>
                    <input type="text" name="username" maxlength="100" value="<?php echo $_user->username ?>" class="form-control input-sm"/>
            </li>
            <?php endif ?>

            <li>
                    <label for="email"><?php echo lang('global:email') ?></label>
                    <input type="text" name="email" maxlength="100" value="<?php echo $_user->email ?>" class="form-control input-sm"/>
                    <?php echo form_input('d0ntf1llth1s1n', ' ', 'class="default-form" style="display:none"') ?>
            </li>

            <li>
                    <label for="email">Confirmez votre email</label>
                    <input type="text" name="email" maxlength="100" value="<?php echo $_user->email ?>" class="form-control input-sm"/> 
            </li>

            <li>
                    <label for="password"><?php echo lang('global:password') ?></label>
                    <input type="password" name="password" maxlength="100" class="form-control input-sm" />
            </li>
 
            <?php 
            foreach($profile_fields as $field) { if($field['required'] and $field['field_slug'] != 'display_name') { ?>
            <li>
                    <label for="<?php echo $field['field_slug'] ?>"><?php echo (lang($field['field_name'])) ? lang($field['field_name']) : $field['field_name'];  ?></label>
                    <input type="text" 
                           name="<?php echo $field['field_slug'] ?>" 
                           id="<?php echo $field['field_slug'] ?>" 
                           value="<?php echo $field['value'] ?>" 
                           maxlength="50"
                           class="form-control input-sm" />
                    
                        <?php // echo $field['input'] ?>
                        <?php // echo htmlentities($field['input']) //debug ?>
            </li>
            <?php } } ?> 


            <li>
                    <?php echo form_submit('btnSubmit', lang('user:register_btn'), 'class="btn btn-primary" style="margin-top:10px"') ?>
            </li>
    </ul>
    <?php echo form_close() ?>
    </div>
</div> 