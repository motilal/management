<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Manage Event</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Manage Event
                </div>
                <div class="panel-body">
                    <div class="row">                        
                        <?php echo form_open(null, array("id" => "manage-page-form", "method" => "post")); ?>
                        <div class="col-lg-6">
                            <div class="form-group <?php echo!empty(form_error('title')) ? 'has-error' : ''; ?>">
                                <label class="control-label" for="title">Event Title *</label>
                                <?php echo form_input("title", set_value("title", isset($data->title) ? $data->title : ""), "id='title' class='form-control'"); ?>
                                <?php echo form_error('title'); ?>
                            </div>
                        </div>
                        <div class="clear"></div>
                        <?php isset($data->start_date) ? $data->start_date = date(DATETIME_FORMATE, strtotime($data->start_date)) : ""; ?>   
                        <?php
                        if ($this->input->get('date')) {
                            @$data->start_date = date(DATETIME_FORMATE, strtotime($this->input->get('date')));
                        }
                        ?>
                        <div class="col-lg-3">
                            <div class="form-group input-group date <?php echo!empty(form_error('start_date')) ? 'has-error' : ''; ?>" id="datetimepicker1">
                                <?php echo form_input("start_date", set_value("start_date", isset($data->start_date) ? $data->start_date : ""), "id='start_date' class='form-control' placeholder='Start Date'"); ?>
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>                                
                            </div>
                            <?php echo form_error('start_date'); ?>
                        </div>
                        <?php isset($data->end_date) ? $data->end_date = date(DATETIME_FORMATE, strtotime($data->end_date)) : ''; ?>
                        <div class="col-lg-3">
                            <div class="form-group input-group date <?php echo!empty(form_error('end_date')) ? 'has-error' : ''; ?>" id="datetimepicker2">
                                <?php echo form_input("end_date", set_value("end_date", isset($data->end_date) ? $data->end_date : ""), "id='end_date' class='form-control' placeholder='End Date'"); ?>
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>                                
                            </div>
                            <?php echo form_error('end_date'); ?>
                        </div> 

                        <div class="col-lg-12">
                            <div class="form-group <?php echo!empty(form_error('description')) ? 'has-error' : ''; ?>">
                                <label class="control-label" for="description">Description*</label>
                                <?php echo form_textarea("description", set_value("description", isset($data->description) ? $data->description : "", FALSE), "id='description' class='form-control ckeditor'"); ?>
                                <?php echo form_error('description'); ?>
                            </div>

                            <?php echo form_hidden('id', set_value('id', isset($data->id) ? $data->id : "")); ?>            
                            <button type="submit" class="btn btn-primary">Submit</button>
                            <button type="button" class="btn btn-default" onclick="window.location.href = '<?php echo site_url("admin/events"); ?>'">Cancel</button>
                        </div>

                        <?php echo form_close(); ?>
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
    $(function () {
        $('#datetimepicker1').datetimepicker({
            format: 'DD-MM-YYYY LT'
        });
        $('#datetimepicker2').datetimepicker({
            useCurrent: false,
            format: 'DD-MM-YYYY LT'
        });
        $("#datetimepicker1").on("dp.change", function (e) {
            $('#datetimepicker2').data("DateTimePicker").minDate(e.date);
        });
        $("#datetimepicker2").on("dp.change", function (e) {
            $('#datetimepicker1').data("DateTimePicker").maxDate(e.date);
        });
    });
    CKEDITOR.replace('description',
            {
                filebrowserBrowseUrl: '<?php echo base_url('asset/admin/ckfinder/ckfinder.html'); ?>',
                filebrowserImageBrowseUrl: '<?php echo base_url('asset/admin/ckfinder/ckfinder.html?type=Images'); ?>',
                filebrowserFlashBrowseUrl: '<?php echo base_url('asset/admin/ckfinder/ckfinder.html?type=Flash'); ?>',
                filebrowserUploadUrl: '<?php echo base_url('asset/admin/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files'); ?>',
                filebrowserImageUploadUrl: '<?php echo base_url('asset/admin/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images'); ?>',
                filebrowserFlashUploadUrl: '<?php echo base_url('asset/admin/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images'); ?>'
            });
</script>