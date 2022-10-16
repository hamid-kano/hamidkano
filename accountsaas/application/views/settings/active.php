<article class="content-body">
    <div class="card card-block">
        <div id="notify" class="alert alert-success" style="display:none;">
            <a href="#" class="close" data-dismiss="alert">&times;</a>

            <div class="message"></div>
        </div>
        <form method="post" id="activ" class="form-horizontal">
            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>"
                   value="<?php echo $this->security->get_csrf_hash(); ?>">
            <input type="hidden" id="core"
                   value="settings/activate">
            <div class="card-body">

                <h5>Activate Geo POS</h5>
                <hr>


                <div class="form-group row">

                    <label class="col-sm-2 col-form-label" for="invoiceprefix">Email</label>

                    <div class="col-sm-6">
                        <input type="text"
                               class="form-control margin-bottom  required" name="email"
                               placeholder="Your Email Address">
                    </div>
                </div>

                <div class="form-group row">

                    <label class="col-sm-2 col-form-label" for="currency">Envato Purchase Code</label>

                    <div class="col-sm-6">
                        <input type="text" placeholder="Envato Activation Code"
                               class="form-control margin-bottom  required" name="code"
                        >
                    </div>
                </div>

                <div class="form-group row">

                    <label class="col-sm-2 col-form-label" for="currency">License</label>

                    <div class="col-sm-6">
                        <p>Single Use Standard License. Read The Full License Here <a
                                    href="https://codecanyon.net/licenses/standard">https://codecanyon.net/licenses/standard</a>.
                            You can not activate the application on multiple domains with single key.
                        </p>
                    </div>
                </div>


                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"></label>

                    <div class="col-sm-4">
                        <input type="submit" id="upda" class="btn btn-success margin-bottom"
                               value="Update" data-loading-text="Updating...">
                    </div>
                </div>

            </div>
        </form>
    </div>
</article>

