<div class="content-body">
    <div class="card">
        <div class="card-header">
            <h5 class="card-title"><?php echo $this->lang->line('Messages') ?> <a
                        href="#sendUserPM" data-toggle="modal"
                        data-remote="false" data-type="reminder"
                        class="btn btn-large btn-success"
                        title="Partial Payment"
                ><span class="icon-mail"></span> <?php echo $this->lang->line('Compose') ?> </a></h5>
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

            <div class="card-body">

                <div class="card card-block">

                    <?php $list_pm = $this->aauth->list_pms(50, 0, $this->aauth->get_user()->id, false);
                    foreach ($list_pm as $row) {

                        echo '<a href="' . base_url('messages/view?id=' . $row->{'pid'}) . '" class="list-group-item">
                <div class="media">
                    <div class="media-left"><span class="avatar avatar-sm"><img src="' . base_url('userfiles/employee/' . $row->picture) . '"></span></div>
                    <div class="media-body">
                        <h6 class="media-heading">' . $row->name . '</h6>
                        <p class="notification-text font-small-3 text-muted">' . $row->{'title'} . '</p><small>
                            <time datetime="2015-06-11T18:29:20+08:00" class="media-meta text-muted">' . $row->date_sent . '</time></small>
                    </div>
                </div></a>';
                    } ?>
                </div>


            </div>
        </div>
    </div>


    <div id="sendUserPM" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">

                    <h4 class="modal-title"><?php echo $this->lang->line('Send Message') ?></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>

                <div class="modal-body" id="emailbody">
                    <form class="sendpm">
                        <div class="row">
                            <div class="col mb-1"><label
                                        for="username"><?php echo $this->lang->line('Employee Username') ?></label>
                                <div class="input-group">
                                    <div class="input-group-addon"><span class="icon-user"
                                                                         aria-hidden="true"></span></div>
                                    <input type="text" class="form-control" placeholder="Username" name="username"
                                           id="username"
                                           value="" autocomplete="off"><input type="hidden" id="userid" name="userid"
                                                                              value="">
                                </div>

                            </div>

                        </div>
                        <div class="row">
                            <div class="col mb-1">
                                <div id="username-result"></div>
                            </div>
                        </div>


                        <div class="row">
                            <div class="col mb-1"><label
                                        for="shortnote"><?php echo $this->lang->line('Subject') ?></label>
                                <input type="text" class="form-control"
                                       name="subject" id="subject">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-1"><label
                                        for="shortnote"><?php echo $this->lang->line('Message') ?></label>
                                <textarea name="text" class="summernote" id="contents" title="Contents"></textarea>
                            </div>
                        </div>

                        <input type="hidden" class="form-control"
                               id="invoiceid" name="tid" value="">
                        <input type="hidden" class="form-control"
                               id="emailtype" value="">


                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default"
                            data-dismiss="modal"><?php echo $this->lang->line('Close') ?></button>
                    <button type="button" class="btn btn-primary"
                            id="send_pm_u"><?php echo $this->lang->line('Send') ?></button>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(function () {
        $('.summernote').summernote({
            height: 100,
            toolbar: [
                // [groupName, [list of button]]
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['font', ['strikethrough', 'superscript', 'subscript']],
                ['fontsize', ['fontsize']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['height', ['height']],
                ['fullscreen', ['fullscreen']],
                ['codeview', ['codeview']]
            ]
        });

        $('form').on('submit', function (e) {
            e.preventDefault();
            alert($('.summernote').summernote('code'));
            alert($('.summernote').val());
        });
    });
    $(document).on('click', "#send_pm_u", function (e) {
        e.preventDefault();


        sendPM();


    });

    function sendPM() {


        $("#sendUserPM").modal('hide');

        jQuery.ajax({

            url: baseurl + 'messages/sendpm',
            type: 'POST',
            data: $('form.sendpm').serialize() + '&' + crsf_token + '=' + crsf_hash,
            dataType: 'json',
            success: function (data) {
                if (data.status == "Success") {
                    $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                    $("#notify").removeClass("alert-danger").addClass("alert-success").fadeIn();
                    $("html, body").scrollTop($("body").offset().top);
                    $('#pstatus').html(data.pstatus);
                    $('#activity').append(data.activity);
                    $('#rmpay').val(data.amt);
                    $('#paymade').text(data.ttlpaid);
                    $('#paydue').text(data.amt);

                } else {
                    $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                    $("#notify").removeClass("alert-success").addClass("alert-danger").fadeIn();
                    $("html, body").scrollTop($("body").offset().top);

                }

            },
            error: function (data) {
                $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                $("#notify").removeClass("alert-success").addClass("alert-danger").fadeIn();
                $("html, body").scrollTop($("body").offset().top);
            }
        });

    }

    $("#username").keyup(function () {
        $.ajax({
            type: "GET",
            url: baseurl + 'search/user',
            data: 'username=' + $(this).val(),
            beforeSend: function () {
                $("#username").css("background", "#FFF url(" + baseurl + "assets/custom/load-ring.gif) no-repeat 165px");
            },
            success: function (data) {
                $("#username-result").show();
                $("#username-result").html(data);
                $("#username").css("background", "none");

            }
        });
    });

    $(document).on('click', ".selectuser", function (e) {
        e.preventDefault();


        $("#username").val($(this).attr('data-username'));
        $("#userid").val($(this).attr('data-userid'));


    });
</script>