<div class="content-body">
    <div class="card">
        <div class="card-header">
            <h5><?php echo $this->lang->line('Add') . ' ' . $this->lang->line('Payroll') . ' ' . $this->lang->line('Transactions') ?></h5>
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

                    <hr>
                    <input type="hidden" name="ty_p" value="4">
                    <div class="form-group row">
                        <label for="cst"
                               class="caption col-sm-2 col-form-label"><?php echo $this->lang->line('Search Payer') ?>

                        </label>
                        <div class="col-6"><input type="text" class="form-control" name="cst" id="trans-box"
                                                  placeholder="Enter Employee Name or Mobile Number to search"
                                                  autocomplete="off"/>

                            <div id="trans-box-result" class="sbox-result"></div>
                        </div>


                    </div>
                    <div id="customerpanel" class="form-group row">
                        <label for="toBizName"
                               class="caption col-sm-2 col-form-label"><?php echo $this->lang->line('C/o') ?> <span
                                    style="color: red;">*</span></label>
                        <div class="col-sm-6"><input type="hidden" name="payer_id" id="customer_id" value="0">
                            <input type="text" class="form-control required" name="payer_name" id="customer_name">
                        </div>
                    </div>

                    <div class="form-group row">

                        <label class="col-sm-2 col-form-label"
                               for="pay_cat"><?php echo $this->lang->line('Account') ?></label>

                        <div class="col-sm-6">
                            <select name="pay_acc" class="form-control">
                                <?php
                                foreach ($accounts as $row) {
                                    $cid = $row['id'];
                                    $acn = $row['acn'];
                                    $holder = $row['holder'];
                                    echo "<option value='$cid'>$acn - $holder</option>";
                                }
                                ?>
                            </select>


                        </div>
                    </div>

                    <input type="hidden" name="act" value="add_product">


                    <div class="form-group row">

                        <label class="col-sm-2 col-form-label"
                               for="date"><?php echo $this->lang->line('Date') ?></label>

                        <div class="col-sm-6">
                            <input type="text" class="form-control required"
                                   name="date" data-toggle="datepicker"
                                   autocomplete="false">
                        </div>
                    </div>
                    <div class="form-group row">

                        <label class="col-sm-2 col-form-label"
                               for="amount"><?php echo $this->lang->line('Amount') ?></label>

                        <div class="col-sm-6">
                            <input type="text" placeholder="Amount" onkeypress="return isNumber(event)"
                                   class="form-control margin-bottom  required" name="amount" id="eamt">
                        </div>
                    </div>
                    <div class="form-group row">

                        <label class="col-sm-2 control-label"
                               for="product_price"><?php echo $this->lang->line('Type') ?></label>

                        <div class="col-sm-6">
                            <div class="input-group">
                                <select name="pay_type" class="form-control">
                                    <option value="Expense" selected><?php echo $this->lang->line('Expense') ?></option>
                                    <option value="Income"><?php echo $this->lang->line('Income') ?></option>


                                </select>

                            </div>
                        </div>
                    </div>
                    <div class="form-group row">

                        <label class="col-sm-2 col-form-label"
                               for="pay_cat"><?php echo $this->lang->line('Category') ?></label>

                        <div class="col-sm-6">
                            <select name="pay_cat" class="form-control">
                                <option value='EmployeePayment'>Employee Payment</option>
                                <?php
                                foreach ($cat as $row) {
                                    $cid = $row['id'];
                                    $title = $row['name'];
                                    echo "<option value='$title'>$title</option>";
                                }
                                ?>
                            </select>


                        </div>
                    </div>

                    <div class="form-group row">

                        <label class="col-sm-2 control-label"
                               for="product_price"><?php echo $this->lang->line('Method') ?> </label>

                        <div class="col-sm-6">
                            <div class="input-group">
                                <select name="paymethod" class="form-control">
                                    <option value="Cash" selected><?php echo $this->lang->line('Cash') ?></option>
                                    <option value="Card"><?php echo $this->lang->line('Card') ?></option>
                                    <option value="Cheque"><?php echo $this->lang->line('Cheque') ?></option>
                                </select>

                            </div>
                        </div>
                    </div>
                    <div class="form-group row">

                        <label class="col-sm-2 col-form-label"><?php echo $this->lang->line('Note') ?></label>

                        <div class="col-sm-6">
                            <input type="text" placeholder="Note"
                                   class="form-control" name="note">
                        </div>
                    </div>
                    <!---- Dual -->
                    <?php if ($dual['key1']) { ?>
                        <hr><h4 class="purple"><?php echo $this->lang->line('Dual Entry') ?></h4>
                        <div id="customerpanel" class="form-group row bg-purple bg-lighten-4 pb-1">


                            <div class="col-sm-4"><label class=" col-form-label"
                                                         for="f_pay_cat"><?php echo $this->lang->line('From') . ' ' . $this->lang->line('Account') ?></label>
                                <select name="f_pay_acc" class="form-control">
                                    <?php
                                    foreach ($accounts as $row) {
                                        $cid = $row['id'];
                                        $acn = $row['acn'];
                                        $holder = $row['holder'];
                                        echo "<option value='$cid'>$acn - $holder</option>";
                                    }
                                    ?>
                                </select>


                            </div>


                            <div class="col-sm-4"><label class="col-form-label"
                                                         for="f_pay_cat"><?php echo $this->lang->line('From') . ' ' . $this->lang->line('Category') ?></label>
                                <select name="f_pay_cat" class="form-control">
                                    <?php
                                    foreach ($cat as $row) {
                                        $cid = $row['id'];
                                        $title = $row['name'];
                                        echo "<option value='$title'>$title</option>";
                                    }
                                    ?>
                                </select>


                            </div>


                            <div class="col-sm-4"><label class="col-form-label"
                                                         for="f_paymethod"><?php echo $this->lang->line('From') . ' ' . $this->lang->line('Method') ?> </label>

                                <select name="f_paymethod" class="form-control">
                                    <option value="Cash" selected><?php echo $this->lang->line('Cash') ?></option>
                                    <option value="Card"><?php echo $this->lang->line('Card') ?></option>
                                    <option value="Cheque"><?php echo $this->lang->line('Cheque') ?></option>
                                    <option value="Bank"><?php echo $this->lang->line('Bank') ?></option>
                                    <option value="Other"><?php echo $this->lang->line('Other') ?></option>
                                </select>


                            </div>


                        </div>
                        <div class="form-group row  bg-lighten-4 pb-1">

                            <div class="col-sm-8"><label
                                        class="col-form-label"><?php echo $this->lang->line('From') . ' ' . $this->lang->line('Note') ?></label>
                                <input type="text" placeholder="Note"
                                       class="form-control" name="f_note">
                            </div>
                        </div>
                    <?php } ?>

                    <div class="form-group row">

                        <label class="col-sm-2 col-form-label"></label>

                        <div class="col-sm-4">
                            <input type="submit" id="submit-data" class="btn btn-success margin-bottom"
                                   value="<?php echo $this->lang->line('Add transaction') ?>"
                                   data-loading-text="Adding...">
                            <input type="hidden" value="transactions/save_trans" id="action-url">
                        </div>
                    </div>


                </form>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $("#trans-box").keyup(function () {
        $.ajax({
            type: "GET",
            url: baseurl + 'employee/emp_search',
            data: 'keyword=' + $(this).val() + '&ty=' + $('input[name=ty_p]:checked').val(),
            beforeSend: function () {
                $("#trans-box").css("background", "#FFF url(" + baseurl + "assets/custom/load-ring.gif) no-repeat 165px");
            },
            success: function (data) {
                $("#trans-box-result").show();
                $("#trans-box-result").html(data);
                $("#trans-box").css("background", "none");

            }
        });
    });

    function selectPay(cid, cname, salary) {
        $('#customer_id').val(cid);
        $('#customer_name').html('<strong>' + cname + '</strong>');
        $('#customer_name').val(cname);
        $('#eamt').val(salary);
        $("#customer-box").val();
        $("#customer-box-result").hide();
        $(".sbox-result").hide();
        $("#customer").show();
    }
</script>
