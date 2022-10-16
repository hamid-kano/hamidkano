<div class="content-body">
    <div class="card">
        <div class="card-header">
            <h5 class="title">
                <?php echo $this->lang->line('Department') . ' :' . $department['val1'] ?> <a
                        href="<?php echo base_url('employee/departments') ?>"
                        class="btn btn-primary btn-sm rounded">
                    <?php echo $this->lang->line('Departments') ?>
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


                <table id="emptable" class="table table-striped table-bordered zero-configuration" cellspacing="0"
                       width="100%">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th><?php echo $this->lang->line('Name') ?></th>
                        <th><?php echo $this->lang->line('Salary') ?></th>


                        <th><?php echo $this->lang->line('Actions') ?></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $i = 1;

                    foreach ($department_list as $row) {
                        $aid = $row['id'];

                        echo "<tr>
<td>" . $i . "</td>
                    <td>" . $row['name'] . "</td>
                       <td>" . $row['salary'] . "</td>
                 
                    <td><a href='" . base_url("employee/attendances?id=$aid") . "' class='btn btn-success btn-xs'><i class='fa fa-chain'></i> " . $this->lang->line('Attendance') . "</a>  <a href='" . base_url("employee/payroll_emp?id=$aid") . "' class='btn btn-blue btn-xs'><i class='fa fa-money'></i> " . $this->lang->line('Payroll') . "</a> <a href='" . base_url("employee/view?id=$aid") . "' class='btn btn-info btn-xs'><i class='icon-eye'></i> " . $this->lang->line('View') . "</a> <a href='" . base_url("employee/history?id=$aid") . "' class='btn btn-purple btn-xs'><i class='fa fa-clock-o'></i> " . $this->lang->line('History') . "</a></td></tr>";
                        $i++;
                    }
                    ?>
                    </tbody>
                    <tfoot>
                    <tr>
                        <th>#</th>
                        <th><?php echo $this->lang->line('Name') ?></th>
                        <th><?php echo $this->lang->line('Salary') ?></th>

                        <th><?php echo $this->lang->line('Actions') ?></th>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {

        //datatables
        $('#emptable').DataTable({responsive: true});


    });

    $('.delemp').click(function (e) {
        e.preventDefault();
        $('#empid').val($(this).attr('data-object-id'));

    });
</script>
