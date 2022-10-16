<div class="card card-block">
    <div id="notify" class="alert alert-success" style="display:none;">
        <a href="#" class="close" data-dismiss="alert">&times;</a>

        <div class="message"></div>
    </div>
    <div class="card-body">
        <h5 class="title"> <?php echo $this->lang->line('Custom') ?>  <?php echo $this->lang->line('Fields') ?> <a
                    href="<?php echo base_url('settings/add_custom_field') ?>"
                    class="btn btn-primary btn-sm rounded">
                <?php echo $this->lang->line('Add new') ?>
            </a>
        </h5>
        <div class="m-1">
            <div class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input" <?php if (CUSTOM) echo 'checked=""'; ?>
                       name="customCheck" id="customCheck">
                <label class="custom-control-label"
                       for="customCheck"> <?php echo $this->lang->line('Enable') ?><?php echo $this->lang->line('Custom') ?><?php echo $this->lang->line('Fields') ?></label>
            </div>

        </div>
        <hr>
        <table id="catgtable" class="table table-striped table-bordered zero-configuration" cellspacing="0"
               width="100%">
            <thead>
            <tr>
                <th>#</th>
                <th><?php echo $this->lang->line('Name') ?></th>
                <th><?php echo $this->lang->line('Type') ?></th>
                <th><?php echo $this->lang->line('Module') ?></th>
                <th><?php echo $this->lang->line('Action') ?></th>


            </tr>
            </thead>
            <tbody>
            <?php $i = 1;
            foreach ($customfields as $row) {

                switch ($row['f_module']) {

                    case 2 :
                        $m = 'Standard Invoices';
                        break;
                    case 3 :
                        $m = 'Subscriptions';
                        break;
                    case 4 :
                        $m = 'Products';
                        break;
                    default:
                        $m = 'Customer';

                }

                echo "<tr>
                    <td>$i</td>
                    <td>" . $row['name'] . "</td>
                    <td>" . $row['f_type'] . "</td>
                    <td>$m</td>
                 
                    <td><a href='" . base_url("settings/edit_custom_field?id=" . $row['id']) . "' class='btn btn-warning btn-xs'><i class='fa fa-pencil'></i> " . $this->lang->line('Edit') . "</a>&nbsp;<a href='#' data-object-id='" . $row['id'] . "' class='btn btn-danger btn-xs delete-object' title='Delete'><i class='fa fa-trash'></i></a></td></tr>";


                $i++;
            }
            ?>
            </tbody>
            <tfoot>
            <tr>
                <th>#</th>
                <th><?php echo $this->lang->line('Name') ?></th>
                <th><?php echo $this->lang->line('Type') ?></th>
                <th><?php echo $this->lang->line('Module') ?></th>
                <th><?php echo $this->lang->line('Action') ?></th>
            </tr>
            </tfoot>
        </table>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {

        //datatables
        $('#catgtable').DataTable({responsive: true});

    });
    $("#customCheck").click(function (e) {

        var enable = 0;
        var actionurl = baseurl + 'settings/allow_custom';
        if ($('#customCheck').is(":checked")) {
            enable = 1;
        }
        $.ajax({
            type: "POST",
            url: actionurl,
            data: {
                'enable': enable,
                '<?=$this->security->get_csrf_token_name()?>': '<?=$this->security->get_csrf_hash(); ?>'
            },
            cache: false,
            success: function (data) {
                return data;
            }
        });
    });
</script>
<div id="delete_model" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">

                <h4 class="modal-title"><?php echo $this->lang->line('Delete') ?></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <p class="text-bold-500 text-danger">Warning : It will delete the field and all data stored in this
                    field.</strong></p>
            </div>
            <div class="modal-footer">
                <input type="hidden" id="object-id" value="">
                <input type="hidden" id="action-url" value="settings/delete_custom_field">
                <button type="button" data-dismiss="modal" class="btn btn-primary"
                        id="delete-confirm"><?php echo $this->lang->line('Delete') ?></button>
                <button type="button" data-dismiss="modal"
                        class="btn"><?php echo $this->lang->line('Cancel') ?></button>
            </div>
        </div>
    </div>
</div>