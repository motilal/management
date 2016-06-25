<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Profile Setup</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Change Admin Password
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <?php echo form_open(site_url('admin/settings/profile'), array("id" => "change-password-form", "method" => "post")); ?>
                            <div class="form-group <?php echo!empty(form_error('password')) ? 'has-error' : ''; ?>">
                                <label class="control-label" for="password">Old Password</label>
                                <?php echo form_password("password", set_value("password"), "id='password' class='form-control'"); ?>
                                <?php echo form_error('password'); ?>
                            </div>

                            <div class="form-group <?php echo!empty(form_error('new_password')) ? 'has-error' : ''; ?>"> 
                                <label class="control-label" for="new_password">New Password</label>
                                <?php echo form_password("new_password", set_value("new_password"), "id='new_password' class='form-control'"); ?>
                                <?php echo form_error('new_password'); ?>
                            </div>
                            
                            <div class="form-group <?php echo!empty(form_error('confirm_password')) ? 'has-error' : ''; ?>">
                                <label class="control-label" for="confirm_password">Confirm Password</label>
                                <?php echo form_password("confirm_password", set_value("confirm_password"), "id='confirm_password' class='form-control'"); ?>
                                <?php echo form_error('confirm_password'); ?>
                            </div>  
                            <?php echo form_hidden('action', 'change-password'); ?>
                            <button type="submit" class="btn btn-primary">Submit</button>
                            <button type="reset" class="btn btn-default" onclick="window.location.href='<?php echo site_url("admin/dashboard");?>'">Cancel</button>
                            <?php echo form_close(); ?>
                        </div>
                        <!-- /.col-lg-6 (nested) --> 
                    </div>
                    <!-- /.row (nested) -->
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
</div>