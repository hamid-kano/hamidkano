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
                    <a href="<?php echo base_url().'accounts/summary'?>" class="btn btn-success"><?php echo $this->lang->line('Show All') ?></a>
                </h5>  
                <?php } ?>

                <table class="table">
                    <thead>
                    <tr class="text-center">
                        <th></th>
                        <th colspan="2"><?php echo $this->lang->line('Intial Balance') ?></th>
                        <th colspan="2"><?php echo $this->lang->line('Movement') ?></th>
                        <th colspan="2"><?php echo $this->lang->line('Net Movement') ?></th>
                        <th colspan="2"><?php echo $this->lang->line('Balance') ?></th>
                    </tr>
                    <tr class="text-center">
                        <th rowspan="2"><?php echo $this->lang->line('Account') ?></th>
                        <th><?php echo $this->lang->line('Debit') ?></th>
                        <th><?php echo $this->lang->line('Credit') ?></th>
                        <th><?php echo $this->lang->line('Debit') ?></th>
                        <th><?php echo $this->lang->line('Credit') ?></th>
                        <th><?php echo $this->lang->line('Debit') ?></th>
                        <th><?php echo $this->lang->line('Credit') ?></th>
                        <th><?php echo $this->lang->line('Debit') ?></th>
                        <th><?php echo $this->lang->line('Credit') ?></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $gross = 0;
                    foreach ($accounts as $parent) {
                        if(!$parent['parent_id']) {
                             echo "<tr>
                    <td colspan='9'>".$parent['acn'] ." - ".$parent['holder']."</td>
                    </tr>";
                    foreach ($accounts as $row) {
                            if($row['parent_id'] && substr( $row['acn'], 0, 1 ) == substr( $parent['acn'], 0, 1 )) {
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
                            $initial_balance_debit = $row['type'] == 'debit' ? $balance : 0;
                            $initial_balance_credit = $row['type'] == 'credit' ? $balance : 0;
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
                            $balance_debit = $row['type'] == 'debit'  ? $balance : 0;
                            $balance_credit = $row['type'] == 'credit' ? $balance : 0;
                            $difference = abs($debit - $credit);
                            $net_debit = $debit > $credit ? $difference : 0;
                            $net_credit = $credit > $debit ? $difference : 0;
                            echo "<tr>
                    <td>".$acn ." - ". "$holder</td>
                    <td>" . amountExchange(abs($initial_balance_debit), 0, $this->aauth->get_user()->loc) . "</td>
                    <td>" . amountExchange($initial_balance_credit, 0, $this->aauth->get_user()->loc) . "</td>
                    <td>" . amountExchange($debit, 0, $this->aauth->get_user()->loc) . "</td>
                    <td>" . amountExchange($credit, 0, $this->aauth->get_user()->loc) . "</td>
                    <td>" . amountExchange($net_debit, 0, $this->aauth->get_user()->loc) . "</td>
                    <td>" . amountExchange($net_credit, 0, $this->aauth->get_user()->loc) . "</td>
                    <td>" . amountExchange(abs($balance_debit), 0, $this->aauth->get_user()->loc) . "</td>
                    <td>" . amountExchange($balance_credit, 0, $this->aauth->get_user()->loc) . "</td>
                    </tr>";
                            $gross1 += abs($initial_balance_debit);
                            $gross2 += $initial_balance_credit;
                            $gross3 += $debit;
                            $gross4 += $credit;
                            $gross5 += $net_debit;
                            $gross6 += $net_credit;
                            $gross7 += abs($balance_debit);
                            $gross8 += $balance_credit;
                    }
                    }
                    }
                    
                    }
                    ?>
                    </tbody>
                    <tfoot>
                    <tr>
                        <th><?php echo $this->lang->line('Total') ?></th>
                        <th><?php echo amountExchange($gross1, 0, $this->aauth->get_user()->loc); ?></th>
                        <th><?php echo amountExchange($gross2, 0, $this->aauth->get_user()->loc); ?></th>
                        <th><?php echo amountExchange($gross3, 0, $this->aauth->get_user()->loc); ?></th>
                        <th><?php echo amountExchange($gross4, 0, $this->aauth->get_user()->loc); ?></th>
                        <th><?php echo amountExchange($gross5, 0, $this->aauth->get_user()->loc); ?></th>
                        <th><?php echo amountExchange($gross6, 0, $this->aauth->get_user()->loc); ?></th>
                        <th><?php echo amountExchange($gross7, 0, $this->aauth->get_user()->loc); ?></th>
                        <th><?php echo amountExchange($gross8, 0, $this->aauth->get_user()->loc); ?></th>
                    </tr>
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