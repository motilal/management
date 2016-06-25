<div class="login-panel panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">Please Sign In</h3>
    </div>  
    <div class="panel-body">
        <?php echo form_error('username'); ?>
        <?php echo form_open(site_url('admin'), array("id" => "login-form", "method" => "post")); ?>
        <fieldset>
            <div class="form-group">                                         
                <?php echo form_input("username", set_value("username"), "id='username' class='form-control' autofocus='true' placeholder='Username'"); ?> 
            </div>
            <div class="form-group">
                <?php echo form_password("password","","placeholder = 'Password' class = 'form-control' autofocus = 'true'"); ?>
            </div> 
            <?php echo form_hidden('request', set_value('request', $request)); ?>
            <?php echo form_submit("submit", "Login", "class=\"btn btn-lg btn-success btn-block\""); ?> 
        </fieldset> 
        <?php echo form_close(); ?>
    </div>
</div>