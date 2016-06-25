<!-- blueimp Gallery styles -->
<link rel="stylesheet" href="<?php echo base_url("asset/admin/fileuploader/css/blueimp-gallery.min.css"); ?>">
<!-- CSS to style the file input field as button and adjust the Bootstrap progress bars -->
<link rel="stylesheet" href="<?php echo base_url('asset/admin/fileuploader/css/jquery.fileupload.css'); ?>">
<link rel="stylesheet" href="<?php echo base_url('asset/admin/fileuploader/css/jquery.fileupload-ui.css'); ?>">
<!-- CSS adjustments for browsers with JavaScript disabled -->
<noscript><link rel="stylesheet" href="<?php echo base_url('asset/admin/fileuploader/css/jquery.fileupload-noscript.css'); ?>"></noscript>
<noscript><link rel="stylesheet" href="<?php echo base_url('asset/admin/fileuploader/css/jquery.fileupload-ui-noscript.css'); ?>"></noscript>
<link rel="stylesheet" href="<?php echo base_url("asset/admin/fileuploader/css/custom.css"); ?>">
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Manage Gallery</h1>
            </div>
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading"> Manage Gallery </div>
                    <div class="">
                        <!-- The file upload form used as target for the file upload widget -->
                        <form id="fileupload" action="<?php echo site_url(); ?>admin/gallery/upload" method="POST" enctype="multipart/form-data" accept="image/jpeg">
                            <!-- Redirect browsers with JavaScript disabled to the origin page -->
                            <noscript><input type="hidden" name="redirect" value="<?php echo current_url(); ?>"></noscript>
                            <!-- The fileupload-buttonbar contains buttons to add/delete files and start/cancel the upload -->
                            <div class="panel-body">
                                <div class="row fileupload-buttonbar">
                                    <div class="col-lg-7">
                                        <!-- The fileinput-button span is used to style the file input field as button -->
                                        <span class="btn btn-success fileinput-button">
                                            <i class="glyphicon glyphicon-plus"></i>
                                            <span>Add files...</span>
                                            <input type="file" name="files[]" accept="image/*" multiple>
                                        </span>
                                        <button type="submit" class="btn btn-primary start">
                                            <i class="glyphicon glyphicon-upload"></i>
                                            <span>Start upload</span>
                                        </button>
                                        <button type="reset" class="btn btn-warning cancel">
                                            <i class="glyphicon glyphicon-ban-circle"></i>
                                            <span>Cancel upload</span>
                                        </button>
                                        <button type="button" class="btn btn-danger delete">
                                            <i class="glyphicon glyphicon-trash"></i>
                                            <span>Delete</span>
                                        </button>
                                        <input type="checkbox" class="toggle">
                                        <!-- The global file processing state -->
                                        <span class="fileupload-process"></span>
                                    </div>
                                    <!-- The global progress state -->
                                    <div class="col-lg-5 fileupload-progress fade">
                                        <!-- The global progress bar -->
                                        <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100">
                                            <div class="progress-bar progress-bar-success" style="width:0%;"></div>
                                        </div>
                                        <!-- The extended global progress state -->
                                        <div class="progress-extended">&nbsp;</div>
                                    </div>
                                </div>
                            </div> 
                            <div class="">
                            <!-- The table listing the files available for upload/download -->
                            <table role="presentation" class="table table-striped"><tbody class="files"></tbody></table>
                            <div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</div>



<!-- The blueimp Gallery widget -->
<div id="blueimp-gallery" class="blueimp-gallery blueimp-gallery-controls" data-filter=":even">
    <div class="slides"></div>
    <h3 class="title"></h3>
    <a class="prev">‹</a>
    <a class="next">›</a>
    <a class="close">×</a>
    <a class="play-pause"></a>
    <ol class="indicator"></ol>
</div>
<!-- The template to display files available for upload -->
<script id="template-upload" type="text/x-tmpl"> 
    {% for (var i=0, file; file=o.files[i]; i++) { %}
    <tr class="template-upload fade">
    <td width="20%">
    <div class="dis-upl-imae">            
    <span class="preview"></span>
    </div>
    </td>
    <td width="50%">
    <p class="name">{%=file.name%}</p>
    <strong class="error text-danger"></strong>
    </td>
    <td width="20%">
    <p class="size">Processing...</p>
    <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0"><div class="progress-bar progress-bar-success" style="width:0%;"></div></div>
    </td>
    <td width="10%">
    {% if (!i && !o.options.autoUpload) { %}
    <button class="btn btn-ok-image start" disabled>

    </button>
    {% } %}
    {% if (!i) { %}
    <button class="btn btn-cancel-image cancel"> 
    </button>
    {% } %}
    </td>
    </tr>
    {% } %}
