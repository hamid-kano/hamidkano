<article class="content">
    <div class="card card-block">
        <div id="notify" class="alert alert-success" style="display:none;">
            <a href="#" class="close" data-dismiss="alert">&times;</a>

            <div class="message"></div>
        </div>
        <form method="post" id="data_form" class="form-horizontal">
            <div class="grid_3 grid_4">

                <h5><?php echo $this->lang->line('Change Customer Password') ?> (<?php echo $customer['name'] ?>)</h5>
                <hr>


                <input type="hidden" name="id" value="<?php echo $customer['id'] ?>">


                <div class="form-group row">

                    <label class="col-sm-2 col-form-label" for="email">Email</label>

                    <div class="col-sm-6">
                        <input type="text" placeholder="email"
                               class="form-control margin-bottom  required" name="email"
                               value="<?php echo $customer['email'] ?>" readonly>
                    </div>
                </div>
                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"
                           for="password"><?php echo $this->lang->line('Password') ?></label>

                    <div class="col-sm-6">
                        <input type="text"
                               class="form-control margin-bottom  required" name="password" placeholder="Password">
                    </div>
                </div>


                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"></label>

                    <div class="col-sm-4">
                        <input type="submit" id="submit-data" class="btn btn-success margin-bottom"
                               value="Update customer" data-loading-text="Updating...">
                        <input type="hidden" value="customers/changepassword" id="action-url">
                    </div>
                </div>

            </div>
        </form>
    </div>
</article>

