<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Manage Country</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Manage Country
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <?php echo form_open(null, array("id" => "manage-county-form", "method" => "post")); ?>
                           
                            <div class="form-group <?php echo!empty(form_error('name')) ? 'has-error' : ''; ?>">
                                <label class="control-label" for="name">Country Name*</label>
                                <?php echo form_input("name", set_value("name",isset ($data->name) ? $data->name: ""), "id='name' class='form-control'"); ?>
                                <?php echo form_error('name'); ?>
                            </div>
                            
                            <div class="form-group <?php echo!empty(form_error('short_name')) ? 'has-error' : ''; ?>">
                                <label class="control-label" for="short_name">Short Name</label>
                                <?php echo form_input("short_name", set_value("short_name",isset ($data->short_name) ? $data->short_name: ""), "id='short_name' class='form-control'"); ?>
                                <?php echo form_error('short_name'); ?>
                            </div>
                             
                            <?php echo form_hidden('id', set_value('id', isset ($data->id) ? $data->id : "")); ?>
                            <button type="submit" class="btn btn-primary">Submit</button>
                            <button type="button" class="btn btn-default" onclick="window.location.href='<?php echo site_url("admin/countries");?>'">Cancel</button>
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