</script>
<!-- The template to display files available for download -->
<script id="template-download" type="text/x-tmpl"> 
    {% for (var i=0, file; file=o.files[i]; i++) { %}
    <tr class="template-download fade">
    <td width="20%">
    <div class="dis-upl-imae">    
    <span class="preview">
    {% if (file.thumbnailUrl) { %}
    <a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" data-gallery><img src="{%=file.thumbnailUrl%}"></a>
    {% } %}
    </span>
    <div>
    </td>
    <td width="50%">
    <p class="name">
    {% if (file.url) { %}
    <a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" {%=file.thumbnailUrl?'data-gallery':''%}>{%=file.name%}</a>
    {% } else { %}
    <span>{%=file.name%}</span>
    {% } %}
    </p>
    {% if (file.error) { %}
    <div><span class="label label-danger">Error</span> {%=file.error%}</div>
    {% } %}
    </td>
    <td width="20%">
    <span class="size">{%=o.formatFileSize(file.size)%}</span>
    </td>
    <td width="10%">
    {% if (file.deleteUrl) { %}
    <button class="delete btn btn-del-img" data-type="{%=file.deleteType%}" data-url="{%=file.deleteUrl%}"{% if (file.deleteWithCredentials) { %} data-xhr-fields='{"withCredentials":true}'{% } %}>

    </button>
    <input type="checkbox" name="delete" value="1" class="toggle toggle-single">
    {% } else { %}
    <button class="btn btn-cancel-image cancel"> 
    </button>
    {% } %}
    </td>
    </tr>
    {% } %}
</script>

<!-- The jQuery UI widget factory, can be omitted if jQuery UI is already included -->
<script src="<?php echo base_url('asset/admin/fileuploader/js/vendor/jquery.ui.widget.js'); ?>"></script>
<!-- The Templates plugin is included to render the upload/download listings -->
<script src="<?php echo base_url('asset/admin/fileuploader/js/tmpl.min.js'); ?>"></script>
<!-- The Load Image plugin is included for the preview images and image resizing functionality -->
<script src="<?php echo base_url('asset/admin/fileuploader/js/load-image.all.min.js'); ?>"></script>
<!-- The Canvas to Blob plugin is included for image resizing functionality -->
<script src="<?php echo base_url('asset/admin/fileuploader/js/canvas-to-blob.min.js'); ?>"></script> 
<!-- blueimp Gallery script -->
<script src="<?php echo base_url('asset/admin/fileuploader/js/jquery.blueimp-gallery.min.js'); ?>"></script>
<!-- The Iframe Transport is required for browsers without support for XHR file uploads -->
<script src="<?php echo base_url('asset/admin/fileuploader/js/jquery.iframe-transport.js'); ?>"></script>
<!-- The basic File Upload plugin -->
<script src="<?php echo base_url('asset/admin/fileuploader/js/jquery.fileupload.js'); ?>"></script>
<!-- The File Upload processing plugin -->
<script src="<?php echo base_url('asset/admin/fileuploader/js/jquery.fileupload-process.js'); ?>"></script>
<!-- The File Upload image preview & resize plugin -->
<script src="<?php echo base_url('asset/admin/fileuploader/js/jquery.fileupload-image.js'); ?>"></script> 
<!-- The File Upload validation plugin -->
<script src="<?php echo base_url('asset/admin/fileuploader/js/jquery.fileupload-validate.js'); ?>"></script>
<!-- The File Upload user interface plugin -->
<script src="<?php echo base_url('asset/admin/fileuploader/js/jquery.fileupload-ui.js'); ?>"></script>
<!-- The main application script -->
<script src="<?php echo base_url('asset/admin/fileuploader/js/main.js'); ?>"></script>
<!-- The XDomainRequest Transport is included for cross-domain file deletion for IE 8 and IE 9 -->
<!--[if (gte IE 8)&(lt IE 10)]>
<script src="<?php echo base_url('asset/admin/fileuploader/js/cors/jquery.xdr-transport.js'); ?>"></script>
<![endif]-->