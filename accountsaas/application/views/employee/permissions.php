<div class="content-body">
    <div class="card">
        <div class="card-header">
            <h5 class="title">
                <?php echo $this->lang->line('Employee') ?> <a href="<?php echo base_url('employee/add') ?>"
                                                               class="btn btn-primary btn-sm rounded">
                    <?php echo $this->lang->line('Add new') ?>
                </a>
            </h5>
            <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
            <div class="heading-elements">
                <ul class="list-inline mb-0">
                    <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                    <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                    <li><a data-action="close"><i class="ft-x"></i></a></li>
                </ul>
            </div>
        </div>
        <div class="card-content">
            <div id="notify" class="alert alert-success" style="display:none;">
                <a href="#" class="close" data-dismiss="alert">&times;</a>

                <div class="message"></div>
            </div>
            <div class="card-body">


                <form method="post" id="data_form" class="form-horizontal">
                    <table id="" class="table table-striped table-bordered zero-configuration table-responsive"
                           cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th><?php echo $this->lang->line('Name') ?></th>
                            <th><?php echo $this->lang->line('Inventory Manager') ?></th>
                            <th><?php echo $this->lang->line('Sales Person') ?></th>
                            <th><?php echo $this->lang->line('Sales Manager') ?></th>
                            <th><?php echo $this->lang->line('Business Manager') ?></th>
                            <th><?php echo $this->lang->line('Business Owner') ?></th>
                            <th><?php echo $this->lang->line('Project Manager') ?></th>


                        </tr>
                        </thead>
                        <tbody>
                        <?php $i = 1;

                        foreach ($permission as $row) {
                            $i = $row['id'];
                            $module = $row['module'];

                            echo "<tr>
                    <td>$i</td>
                    <td>$module</td>"; ?>

                            <td><input type="checkbox" name="r_<?= $i ?>_1"
                                       class="m-1" <?php if ($row['r_1']) echo 'checked="checked"' ?>></td>
                            <td><input type="checkbox" name="r_<?= $i ?>_2"
                                       class="m-1" <?php if ($row['r_2']) echo 'checked="checked"' ?>></td>
                            <td><input type="checkbox" name="r_<?= $i ?>_3"
                                       class="m-1" <?php if ($row['r_3']) echo 'checked="checked"' ?>></td>
                            <td><input type="checkbox" name="r_<?= $i ?>_4"
                                       class="m-1" <?php if ($row['r_4']) echo 'checked="checked"' ?>></td>
                            <td><input type="checkbox" name="r_<?= $i ?>_5"
                                       class="m-1" <?php if ($row['r_5']) echo 'checked="checked"' ?>></td>
                            <td><input type="checkbox" name="r_<?= $i ?>_6"
                                       class="m-1" <?php if ($row['r_6']) echo 'checked="checked"' ?>></td>
                            <?php
                            echo "
                    </tr>";
                            //  $i++;
                        }
                        ?>
                        </tbody>
                        <tfoot>
                        <tr>
                            <th>#</th>
                            <th><?php echo $this->lang->line('Name') ?></th>
                            <th><?php echo $this->lang->line('Inventory Manager') ?></th>
                            <th><?php echo $this->lang->line('Sales Person') ?></th>
                            <th><?php echo $this->lang->line('Sales Manager') ?></th>
                            <th><?php echo $this->lang->line('Business Manager') ?></th>
                            <th><?php echo $this->lang->line('Business Owner') ?></th>
                            <th><?php echo $this->lang->line('Project Manager') ?></th>

                        </tr>
                        </tfoot>
                    </table>
                    <div class="form-group row">

                        <div class="col-sm-1"></div>

                        <div class="col-sm-6">
                            <input type="submit" id="submit-data" class="btn btn-success margin-bottom btn-lg"
                                   value="<?php echo $this->lang->line('Update') ?>"
                                   data-loading-text="Adding...">
                            <input type="hidden" value="employee/permissions_update" id="action-url">
                        </div>
                    </div>
            </div>

        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {

        //datatables
        $('#emptable').DataTable({responsive: true});


    });

</script>



