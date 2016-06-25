<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Manage Email Template</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Email Template
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <?php echo form_open(null, array("id" => "manage-page-form", "method" => "post")); ?>

                            <div class="form-group <?php echo!empty(form_error('title')) ? 'has-error' : ''; ?>">
                                <label class="control-label" for="title">Email title*</label>
                                <?php echo form_input("title", set_value("title", isset($data->title) ? $data->title : ""), "id='title' class='form-control'"); ?>
                                <?php echo form_error('title'); ?>
                            </div>

                            <div class="form-group <?php echo!empty(form_error('subject')) ? 'has-error' : ''; ?>">
                                <label class="control-label" for="subject">Email subject*</label>
                                <?php echo form_input("subject", set_value("subject", isset($data->subject) ? $data->subject : ""), "id='subject' class='form-control'"); ?>
                                <?php echo form_error('subject'); ?>
                            </div>

                            <div class="form-group <?php echo!empty(form_error('variable')) ? 'has-error' : ''; ?>">
                                <label class="control-label" for="variable">Variable</label>
                                <?php echo form_textarea("variable", set_value("variable", isset($data->variable) ? $data->variable : ""), "id='variable' class='form-control' style='height:100px;'"); ?>
                                <?php echo form_error('variable'); ?>
                            </div>

                            <div class="form-group <?php echo!empty(form_error('body')) ? 'has-error' : ''; ?>">
                                <label class="control-label" for="body">Body*</label>
                                <?php echo form_textarea("body", set_value("body", isset($data->body) ? $data->body : "", FALSE), "id='body' class='form-control ckeditor'"); ?>
                                <?php echo form_error('body'); ?>
                            </div>

                            <?php echo form_hidden('id', set_value('id', isset($data->id) ? $data->id : "")); ?>
                            <button type="submit" class="btn btn-primary">Submit</button>
                            <button type="button" class="btn btn-default" onclick="window.location.href = '<?php echo site_url("admin/email_templates"); ?>'">Cancel</button>
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
<script>
    CKEDITOR.replace('body',
            {
                filebrowserBrowseUrl: '<?php echo base_url('asset/admin/ckfinder/ckfinder.html'); ?>',
                filebrowserImageBrowseUrl: '<?php echo base_url('asset/admin/ckfinder/ckfinder.html?type=Images'); ?>',
                filebrowserFlashBrowseUrl: '<?php echo base_url('asset/admin/ckfinder/ckfinder.html?type=Flash'); ?>',
                filebrowserUploadUrl: '<?php echo base_url('asset/admin/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files'); ?>',
                filebrowserImageUploadUrl: '<?php echo base_url('asset/admin/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images'); ?>',
                filebrowserFlashUploadUrl: '<?php echo base_url('asset/admin/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images'); ?>'
            });
</script>