<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Settings</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Site Setting
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <?php echo form_open(site_url('admin/settings'), array("id" => "site-settings", "method" => "post")); ?>

                            <?php
                            if (!is_null($settings_data)):
                                foreach ($settings_data as $k => $v):
                                    ?>
                                    <div class="form-group <?php echo!empty(form_error("settings_$v->id")) ? 'has-error' : ''; ?>">
                                        <label class="control-label" for="settings_<?php echo $v->id; ?>"><?php echo $v->title; ?><?php echo $v->is_required == 1 ? "*" : ""; ?></label>

                                        <?php
                                        if ($v->type == "text") {

                                            echo form_input("settings_$v->id", set_value("settings_$v->id", $v->value), "id='$v->field_name' class='form-control'");
                                            echo form_error("settings_$v->id");
                                        } else if ($v->type == "textarea") {

                                            echo form_textarea("settings_$v->id", set_value("settings_$v->id", $v->value), "id='$v->field_name' class='form-control' style='height:100px' ");
                                            echo form_error("settings_$v->id");
                                        } else if ($v->type == "radio") {
                                            ?>
                                            <div class="radio radche-50">
                                            <?php
                                            $options = @explode(",", $v->select_items);
                                            foreach ($options as $key => $value) {
                                                ?> 
                                                    <label for="radio_<?php echo $value ?>">
                                                    <?php
                                                    echo form_radio("settings_$v->id", $value, set_radio("settings_$v->id", $value, $v->value == $value ? TRUE : FALSE), "id='radio_{$value}'");
                                                    echo $value;
                                                    ?>
                                                    </label> 
                                                    <?php
                                                }
                                                ?>
                                            </div>

                                            <?php
                                        } else if ($v->type == "select") {

                                            $options = @explode(",", $v->select_items);
                                            $options = array_combine($options, $options);
                                            echo form_dropdown("settings_$v->id", $options, set_value("settings_$v->id", $v->value), "id='$v->field_name' class='form-control'");
                                        }
                                        ?> 
                                    </div> 
                                    <?php
                                endforeach;
                            endif;
                            ?> 
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