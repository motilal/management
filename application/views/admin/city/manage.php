<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Manage City</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Manage City
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <?php echo form_open(null, array("id" => "manage-county-form", "method" => "post")); ?>

                            <?php
                            $options = array('' => 'Select Country');
                            if ($country_dropdown->num_rows() > 0):
                                foreach ($country_dropdown->result() as $key => $value) :
                                    $options[$value->id] = $value->name;
                                endforeach;
                            endif;
                            ?> 
                            <div class="form-group <?php echo!empty(form_error('country_id')) ? 'has-error' : ''; ?>">
                                <label class="control-label" for="country_id">Country Name*</label>
                                <?php echo form_dropdown('country_id', $options, set_value('country_id', isset($data->country_id) ? $data->country_id : ""), 'class="form-control" id="country_id"'); ?>
                                <?php echo form_error('country_id'); ?>
                            </div>

                            <?php
                            $options1 = array('' => 'Select State');
                            if (isset($state_dropdown) && $state_dropdown->num_rows() > 0):
                                foreach ($state_dropdown->result() as $key => $value) :
                                    $options1[$value->id] = $value->name;
                                endforeach;
                            endif;
                            ?> 
                            <div class="form-group <?php echo!empty(form_error('state_id')) ? 'has-error' : ''; ?>">
                                <label class="control-label" for="state_id">State Name*</label>
                                <?php echo form_dropdown('state_id', $options1, set_value('state_id', isset($data->state_id) ? $data->state_id : ""), 'class="form-control"'); ?>
                                <?php echo form_error('state_id'); ?>
                            </div>

                            <div class="form-group <?php echo!empty(form_error('name')) ? 'has-error' : ''; ?>">
                                <label class="control-label" for="name">City Name*</label>
                                <?php echo form_input("name", set_value("name", isset($data->name) ? $data->name : ""), "id='name' class='form-control'"); ?>
                                <?php echo form_error('name'); ?>
                            </div> 


                            <?php echo form_hidden('id', set_value('id', isset($data->id) ? $data->id : "")); ?>
                            <button type="submit" class="btn btn-primary">Submit</button>
                            <button type="button" class="btn btn-default" onclick="window.location.href = '<?php echo site_url("admin/cities"); ?>'">Cancel</button>
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
<script type="text/javascript">
    $(document).ready(function () {
        $('#country_id').change(function () { 
            $.post(<?php echo json_encode(site_url('admin/cities/state_dropdown')); ?>, {id:$('#country_id').val()}).success(function (response) {
                $("[name='state_id']").empty();    
                $.each(response, function(key, value) {
                    $("[name='state_id']").append(value);
                });
            });
        });
    });
</script>
