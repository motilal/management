<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">State</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Manage State
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body"> 
                    <div class="dataTable_wrapper">
                        <div id="dataTables-grid_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">

                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="dataTables_length" id="dataTables-grid_length">
                                        <label>Show  
                                            <select name="dataTables-grid_length" id="perpage_list" aria-controls="dataTables-grid" class="form-control input-sm">
                                                <option value="10"  <?php echo $perpage == "10" ? "selected" : ""; ?>>10</option>
                                                <option value="25"  <?php echo $perpage == "25" ? "selected" : ""; ?>>25</option>
                                                <option value="50"  <?php echo $perpage == "50" ? "selected" : ""; ?>>50</option>
                                                <option value="100" <?php echo $perpage == "100" ? "selected" : ""; ?>>100</option>
                                            </select> entries
                                        </label>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <?php echo form_open('admin/states/index', array("id" => "search-form", "method" => "get")); ?>
                                    <div id="dataTables-grid_filter" class="dataTables_filter">
                                        <label>Search:</label> 
                                        <div class="form-group input-group">
                                            <input type="text"  name="keyword" class="form-control" value="<?php echo $this->input->get('keyword'); ?>">
                                            <span class="input-group-btn">
                                                <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                                            </span>
                                        </div>
                                        <input type="hidden" name="perpage" value="<?php echo $perpage; ?>">
                                    </div>
                                    <?php echo form_close(); ?>
                                </div>

                            </div>  
                            <?php echo form_open('admin/states/actions', array("id" => "table-form", "method" => "post")); ?>
                            <div class="row">
                                <div class="col-sm-12"> 
                                    <table id="dataTables-grid" class="table table-striped table-bordered table-hover dataTable no-footer" role="grid" aria-describedby="dataTables-grid_info">
                                        <thead>
                                            <tr role="row" class="order-heading">
                                                <th width="5%" class="sorting_disabled text-center"> <input type="checkbox" class="check-all"></th>
                                                <th><a href="<?php
                                                    $sort1 = sorting_url('name');
                                                    echo $sort1->url;
                                                    ?>" class="<?php echo $sort1->class; ?>">State Name</a></th>
                                                <th><a href="<?php
                                                    $sort2 = sorting_url('short_name');
                                                    echo $sort2->url;
                                                    ?>" class="<?php echo $sort2->class; ?>">State Code</a></th>
                                                <th><a href="<?php
                                                    $sort3 = sorting_url('country_name');
                                                    echo $sort3->url;
                                                    ?>" class="<?php echo $sort3->class; ?>">Country Name</a></th>
                                                <th><a href="<?php
                                                    $sort4 = sorting_url('status');
                                                    echo $sort4->url;
                                                    ?>" class="<?php echo $sort4->class; ?>">Status</a></th>

                                                <th width="5%" class="sorting_disabled">Action</th>
                                            </tr>
                                        </thead> 
                                        <tbody> 
                                            <?php if ($result->num_rows() > 0) { ?>
                                                <?php foreach ($result->result() as $key => $row): ?>
                                                    <tr class="<?php echo ($key % 2 == 0) ? "even" : "odd"; ?> gradeX">
                                                        <td align="center">
                                                            <?php echo form_checkbox("ids[]", $row->id, in_array($row->id, (array) set_value("ids")) ? true : false, "id=\"ids_{$row->id}\"") ?>
                                                        </td>
                                                        <td><?php echo $row->name; ?></td>
                                                        <td><?php echo $row->short_name; ?></td>
                                                        <td><?php echo $row->country_name; ?></td>
                                                        <td class="center"><?php echo $row->status == '1' ? 'Active' : 'Inactive'; ?></td>
                                                        <td class="center action-link">
                                                            <a href="<?php echo site_url('admin/states/manage/' . $row->id); ?>" title="Edit"> <span class="fa fa-edit"></span> </a>
                                                            <a href="#" title="Delete" class="delete-row"> <span class="fa fa-times"></span> </a> 
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            <?php }else { ?>
                                                <tr class="odd">
                                                    <td valign="top" colspan="6" class="dataTables_empty">
                                                        No records found
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                        </tbody> 
                                    </table>
                                </div>
                            </div>
                            <input type="hidden" name="redirect" value="<?php echo base64_encode($this->input->server('QUERY_STRING')); ?>">
                            <div class="row">
                                <div class="col-sm-6 multi-action">  
                                    <select class="form-control list-action" id="list-action" name="actions">
                                        <option value="">Choose an action...</option>
                                        <option value="active">Active</option>
                                        <option value="inactive">In-Active</option>
                                        <option value="delete">Delete</option>
                                    </select>
                                    <input type="submit" class="btn btn-primary" value="GO"> 
                                </div>
                                <div class="col-sm-6">
                                    <div class="dataTables_paginate paging_simple_numbers" id="dataTables-grid_paginate">
                                        <?php echo $pagination; ?> 
                                    </div>
                                </div>
                            </div>
                            <?php echo form_close(); ?>  
                        </div> 

                    </div>  
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row --> 
</div> 

<!-- /#page-wrapper -->
<script>
    $(document).ready(function () {

        var delRestrict = false;
        $("#table-form").submit(function () {
            if ($("[name='ids[]']:checked").length == 0) {
                alert('Please select atleast one checkbox.');
                return false;
            }
            if ($("#list-action").val() == "delete" && !delRestrict) {
                confirm(function (e, btn) {
                    e.preventDefault();
                    delRestrict = true;
                    $("#table-form").submit();
                }, function (e, btn) {
                    e.preventDefault();
                    $("#table-form").find("input[type=checkbox]").prop('checked', false);
                });
                return delRestrict;
            }
        });

        $('#perpage_list').on('change', function () {
            var val = $(this).val();
            if (val > 0) {
                window.location = "<?php echo site_url('admin/states/index?perpage='); ?>" + val;
            }
        });

        $(document).on('click', 'a.delete-row', function (E) {
            $("#table-form").find('input[type=checkbox]').removeAttr('checked');
            $(this).parent("td")
                    .parent("tr")
                    .find("td > input[type=checkbox]")
                    .prop('checked', 'checked');
            $('#list-action').val('delete');
            $(this).closest('form').submit();
            E.preventDefault();
        });

    });

</script>