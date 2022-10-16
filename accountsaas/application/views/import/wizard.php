<script src="<?php echo assets_url(); ?>assets/myjs/loading-bar.js" type="text/javascript"></script>
<article class="content">
    <div class="card card-block">
        <div id="notify" class="alert alert-success" style="display:none;">
            <a href="#" class="close" data-dismiss="alert">&times;</a>

            <div class="message white"></div>
        </div><?php if ($response == 1) { ?>
            <div id="ups" class="grid_3 grid_4">
                <h6>Import Process Started!</h6>
                <hr>

                <div class="row sameheight-container">
                    <div class="col-md-12">
                        <div class="card card-block sameheight-item">

                        <span id="ldBar" class="ldBar text-xs-center"
                              style="width:100%;height:30px" ,

                        ></span>
                            <script>
                                var bar1 = new ldBar("#ldBar");

                                setInterval(function () {
                                    bar1.set(Math.floor((Math.random() * 70) + 30));
                                }, 2000);
                            </script>
                        </div>
                    </div>

                </div>

            </div>
        <?php } else { ?>
            <div class="grid_3 grid_4">
                <h6>Import Process Failed! Either you have uploaded an incorrect file format or invalid template for
                    uploading!</h6>
                <hr>

                <div class="row sameheight-container">
                    <div class="col-md-12">
                        <div class="card card-block sameheight-item">

                        <span id="ldBar" class="ldBar text-xs-center"
                              style="width:100%;height:30px" ,

                        ></span>

                        </div>
                    </div>

                </div>
                <h6>Import Process Failed! Either you have uploaded an incorrect file format or invalid template for
                    uploading!</h6>

            </div>
        <?php } ?>
    </div>
</article>
<?php if ($response == 1) { ?>
    <script type="text/javascript">
        setTimeout(function () {
            $.ajax({

                url: baseurl + 'import/start_process',
                dataType: 'json',
                type: 'POST',
                data: {
                    'name': '<?= $filename ?>',
                    'pc': '<?= $pc ?>',
                    'wid': '<?= $wid ?>',
                    '<?=$this->security->get_csrf_token_name(); ?>': '<?=$this->security->get_csrf_hash(); ?>'
                },
                success: function (data) {
                    $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                    $("#notify").addClass("alert-info white").fadeIn();
                    $("html, body").scrollTop($("body").offset().top);
                    $("#ups").hide();
                    if (data.status == 'Success') {
                        setTimeout(function () {
                            window.location.href = baseurl + 'import/products';
                        }, 2000);
                    }

                },
                error: function () {

                }

            });
        }, 2000);

    </script>
<?php } ?>