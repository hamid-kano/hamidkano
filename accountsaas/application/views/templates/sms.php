<div class="card card-block">
    <div id="notify" class="alert alert-success" style="display:none;">
        <a href="#" class="close" data-dismiss="alert">&times;</a>

        <div class="message"></div>
    </div>
    <div class="card-body">
        <h5 class="title"><?php echo $this->lang->line('Manage SMS Templates') ?>
        </h5>

        <hr>
        <table id="catgtable" class="table table-striped table-bordered zero-configuration" cellspacing="0"
               width="100%">
            <thead>
            <tr>
                <th>#</th>
                <th><?php echo $this->lang->line('Name') ?></th>

                <th><?php echo $this->lang->line('Action') ?></th>


            </tr>
            </thead>
            <tbody>
            <?php $i = 1;
            foreach ($emails as $row) {
                $cid = $row['id'];
                $title = $row['name'];

                echo "<tr>
                    <td>$i</td>
                    <td>$title</td>
                    
                  
                    <td><a href='" . base_url("templates/sms_update?id=$cid&ref=".$row['hash_code']."") . "' class='btn btn-cyan btn-xs'><i class='icon-pencil'></i>" . $this->lang->line('Edit') . "</a></td></tr>";
                $i++;
            }
            ?>
            </tbody>
            <tfoot>
            <tr>
                <th>#</th>
                <th><?php echo $this->lang->line('Name') ?></th>

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
</script>
