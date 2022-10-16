<div class="content-body">
    <div class="card">
        <div class="card-header">
            <h4><?php echo $this->lang->line('Add New Status')." | ".$customer['name'] ?><br><a
                        href="<?php echo base_url('status?id='.$customer['id']) ?>"
                        class="btn btn-primary rounded">
                    <?php echo $this->lang->line('List') ?>
                </a></h4>
            <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
            <div class="heading-elements">
                <ul class="list-inline mb-0">
                    <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                    <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                    <li><a data-action="close"><i class="ft-x"></i></a></li>
                </ul>
            </div>
        </div>
        <hr>
        <div class="card-content">
            <div id="notify" class="alert alert-success" style="display:none;">
                <a href="#" class="close" data-dismiss="alert">&times;</a>

                <div class="message"></div>
            </div>
            <div class="card-body">
                <form method="post" id="data_form">
                    <input type="hidden" value="<?php echo $customer['id'] ?>" name="customer_id">
                        <div class="form-group row  bg-lighten-4 pb-1">
                            <div class="col-sm-8">
                                <label class="col-form-label"><?php echo $this->lang->line('Content') ?></label>
                                <textarea class="form-control" name="content"><?php echo $this->lang->line('Content') ?></textarea>
                            </div>
                        </div>

                    <div class="form-group row">


                        <div class="col-sm-4">
                            <input type="submit" id="submit-data" class="btn btn-success btn-lg margin-bottom"
                                   value="<?php echo $this->lang->line('Add New Status') ?>"
                                   data-loading-text="Adding...">
                            <input type="hidden" value="status/store" id="action-url">
                        </div>
                    </div>


                </form>
            </div>
        </div>
        <script type="text/javascript">
            $("#trans-box").keyup(function () {
                $.ajax({
                    type: "GET",
                    url: baseurl + 'search_products/party_search',
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
        </script>
