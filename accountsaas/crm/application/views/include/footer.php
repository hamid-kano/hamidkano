<!-- /.control-sidebar -->
<!-- Add the sidebar's background. This div must be placed
     immediately after the control sidebar -->
<div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->

<script>
    $.widget.bridge('uibutton', $.ui.button);
</script>
<!-- DataTables -->
<script src="<?php echo assets_url('crm-assets/js/jquery.dataTables.min.js'); ?>"></script>
<script src="<?php echo assets_url('crm-assets/js/dataTables.bootstrap.min.js'); ?>"></script>
<script src="https://cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js"></script>
<script src="//cdn.datatables.net/buttons/1.2.2/js/buttons.flash.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
<script src="//cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js"></script>
<script src="//cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js"></script>
<script src="//cdn.datatables.net/buttons/1.2.2/js/buttons.html5.min.js"></script>
<script src="//cdn.datatables.net/buttons/1.2.2/js/buttons.print.min.js"></script>


<script type="text/javascript" src="<?php echo assets_url('crm-assets/js/moment.min.js'); ?>"></script>
<script type="text/javascript" src="<?php echo assets_url('crm-assets/js/daterangepicker.js'); ?>"></script>

<!-- Bootstrap 3.3.6 -->
<script src="<?php echo assets_url('crm-assets/js/bootstrap.min.js'); ?>"></script>
<script src="<?php echo assets_url('crm-assets/js/jquery.form-validator.min.js'); ?>"></script>

<!-- SlimScroll -->
<script src="<?php echo assets_url('crm-assets/js/jquery.slimscroll.min.js'); ?>"></script>
<!-- FastClick -->
<script src="<?php echo assets_url('crm-assets/js/fastclick.js'); ?>"></script>

<!-- AdminLTE App -->
<script src="<?php echo assets_url('crm-assets/js/app.min.js'); ?>"></script>
<!-- iCheck -->
<script src="<?php echo assets_url('crm-assets/js/icheck.min.js'); ?>"></script>
<script src="<?php echo assets_url('crm-assets/ckeditor/ckeditor.js'); ?>"></script>
<script src="<?php echo assets_url('crm-assets/ckeditor/adapters/jquery.js'); ?>"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?php echo assets_url('crm-assets/js/demo.js'); ?>"></script>
<script src="<?php echo assets_url('crm-assets/js/custom.js'); ?>"></script>
<script>
    function validate_fileType(fileName, Nameid, arrayValu) {
        var string = arrayValu;
        var tempArray = new Array();
        var tempArray = string.split(',');
        var allowed_extensions = tempArray;
        var file_extension = fileName.split(".").pop();
        for (var i = 0; i <= allowed_extensions.length; i++) {
            if (allowed_extensions[i] == file_extension) {
                $("#error_" + Nameid).html("");
                return true; // valid file extension
            }
        }
        $("#" + Nameid).val("");
        $("#error_" + Nameid).css("color", "red").html("File format not support to upload");
        return false;
    }
</script>
</body>
</html>
<!-- modal -->
