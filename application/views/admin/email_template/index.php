<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Email Templates</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Manage Email Templates
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="dataTable_wrapper">
                        <?php echo form_open('admin/email_templates/actions', array("id" => "table-form", "method" => "post")); ?>  
                        <table class="table table-striped table-bordered table-hover" id="dataTables-grid">
                            <thead>
                                <tr>
                                    <th width="5%" class="text-center"><input class="check-all" type="checkbox"></th>
                                    <th>Title</th>
                                    <th>Subject</th>
                                        <th>Status</th>
                                    <th width="5%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($result->num_rows() > 0) { ?>
                                    <?php foreach ($result->result() as $key => $row): ?>
                                        <tr class="<?php echo ($key % 2 == 0) ? "even" : "odd"; ?> gradeX">
                                            <td align="center">
                                                <?php echo form_checkbox("ids[]", $row->id, in_array($row->id, (array) set_value("ids")) ? true : false, "id=\"ids_{$row->id}\"") ?>
                                            </td>
                                            <td><?php echo $row->title; ?></td>
                                            <td><?php echo $row->subject; ?></td>
                                            <td class="center"><?php echo $row->status == '1' ? 'Active' : 'Inactive'; ?></td>
                                            <td class="text-center action-link">
                                                <a href="<?php echo site_url('admin/email_templates/manage/' . $row->id); ?>" title="Edit"> <span class="fa fa-edit"></span> </a>
                                                <a href="<?php echo site_url('admin/email_templates/view/' . $row->id); ?>" title="View"> <span class="fa fa-search"></span> </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php } ?> 
                            </tbody> 
                        </table> 

                        <div class="row"> 
                            <div class="col-sm-4 multi-action">  
                                <select name="actions" id="list-action" class="form-control list-action">
                                    <option value="">Choose an action...</option>
                                    <option value="active">Active</option>
                                    <option value="inactive">In-Active</option> 
                                </select>
                                <input type="submit" value="GO" class="btn btn-primary"/> 
                            </div>
                        </div>
                        <?php echo form_close(); ?>
                    </div>
                    <!-- /.table-responsive --> 
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
        $('#dataTables-grid').DataTable({
            responsive: true,
            order: [[1, 'asc']],
            "columnDefs": [
                {"orderable": false, "targets": [0, 4]}
            ],
            "language": {
                "paginate": {
                    "previous": "Prev"
                }
            },
            "iDisplayLength": 25             
        });


        $("#table-form").submit(function () {
            if ($("[name='ids[]']:checked").length == 0) {
                alert('Please select atleast one checkbox.');
                return false;
            } 
        }); 
    });

</script>