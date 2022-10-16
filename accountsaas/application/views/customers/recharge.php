<div class="content-body">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title"><?php echo $this->lang->line('Customer Details') ?>
                : <?php echo $details['name'] ?></h4>
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
                <h2 class="text-xs-center">Current Balance
                    is <?= amountExchange($details['balance'], 0, $this->aauth->get_user()->loc) ?></h2>


            </div>
            <div class="card-body">
                <form method="post" id="data_form" class="form-horizontal">
                    <input type="hidden" value="<?= $details['id'] ?>" name="id">
                    <input type="hidden" value="<?= $details['hash_code'] ?>" name="ref">

                    <div class="form-group row">

                        <label class="col-sm-2 col-form-label"
                               for="amount"><?php echo $this->lang->line('Amount') ?></label>

                        <div class="col-sm-3">
                            <input type="number" placeholder="Enter amount in 0.00"
                                   class="form-control margin-bottom " name="amount">
                        </div>
                    </div>
                    <div class="form-group row">

                        <label class="col-sm-2 col-form-label"
                               for="name"></label>

                        <div class="col-sm-3">
                            <input type="submit" id="submit-data" class="btn btn-success margin-bottom"
                                   value="Add Balance" data-loading-text="Updating...">
                            <input type="hidden" value="customers/balance" id="action-url">
                        </div>
                    </div>


                </form>


                <h5 class="text-xs-center"><?php echo $this->lang->line('Payment History') ?></h5>
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th><?php echo $this->lang->line('Amount') ?></th>
                        <th><?php echo $this->lang->line('Note') ?></th>


                    </tr>
                    </thead>
                    <tbody id="activity">
                    <?php foreach ($activity as $row) {

                        echo '<tr>
                            <td>' . amountExchange($row['col1'], 0, $this->aauth->get_user()->loc) . '</td><td>' . $row['col2'] . '</td>
                           
                        </tr>';
                    } ?>

                    </tbody>
                </table>


            </div>
        </div>
    </div>
</div>
