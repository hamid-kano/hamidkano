<div class="content">
    <div id="notify" class="alert alert-success" style="display:none;">
        <a href="#" class="close" data-dismiss="alert">&times;</a>

        <div class="message"></div>
    </div>


    <div class="card card-body">
        <h4><?php echo $this->lang->line('Products') . ' ' . $this->lang->line('Sales') . ' ' . $this->lang->line('Report') ?></h4>
        <hr>

        <div class="row">
            <div class="col-md-6 ">
                <ul class="list-unstyled">
                    <li class="font-large-x1 blue "><?php echo $this->lang->line('Total') . ' ' . $this->lang->line('Sales') ?>
                        <span id="p3" class="font-large-x1 red float-xs-right"><i
                                    class=" icon-refresh spinner"></i></span>
                    </li>
                    <hr>
                    <li class="font-large-x1 green"><?php echo $this->lang->line('Total') . ' ' . $this->lang->line('Products') . ' ' . $this->lang->line('Qty') ?>
                        <span id="p1" class="font-large-x1 blue float-xs-right"><i
                                    class=" icon-refresh spinner"></i></span></li>
                    <hr>
                    <li class="font-large-x1 indigo"><?php echo $this->lang->line('Month') ?> <span id="p4"
                                                                                                    class="font-large-x1 orange float-xs-right"><i
                                    class=" icon-refresh spinner"></i></span></li>
                    <hr>
                    <li class="font-large-x1 blue-light"><?php echo $this->lang->line('Month') . ' ' . $this->lang->line('Products') . ' ' . $this->lang->line('Qty') ?>
                        <span id="p2" class="font-large-x1 green float-xs-right"><i
                                    class=" icon-refresh spinner"></i></span></li>
                    <li class="font-large-x1 orange" id="param1"></li>

                </ul>
            </div>

        </div>

    </div>


    <div class="card card-block">
        <div class="row">
            <div class="col-md-6">
                <div class="card-body">
                    <form method="post" id="product_action" class="form-horizontal">
                        <div class="grid_3 grid_4">
                            <h4><?php echo $this->lang->line('Products') . ' ' . $this->lang->line('Sales') . ' ' . $this->lang->line('Custom Range') ?></h4>
                            <hr>


                            <div class="form-group row">

                                <label class="col-sm-4 col-form-label"
                                       for="pay_cat"><?php echo $this->lang->line('Business Locations') ?></label>

                                <div class="col-sm-6">
                                    <select name="pay_acc" class="form-control">
                                        <option value='0'><?php echo $this->lang->line('All') ?></option>
                                        <?php
                                        foreach ($locations as $row) {
                                            $cid = $row['id'];
                                            $acn = $row['cname'];
                                            $holder = $row['address'];
                                            echo "<option value='$cid'>$acn - $holder</option>";
                                        }
                                        ?>
                                    </select>


                                </div>
                            </div>


                            <div class="form-group row">

                                <label class="col-sm-4 control-label"
                                       for="sdate"><?php echo $this->lang->line('From Date') ?></label>

                                <div class="col-sm-4">
                                    <input type="text" class="form-control required"
                                           placeholder="Start Date" name="sdate" id="sdate"
                                           data-toggle="datepicker" autocomplete="false">
                                </div>
                            </div>
                            <div class="form-group row">

                                <label class="col-sm-4 control-label"
                                       for="edate"><?php echo $this->lang->line('To Date') ?></label>

                                <div class="col-sm-4">
                                    <input type="text" class="form-control required"
                                           placeholder="End Date" name="edate"
                                           data-toggle="datepicker" autocomplete="false">
                                </div>
                            </div>


                            <div class="form-group row">

                                <label class="col-sm-4 col-form-label"></label>

                                <div class="col-sm-4">
                                    <input type="hidden" name="check" value="ok">
                                    <input type="submit" id="calculate_p" class="btn btn-success margin-bottom"
                                           value="<?php echo $this->lang->line('Calculate') ?>"
                                           data-loading-text="Calculating...">
                                </div>
                            </div>
                        </div>

                    </form>
                </div>

            </div>
            <div class="col-md-6">
                <div class="card-body">
                    <form method="post" id="product_action2" class="form-horizontal">
                        <div class="grid_3 grid_4">
                            <h4><?php echo $this->lang->line('Products') . ' ' . $this->lang->line('Sales') . ' ' . $this->lang->line('Custom Range') ?></h4>
                            <hr>


                            <div class="form-group row">

                                <label class="col-sm-4 col-form-label"
                                       for="pay_cat"><?php echo $this->lang->line('Product Category') ?></label>

                                <div class="col-sm-6">
                                    <select name="pay_acc" class="form-control">
                                        <option value='0'><?php echo $this->lang->line('All') ?></option>
                                        <?php
                                        foreach ($cat as $row) {
                                            $cid = $row['id'];
                                            $title = $row['title'];
                                            echo "<option value='$cid'>$title</option>";
                                        }
                                        ?>
                                    </select>


                                </div>
                            </div>


                            <div class="form-group row">

                                <label class="col-sm-4 control-label"
                                       for="sdate"><?php echo $this->lang->line('From Date') ?></label>

                                <div class="col-sm-4">
                                    <input type="text" class="form-control date30 required"
                                           placeholder="Start Date" name="sdate"
                                           data-toggle="datepicker" autocomplete="false">
                                </div>
                            </div>
                            <div class="form-group row">

                                <label class="col-sm-4 control-label"
                                       for="edate"><?php echo $this->lang->line('To Date') ?></label>

                                <div class="col-sm-4">
                                    <input type="text" class="form-control required"
                                           placeholder="End Date" name="edate"
                                           data-toggle="datepicker" autocomplete="false">
                                </div>
                            </div>


                            <div class="form-group row">

                                <label class="col-sm-4 col-form-label"></label>

                                <div class="col-sm-4">
                                    <input type="hidden" name="check" value="ok">
                                    <input type="submit" id="calculate_p_pc" class="btn btn-success margin-bottom"
                                           value="<?php echo $this->lang->line('Calculate') ?>"
                                           data-loading-text="Calculating...">
                                </div>
                            </div>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>

</div>
<script type="text/javascript">
    $("#calculate_p").click(function (e) {
        e.preventDefault();
        var actionurl = baseurl + 'reports/customproducts';
        actionCaculate(actionurl);
    });

    $("#calculate_p_pc").click(function (e) {
        e.preventDefault();
        var actionurl = baseurl + 'reports/customproducts_cat';
        actionCaculate(actionurl, '#product_action2');
    });

    setTimeout(function () {
        $.ajax({
            url: baseurl + 'reports/fetch_data?p=products',
            dataType: 'json',
            success: function (data) {
                $('#p1').html(data.p1);
                $('#p2').html(data.p2);
                $('#p3').html(data.p3);
                $('#p4').html(data.p4);
            },
            error: function (data) {
                $('#response').html('Error')
            }

        });
    }, 2000);
</script>