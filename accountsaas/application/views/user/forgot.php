<body class="horizontal-layout horizontal-menu 1-column  bg-full-screen-image menu-expanded blank-page blank-page"
      data-open="hover" data-menu="horizontal-menu" data-col="1-column">
<!-- ////////////////////////////////////////////////////////////////////////////-->
<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-header row">
        </div>
        <div class="content-body">
            <section class="flexbox-container">
                <div class="col-md-4 offset-md-4 col-xs-10 offset-xs-1 box-shadow-2 p-0">
                    <div class="card border-grey border-lighten-3 px-2 py-2 m-0">
                        <div class="card-header no-border pb-0">
                            <div class="card-title text-center">
                                <img style="max-height: 10rem;"
                                     src="<?php echo base_url('userfiles/company/') . $this->config->item('logo'); ?>"
                                     alt="Logo" class="img-responsive">
                            </div>
                            <h6 class="card-subtitle line-on-side text-muted text-xs-center font-small-3 pt-2">
                                <span><?php echo $this->lang->line('link to reset your password') ?>.</span>
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="card-block">
                                <div id="notify" class="alert alert-success" style="display:none;">


                                    <div class="message"></div>
                                </div>
                                <form id="data_form" class="form-horizontal" novalidate>
                                    <fieldset class="form-group position-relative has-icon-left">
                                        <input type="email" name="email" class="form-control form-control-lg input-lg"
                                               id="user-email"
                                               placeholder="<?php echo $this->lang->line('Your Email') ?>" required>
                                        <div class="form-control-position">
                                            <i class="icon-mail6"></i>
                                        </div>
                                    </fieldset>
                                    <button id="submit-data" class="btn btn-primary btn-lg btn-block"><i
                                                class="icon-lock4"
                                                data-loading-text="Loading..."></i> <?php echo $this->lang->line('Recover Password') ?>
                                    </button>
                                    <input type="hidden" id="action-url" value="user/send_reset">
                                </form>
                            </div>
                        </div>
                        <div class="card-footer no-border">
                            <p class="float-sm-left text-xs-center"><a href="<?php echo base_url('user'); ?>"
                                                                       class="card-link"><?php echo $this->lang->line('Login') ?></a>
                            </p>

                        </div>
                    </div>
                </div>
            </section>

        </div>
    </div>
</div>
<script type="text/javascript">
    //universal create
    $("#submit-data").on("click", function (e) {
        e.preventDefault();
        $(this).text("Processing...");
        $(this).prop('disabled', true);
        var o_data = $("#data_form").serialize();
        var action_url = $('#action-url').val();
        addObject(o_data, action_url);
    });

    function addObject(action, action_url) {


        jQuery.ajax({

            url: '<?php echo base_url() ?>' + action_url,
            type: 'POST',
            data: action + '&<?=$this->security->get_csrf_token_name(); ?>=<?=$this->security->get_csrf_hash(); ?>',
            dataType: 'json',
            success: function (data) {
                if (data.status == "Success") {
                    $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                    $("#notify").removeClass("alert-danger").addClass("alert-success").fadeIn();
                    $("html, body").scrollTop($("body").offset().top);
                    $("#data_form").remove();


                } else {
                    $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                    $("#notify").removeClass("alert-success").addClass("alert-danger").fadeIn();
                    $("html, body").scrollTop($("body").offset().top);
                    $('#submit-data').prop('disabled', false);
                    $('#submit-data').text("Retry");

                }

            },
            error: function (data) {
                $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                $("#notify").removeClass("alert-success").addClass("alert-warning").fadeIn();
                $("html, body").scrollTop($("body").offset().top);

            }
        });


    }
</script>