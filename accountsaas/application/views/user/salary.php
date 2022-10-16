<div class="card card-block">
    <div id="notify" class="alert alert-success" style="display:none;">
        <a href="#" class="close" data-dismiss="alert">&times;</a>

        <div class="message"></div>
    </div>
    <div class="card-body">
        <h5 class="title">
            <?php echo $this->lang->line('Employee') . ' : ' . $this->aauth->get_user()->username ?>
        </h5>
        <table id="semptable" class="table table-striped table-bordered zero-configuration" cellspacing="0"
               width="100%">
            <thead>
            <tr>
                <th>#</th>

                <th><?php echo $this->lang->line('Date') ?></th>
                <th><?php echo $this->lang->line('Amount') ?></th>
                <th><?php echo $this->lang->line('Note') ?></th>


            </tr>
            </thead>
            <tbody>
            <?php $i = 1;

            foreach ($employee_salary as $row) {
                if ($row['debit'] > 0.00) {
                    echo '<tr> <td>' . $i . '</td>
                  
                    <td>' . dateformat($row['date']) . '</td>
                      <td>' . amountExchange($row['debit'], 0, $employee['loc']) . '</td>
                   
                     <td>' . $row['note'] . '</td>
                    </tr>';
                    $i++;
                }

            }
            ?>
            </tbody>
            <tfoot>
            <tr>
                <th>#</th>

                <th><?php echo $this->lang->line('Date') ?></th>
                <th><?php echo $this->lang->line('Amount') ?></th>
                <th><?php echo $this->lang->line('Note') ?></th>
            </tr>
            </tfoot>
        </table>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {

        //datatables
        $('#semptable').DataTable({responsive: true});


    });


</script>