<div class="content-body">

    <div class="row">
        <div class="col-md-8">
            <div class="card card-block">
                <div id="notify" class="alert alert-success" style="display:none;">
                    <a href="#" class="close" data-dismiss="alert">&times;</a>

                    <div class="message"></div>
                </div>
                <div id="errors" class="well"></div>
                <form method="post" id="product_action" class="form-horizontal">
                    <div class="card-body">

                        <h5><?php echo $this->lang->line('Update Your Password') ?> (<?php echo $user['username'] ?>
                            )</h5>
                        <hr>


                        <div class="form-group row">

                            <label class="col-sm-2 col-form-label"
                                   for="cpassword"><?php echo $this->lang->line('Current Password') ?></label>

                            <div class="col-sm-10">
                                <input type="password" placeholder="Current Password"
                                       class="form-control margin-bottom  required" name="cpassword">
                            </div>
                        </div>


                        <div class="form-group row">

                            <label class="col-sm-2 col-form-label"
                                   for="address"><?php echo $this->lang->line('New Password') ?></label>

                            <div class="col-sm-10">
                                <input type="password" placeholder="New Password"
                                       class="form-control margin-bottom  required" name="newpassword"
                                       id="user-pass">
                            </div>
                        </div>
                        <div class="form-group row">

                            <label class="col-sm-2 col-form-label"
                                   for="address"><?php echo $this->lang->line('Re New Password') ?></label>

                            <div class="col-sm-10">
                                <input type="password" placeholder="Re New Password"
                                       class="form-control margin-bottom  required" name="renewpassword"
                                       id="user-pass2">
                            </div>
                        </div>


                        <div class="form-group row">

                            <label class="col-sm-2 col-form-label"></label>

                            <div class="col-sm-4">
                                <input type="submit" id="password_update" class="btn btn-success margin-bottom"
                                       value="<?php echo $this->lang->line('Update Password') ?>"
                                       data-loading-text="Updating...">
                            </div>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="<?php echo assets_url(); ?>assets/myjs/jquery.password-validation.js" type="text/javascript"></script>
<script>
    $(document).ready(function () {
        $("#user-pass").passwordValidation({"confirmField": "#user-pass2"}, function (element, valid, match, failedCases) {

            $("#errors").html("<div class='alert alert-warning mb-2' role='alert'><strong>Password Rules</strong><br>" + failedCases.join("<br>") + "</div>");

            if (valid) $(element).css("border", "2px solid green");
            if (!valid) {
                $(element).css("border", "2px solid red");
                $('#password_update').attr('disabled', 'disabled');
            }
            if (valid && match) {
                $("#user-pass2").css("border", "2px solid green");
                $('#errors').html('');
                $('#password_update').removeAttr('disabled');
            }
            if (!valid || !match) {
                $("#user-pass2").css("border", "2px solid red");
                $('#password_update').attr('disabled', 'disabled');
            }
        });
    });
</script>
<script type="text/javascript">
    $("#password_update").click(function (e) {
        e.preventDefault();
        var actionurl = baseurl + 'user/updatepassword';
        actionProduct(actionurl);
    });
</script>