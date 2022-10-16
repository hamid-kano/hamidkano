<div class="content-body">

    <div class="card card-block bg-white">
        <div id="notify" class="alert alert-success" style="display:none;">
            <a href="#" class="close" data-dismiss="alert">&times;</a>

            <div class="message"></div>
        </div>
        <form method="post" id="data_form" class="card-body">


            <h5><?php echo $this->lang->line('Employee Details') ?> </h5>
            <hr>
            <div class="form-group row">

                <label class="col-sm-6 col-form-label"
                       for="name"><?php echo $this->lang->line('UserName') ?>
                    <small class="error">(Use Only a-z0-9)</small>
                </label>

                <div class="col-sm-10">
                    <input type="text"
                           class="form-control margin-bottom required" name="username"
                           placeholder="username">
                </div>
            </div>

            <div class="form-group row">

                <label class="col-sm-6 col-form-label" for="email">Email</label>

                <div class="col-sm-10">
                    <input type="email" placeholder="email"
                           class="form-control margin-bottom required" name="email"
                           placeholder="email">
                </div>
            </div>
            <div class="form-group row">

                <label class="col-sm-6 col-form-label"
                       for="password"><?php echo $this->lang->line('Password') ?>
                    <small>(min length 6 | max length 20 | a-zA-Z 0-9 @ $)</small>
                </label>

                <div class="col-sm-10">
                    <input type="text" placeholder="Password"
                           class="form-control margin-bottom required" name="password"
                           placeholder="password">
                </div>
            </div>
            <?php if ($this->aauth->get_user()->roleid >= 0) { ?>
                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"
                           for="name"><?php echo $this->lang->line('UserRole') ?></label>

                    <div class="col-sm-5">
                        <select name="roleid" class="form-control margin-bottom">
                            <option value="4"><?= $this->lang->line('Business Manager') ?></option>
                            <option value="3"><?= $this->lang->line('Sales Manager') ?></option>
                            <option value="5"><?= $this->lang->line('Business Owner') ?></option>
                            <option value="2"><?= $this->lang->line('Sales Person') ?></option>
                            <option value="1"><?= $this->lang->line('Inventory Manager') ?></option>
                            <option value="-1"><?= $this->lang->line('Project Manager') ?></option>
                        </select>
                    </div>
                </div>


            <?php } ?>

            <div class="form-group row">

                <label class="col-sm-2 col-form-label"
                       for="name"><?php echo $this->lang->line('Business Location') ?></label>

                <div class="col-sm-5">
                    <select name="location" class="form-control margin-bottom">
                        <option value="0"><?php echo $this->lang->line('Default') ?></option>
                        <?php $loc = locations();

                        foreach ($loc as $row) {
                            echo ' <option value="' . $row['id'] . '"> ' . $row['cname'] . '</option>';
                        }

                        ?>
                    </select>
                </div>
            </div>

            <hr>

            <div class="form-group row">

                <label class="col-sm-2 col-form-label"
                       for="name"><?php echo $this->lang->line('Name') ?></label>

                <div class="col-sm-10">
                    <input type="text" placeholder="Name"
                           class="form-control margin-bottom required" name="name"
                           placeholder="Full name">
                </div>
            </div>
            <div class="form-group row">

                <label class="col-sm-2 col-form-label"
                       for="address"><?php echo $this->lang->line('Address') ?></label>

                <div class="col-sm-10">
                    <input type="text" placeholder="address"
                           class="form-control margin-bottom" name="address">
                </div>
            </div>
            <div class="form-group row">

                <label class="col-sm-2 col-form-label"
                       for="city"><?php echo $this->lang->line('City') ?></label>

                <div class="col-sm-10">
                    <input type="text" placeholder="City"
                           class="form-control margin-bottom" name="city">
                </div>
            </div>
            <div class="form-group row">

                <label class="col-sm-2 col-form-label"
                       for="city"><?php echo $this->lang->line('Region') ?></label>

                <div class="col-sm-10">
                    <input type="text" placeholder="Region"
                           class="form-control margin-bottom" name="region">
                </div>
            </div>
            <div class="form-group row">

                <label class="col-sm-2 col-form-label"
                       for="country"><?php echo $this->lang->line('Country') ?></label>

                <div class="col-sm-10">
                    <input type="text" placeholder="Country"
                           class="form-control margin-bottom" name="country">
                </div>
            </div>

            <div class="form-group row">

                <label class="col-sm-2 col-form-label"
                       for="postbox"><?php echo $this->lang->line('Postbox') ?></label>

                <div class="col-sm-10">
                    <input type="text" placeholder="Postbox"
                           class="form-control margin-bottom" name="postbox">
                </div>
            </div>
            <div class="form-group row">

                <label class="col-sm-2 col-form-label"
                       for="phone"><?php echo $this->lang->line('Phone') ?></label>

                <div class="col-sm-10">
                    <input type="text" placeholder="phone"
                           class="form-control margin-bottom" name="phone">
                </div>
            </div>
            <div class="form-group row">

                <label class="col-sm-2 col-form-label"
                       for="phone"><?php echo $this->lang->line('Salary') ?></label>

                <div class="col-sm-5">
                    <input type="text" placeholder="Salary" onkeypress="return isNumber(event)"
                           class="form-control margin-bottom" name="salary"
                           value="0">
                </div>
            </div>
            <div class="form-group row">

                <label class="col-sm-2 col-form-label"
                       for="city"><?php echo $this->lang->line('Sales') ?> <?php echo $this->lang->line('Commission') ?>
                    %</label>

                <div class="col-sm-2">
                    <input type="number" placeholder="Commission %" value="0"
                           class="form-control margin-bottom" name="commission">
                </div>
                <small class="col">It will based on each invoice amount - inclusive all
                    taxes,shipping,discounts
                </small>

            </div>
            <div class="form-group row">

                <label class="col-sm-2 col-form-label"
                       for="name"><?php echo $this->lang->line('Department') ?></label>

                <div class="col-sm-5">
                    <select name="department" class="form-control margin-bottom">

                        <option value="0"><?php echo $this->lang->line('Default') . ' - ' . $this->lang->line('No') ?></option>
                        <?php

                        foreach ($dept as $row) {
                            echo ' <option value="' . $row['id'] . '"> ' . $row['val1'] . '</option>';
                        }

                        ?>
                    </select>
                </div>
            </div>

            <div class="form-group row">

                <label class="col-sm-2 col-form-label"></label>

                <div class="col-sm-4">
                    <input type="submit" id="submit-data" class="btn btn-success margin-bottom"
                           value="<?php echo $this->lang->line('Add') ?>"
                           data-loading-text="Adding...">
                    <input type="hidden" value="employee/submit_user" id="action-url">
                </div>
            </div>


        </form>
    </div>

</div>

<script type="text/javascript">
    $("#profile_add").click(function (e) {
        e.preventDefault();
        var actionurl = baseurl + 'user/submit_user';
        actionProduct1(actionurl);
    });
</script>

<script>

    function actionProduct1(actionurl) {

        $.ajax({

            url: actionurl,
            type: 'POST',
            data: $("#product_action").serialize(),
            dataType: 'json',
            success: function (data) {
                $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                $("#notify").removeClass("alert-warning").addClass("alert-success").fadeIn();


                $("html, body").animate({scrollTop: $('html, body').offset().top}, 200);
                $("#product_action").remove();
            },
            error: function (data) {
                $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                $("#notify").removeClass("alert-success").addClass("alert-warning").fadeIn();
                $("html, body").animate({scrollTop: $('#notify').offset().top}, 1000);

            }

        });


    }
</script>