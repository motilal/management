<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">View Template</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    View Template
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <?php if (!empty($data)) { ?> 
                        <table class="table table-bordered table-striped">
                            <thead>

                            </thead>
                            <tbody>  
                                <tr>
                                    <th>Title</th>
                                    <td colspan="4"><?php echo $data->title; ?></td>
                                </tr>
                                <tr>
                                    <th>Subject</th>
                                    <td colspan="4"><?php echo $data->subject; ?></td>
                                </tr>
                                <tr>
                                    <th>Variables</th>
                                    <td colspan="4"><?php echo $data->variable; ?></td>
                                </tr>

                                <tr>
                                    <th>Body</th>
                                    <td colspan="4"><?php echo $data->body; ?></td>
                                </tr>

                                <tr>
                                    <th>Created</th>
                                    <td colspan="4"><?php echo date(DATETIME_FORMATE,  strtotime($data->created)); ?></td>
                                </tr>  
                                
                                <tr>
                                    <th>Updated</th>
                                    <td colspan="4"><?php echo date(DATETIME_FORMATE,  strtotime($data->updated)); ?></td>
                                </tr>  

                            </tbody>
                        </table> 

                    <?php } ?>
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
