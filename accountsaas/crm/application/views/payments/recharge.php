<div class="app-content content container-fluid">
    <div class="content-wrapper">


        <div class="content-body">
            <section class="card">
                <div class="card-block">
<h2 class="text-xs-center">Current Balance is <?= amountFormat($balance) ?></h2>




                </div>
                <div class="card-block">
                    <form method="get" action="<?php echo substr(base_url(),0,-4) ?>billing/recharge">
                        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">
                        <input type="hidden" value="<?=base64_encode($this->session->userdata('user_details')[0]->cid) ?>" name="id">

                        <div class="form-group row">

                            <label class="col-sm-2 col-form-label"
                                   for="amount"><?php echo $this->lang->line('Amount') ?></label>

                            <div class="col-sm-3">
                                <input type="number" placeholder="Enter amount in 0.00"
                                       class="form-control margin-bottom " name="amount">
                            </div>
                        </div>
                         <div class="form-group row ">
                                        <label for="gid" class="col-sm-2 col-form-label"><?php echo $this->lang->line('Payment Gateways') ?></label> <div class="col-sm-3">
                                        <select class="form-control" name="gid"><?php

                                            $surcharge_t = false;
                                            foreach ($gateway as $row) {
                                                $cid = $row['id'];
                                                $title = $row['name'];
                                                if ($row['surcharge'] > 0) {
                                                    $surcharge_t = true;
                                                    $fee = '(+' . amountFormat_s($row['surcharge']) . ' %)';
                                                } else {
                                                    $fee = '';
                                                }
                                                echo "<option value='$cid'>$title $fee</option>";
                                            }
                                            ?>
                                        </select>

                                    </div>   </div>

                        <div class="form-group row">

                            <label class="col-sm-2 col-form-label"
                                   for="name"></label>

                            <div class="col-sm-3">
                                <input type="submit" class="btn btn-lg btn-success">
                            </div>
                        </div>



                    </form>



                </div>
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
                            <td>' . amountFormat($row['col1']) . '</td><td>' . $row['col2'] . '</td>
                           
                        </tr>';
                    } ?>

                    </tbody>
                </table>
        </div>

            </section>
        </div>
    </div>
</div>
