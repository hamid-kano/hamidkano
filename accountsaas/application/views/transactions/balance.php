<div class="content-body">
    <div class="card">
        <div class="card-header">
            <h5><?php echo $this->lang->line('BalanceSheet') ?></h5>
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
                
                <form action="#" method="get" role="form">
                                <div class="form-group row">

                                    <label class="col-sm-3 control-label"
                                           for="sdate"><?php echo $this->lang->line('From Date') ?></label>

                                    <div class="col-sm-4">
                                        <input type="text" class="form-control required"
                                               placeholder="Start Date" name="sdate" id="start_date"  data-toggle="datepicker"
                                               autocomplete="false">
                                    </div>
                                </div>
                                <div class="form-group row">

                                    <label class="col-sm-3 control-label"
                                           for="edate"><?php echo $this->lang->line('To Date') ?></label>

                                    <div class="col-sm-4">
                                        <input type="text" class="form-control required"
                                               placeholder="End Date" name="edate" id="end_date"
                                               data-toggle="datepicker" autocomplete="false">
                                    </div>
                                </div>
                                <div class="form-group row">

                                    <div class="col-sm-4">
                                        <input type="submit" class="btn btn-primary btn-md" value="View">


                                    </div>
                                </div>

                            </form>
                       <?php if($_GET['sdate'] && $_GET['edate']) {   ?>  
                  <h5 class="text-center">
                    <?php echo $this->lang->line('From Date')." : ".$_GET['sdate'].'   '.$this->lang->line('To Date').' : '.$_GET['edate'] ?>
                    <a href="<?php echo base_url().'/accounts/balancesheet'?>" class="btn btn-success"><?php echo $this->lang->line('Show All') ?></a>
                </h5>  
                <?php } ?>

                <h5 class="title bg-gradient-x-info p-1 white">
                    <?php echo $this->lang->line('Basic') ?><?php echo $this->lang->line('Accounts') ?>
                </h5>
                <p>&nbsp;</p>
                <table class="table">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th><?php echo $this->lang->line('Name') ?></th>
                        <th><?php echo $this->lang->line('Account') ?></th>
                        <th><?php echo $this->lang->line('Intial Balance') ?></th>
                        <th><?php echo $this->lang->line('Debit') ?></th>
                        <th><?php echo $this->lang->line('Credit') ?></th>
                        <th><?php echo $this->lang->line('Balance') ?></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $i = 1;
                    $gross = 0;
                    foreach ($accounts as $row) {

                            $aid = $row['id'];
                            $acn = $row['acn'];
                            $holder = $row['holder'];
                            $debit = 0;
                            $credit = 0;
                            $initial_balance = $row['initial_balance'];
                            $balance = $row['initial_balance'];
                            foreach($old_transactions as $old_transaction) {
                                if($old_transaction['acid'] == $aid) {
                                    if($row['type'] == "debit") {
                                        $balance += $old_transaction['debit'] - $old_transaction['credit'];
                                    } else {
                                        $balance += $old_transaction['credit'] - $old_transaction['debit'];
                                    }
                                }
                            }
                            foreach($transactions as $transaction) {
                                if($transaction['acid'] == $aid) {
                                    $debit += (float) $transaction['debit'];
                                    $credit += (float) $transaction['credit'];
                                    if($row['type'] == "debit") {
                                        $balance += $transaction['debit'] - $transaction['credit'];
                                    } else {
                                        $balance += $transaction['credit'] - $transaction['debit'];
                                    }
                                }
                            }
                            $qty = $row['adate'];
                            echo "<tr>
                    <td>$i</td>                    
                    <td>$holder</td>
                    <td>$acn</td>
                    <td>" . amountExchange($initial_balance, 0, $this->aauth->get_user()->loc) . "</td>
                    <td>" . amountExchange(abs($debit), 0, $this->aauth->get_user()->loc) . "</td>
                    <td>" . amountExchange(abs($credit), 0, $this->aauth->get_user()->loc) . "</td>
                   
                    <td>" . amountExchange($balance, 0, $this->aauth->get_user()->loc) . "</td>
                    </tr>";
                            $i++;
                            $gross += $balance;
                    }
                    ?>
                    </tbody>
                    <tfoot>
                    <tr>
                        <th></th>
                        <th></th>

                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>

                        <th>
                            <h3 class="text-xl-left"><?php echo amountExchange(abs($gross), 0, $this->aauth->get_user()->loc); ?></h3>
                        </th>
                    </tr>
                    </tfoot>
                </table>
                <h5 class="title bg-gradient-x-purple p-1 white">
                    <?php echo $this->lang->line('Assets') ?><?php echo $this->lang->line('Accounts') ?>
                </h5>
                <p>&nbsp;</p>
                <table class="table">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th><?php echo $this->lang->line('Name') ?></th>
                        <th><?php echo $this->lang->line('Account') ?></th>
                        <th><?php echo $this->lang->line('Balance') ?></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $i = 1;
                    $gross1 = 0;
                    foreach ($accounts as $row) {
                        if ($row['account_type'] == 'Assets') {
                            $aid = $row['id'];
                            $acn = $row['acn'];
                            $holder = $row['holder'];

                            $balance = $row['lastbal'];
                            $qty = $row['adate'];
                            echo "<tr>
                    <td>$i</td>                    
                    <td>$holder</td>
                    <td>$acn</td>
                   
                    <td>" . amountExchange(abs($balance), 0, $this->aauth->get_user()->loc) . "</td>
                    </tr>";
                            $i++;
                            $gross1 += $balance;
                        }
                    }
                    ?>
                    </tbody>
                    <tfoot>
                    <tr>
                        <th></th>
                        <th></th>

                        <th></th>

                        <th>
                            <h3 class="text-xl-left"><?php echo amountExchange(abs($gross1), 0, $this->aauth->get_user()->loc); ?></h3>
                        </th>
                    </tr>
                    </tfoot>
                </table>

                <h5 class="title bg-gradient-x-danger p-1 white">
                    <?php echo $this->lang->line('Expenses') ?><?php echo $this->lang->line('Accounts') ?>
                </h5>
                <p>&nbsp;</p>
                <table class="table">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th><?php echo $this->lang->line('Name') ?></th>
                        <th><?php echo $this->lang->line('Account') ?></th>
                        <th><?php echo $this->lang->line('Balance') ?></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $i = 1;
                    $gross2 = 0;
                    foreach ($accounts as $row) {
                        if ($row['account_type'] == 'Expenses') {
                            $aid = $row['id'];
                            $acn = $row['acn'];
                            $holder = $row['holder'];

                            $balance = $row['lastbal'];
                            $qty = $row['adate'];
                            echo "<tr>
                    <td>$i</td>                    
                    <td>$holder</td>
                    <td>$acn</td>
                   
                    <td>" . amountExchange(abs($balance), 0, $this->aauth->get_user()->loc) . "</td>
                    </tr>";
                            $i++;
                            $gross2 += $balance;
                        }
                    }
                    ?>
                    </tbody>
                    <tfoot>
                    <tr>
                        <th></th>
                        <th></th>

                        <th></th>

                        <th>
                            <h3 class="text-xl-left"><?php echo amountExchange(abs($gross2), 0, $this->aauth->get_user()->loc); ?></h3>
                        </th>
                    </tr>
                    </tfoot>
                </table>

                <h5 class="title bg-gradient-x-success p-1 white">
                    <?php echo $this->lang->line('Income') ?><?php echo $this->lang->line('Accounts') ?>
                </h5>
                <p>&nbsp;</p>
                <table class="table">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th><?php echo $this->lang->line('Name') ?></th>
                        <th><?php echo $this->lang->line('Account') ?></th>
                        <th><?php echo $this->lang->line('Balance') ?></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $i = 1;
                    $gross3 = 0;
                    foreach ($accounts as $row) {
                        if ($row['account_type'] == 'Income') {
                            $aid = $row['id'];
                            $acn = $row['acn'];
                            $holder = $row['holder'];

                            $balance = $row['lastbal'];
                            $qty = $row['adate'];
                            echo "<tr>
                    <td>$i</td>                    
                    <td>$holder</td>
                    <td>$acn</td>
                   
                    <td>" . amountExchange(abs($balance), 0, $this->aauth->get_user()->loc) . "</td>
                    </tr>";
                            $i++;
                            $gross3 += $balance;
                        }
                    }
                    ?>
                    </tbody>
                    <tfoot>
                    <tr>
                        <th></th>
                        <th></th>

                        <th></th>

                        <th>
                            <h3 class="text-xl-left"><?php echo amountExchange(abs($gross3), 0, $this->aauth->get_user()->loc); ?></h3>
                        </th>
                    </tr>
                    </tfoot>
                </table>

                <h5 class="title bg-gradient-x-warning p-1 white">
                    <?php echo $this->lang->line('Liabilities') ?><?php echo $this->lang->line('Accounts') ?>
                </h5>
                <p>&nbsp;</p>
                <table class="table">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th><?php echo $this->lang->line('Name') ?></th>
                        <th><?php echo $this->lang->line('Account') ?></th>
                        <th><?php echo $this->lang->line('Balance') ?></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $i = 1;
                    $gross4 = 0;
                    foreach ($accounts as $row) {
                        if ($row['account_type'] == 'Liabilities') {
                            $aid = $row['id'];
                            $acn = $row['acn'];
                            $holder = $row['holder'];

                            $balance = $row['lastbal'];
                            $qty = $row['adate'];
                            echo "<tr>
                    <td>$i</td>                    
                    <td>$holder</td>
                    <td>$acn</td>
                   
                    <td>" . amountExchange(abs($balance), 0, $this->aauth->get_user()->loc) . "</td>
                    </tr>";
                            $i++;
                            $gross4 += $balance;
                        }
                    }
                    ?>
                    </tbody>
                    <tfoot>
                    <tr>
                        <th></th>
                        <th></th>

                        <th></th>

                        <th>
                            <h3 class="text-xl-left"><?php echo amountExchange(abs($gross4), 0, $this->aauth->get_user()->loc); ?></h3>
                        </th>
                    </tr>
                    </tfoot>
                </table>

                <h5 class="title bg-gradient-x-grey-blue p-1 white">
                    <?php echo $this->lang->line('Equity') ?><?php echo $this->lang->line('Accounts') ?>
                </h5>
                <p>&nbsp;</p>
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th><?php echo $this->lang->line('Name') ?></th>
                        <th><?php echo $this->lang->line('Account') ?></th>
                        <th><?php echo $this->lang->line('Balance') ?></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $i = 1;
                    $gross5 = 0;
                    foreach ($accounts as $row) {
                        if ($row['account_type'] == 'Equity') {
                            $aid = $row['id'];
                            $acn = $row['acn'];
                            $holder = $row['holder'];

                            $balance = $row['lastbal'];
                            $qty = $row['adate'];
                            echo "<tr>
                    <td>$i</td>                    
                    <td>$holder</td>
                    <td>$acn</td>
                   
                    <td>" . amountExchange(abs($balance), 0, $this->aauth->get_user()->loc) . "</td>
                    </tr>";
                            $i++;
                            $gross5 += $balance;
                        }
                    }
                    ?>
                    </tbody>
                    <tfoot>
                    <tr>
                        <th></th>
                        <th></th>

                        <th></th>

                        <th>
                            <h3 class="text-xl-left"><?php echo amountExchange(abs($gross5), 0, $this->aauth->get_user()->loc); ?></h3>
                        </th>
                    </tr>
                    </tfoot>
                </table>


                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th><?php echo $this->lang->line('Type') ?></th>
                        <th><?php echo $this->lang->line('Balance') ?></th>
                    </tr>
                    </thead>
                    <tbody>

                    <tr>
                        <td><?php echo $this->lang->line('Basic') ?></td>
                        <td><?php echo amountExchange($gross, 0, $this->aauth->get_user()->loc) ?></td>

                    </tr>
                    <tr>
                        <td><?php echo $this->lang->line('Assets') ?></td>
                        <td><?php echo amountExchange($gross1, 0, $this->aauth->get_user()->loc) ?></td>

                    </tr>
                    <tr>
                        <td><?php echo $this->lang->line('Expenses') ?></td>
                        <td><?php echo amountExchange($gross2, 0, $this->aauth->get_user()->loc) ?></td>

                    </tr>
                    <tr>
                        <td><?php echo $this->lang->line('Income') ?></td>
                        <td><?php echo amountExchange($gross3, 0, $this->aauth->get_user()->loc) ?></td>

                    </tr>
                    <tr>
                        <td><?php echo $this->lang->line('Liabilities') ?></td>
                        <td><?php echo amountExchange($gross4, 0, $this->aauth->get_user()->loc) ?></td>

                    </tr>
                    <tr>
                        <td><?php echo $this->lang->line('Equity') ?></td>
                        <td><?php echo amountExchange($gross5, 0, $this->aauth->get_user()->loc) ?></td>

                    </tr>
                    </tbody>
                    <tfoot>

                    </tfoot>
                </table>

            </div>
        </div>
    </div>
    <script type="text/javascript">
        $(document).ready(function () {

            //datatables
            $('.dtable').DataTable({responsive: true});
            $('#start_date').datepicker('setDate', '<?php echo $_GET['sdate'] ?>');
            $('#end_date').datepicker('setDate', '<?php echo $_GET['edate'] ?>');

        });
    </script>