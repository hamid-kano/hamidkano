<div class="content-body">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title"><?php echo $this->lang->line('Customer Details') ?>
                : <?php echo $details['name'] ?></h4>
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


                <div class="row">
                    <div class="col-md-4 border-right border-right-grey">


                        <div class="ibox-content mt-2">
                            <img alt="image" id="dpic" class="card-img-top img-fluid"
                                 src="<?php echo base_url('userfiles/customers/') . $details['picture'] ?>">
                        </div>
                        <hr>
                        <h6><?php echo $this->lang->line('Client Group') ?>
                            <small><?php 
                        if(isset($customergroup['title']) and !empty($customergroup['title'])){
                             echo $customergroup['title']; 
                        }else{
                             echo "";
                        }
                           

                            ?></small>
                        </h6>
                        <div class="row mt-3">
                            <div class="col-md-12">

                                <a href="<?php echo base_url('customers/view?id=' . $details['id'].'&ref='. $details['hash_code']) ?>"
                                   class="btn btn-blue btn-md mr-1 mb-1 btn-block btn-lighten-1"><i
                                            class="fa fa-user"></i> <?php echo $this->lang->line('View') ?></a>

                                <a href="<?php echo base_url('customers/invoices?id=' . $details['id'].'&ref='. $details['hash_code']) ?>"
                                   class="btn btn-success btn-md mr-1 mb-1 btn-block btn-lighten-1"><i
                                            class="fa fa-file-text"></i> <?php echo $this->lang->line('View Invoices') ?>
                                </a>

                                <a href="<?php echo base_url('customers/transactions?id=' . $details['id'].'&ref='. $details['hash_code']) ?>"
                                   class="btn btn-blue-grey btn-md mr-1 mb-1 btn-block  btn-lighten-1"><i
                                            class="fa fa-money"></i> <?php echo $this->lang->line('View Transactions') ?>
                                </a>

                                <a href="<?php echo base_url('customers/statement?id=' . $details['id'].'&ref='. $details['hash_code']) ?>"
                                   class="btn btn-primary btn-block btn-md mr-1 mb-1 btn-lighten-1"><i
                                            class="fa fa-briefcase"></i> <?php echo $this->lang->line('Account Statements') ?>
                                </a>

                                <a href="<?php echo base_url('customers/quotes?id=' . $details['id'].'&ref='. $details['hash_code']) ?>"
                                   class="btn btn-purple btn-md mr-1 mb-1 btn-block btn-lighten-1"><i
                                            class="fa fa-quote-left"></i> <?php echo $this->lang->line('Quotes') ?>
                                </a>

                                 <a href="<?php echo base_url('customers/projects?id=' . $details['id'].'&ref='. $details['hash_code']) ?>"
                                        class="btn btn-vimeo btn-md mr-1 mb-1 btn-block btn-lighten-2"><i
                                            class="fa fa-bullhorn"></i> <?php echo $this->lang->line('Projects') ?>
                                </a>

                                <a href="<?php echo base_url('customers/invoices?id=' . $details['id'].'&ref='. $details['hash_code']) ?>&t=sub"
                                   class="btn btn-flickr btn-md mr-1 mb-1 btn-block btn-lighten-1"><i
                                            class="fa fa-calendar-check-o"></i> <?php echo $this->lang->line('Subscriptions') ?>
                                </a>
                                
                                <a href="<?php echo base_url('customers/notes?id=' . $details['id'].'&ref='. $details['hash_code']) ?>"
                                   class="btn btn-github btn-block btn-md mr-1 mb-1 btn-lighten-1"><i
                                            class="fa fa-book"></i> <?php echo $this->lang->line('Notes') ?>
                                </a>


                                <a href="<?php echo base_url('customers/documents?id=' . $details['id'].'&ref='. $details['hash_code']) ?>"
                                   class="btn btn-facebook btn-md mr-1 mb-1 btn-block btn-lighten-1"><i
                                            class="icon-folder"></i> <?php echo $this->lang->line('Documents') ?>
                                </a>
                                
                                <a href="<?php echo base_url('status?id=' . $details['id'].'&ref='. $details['hash_code']) ?>"
                                   class="btn btn-facebook btn-md mr-1 mb-1 btn-block btn-lighten-1"><i
                                            class="icon-folder"></i> <?php echo $this->lang->line('Customer Status') ?>
                                </a>

                            </div>
                        </div>


                    </div>
                    <div class="col-md-8">
                        <div id="mybutton">

                            <div class="">
                                <a href="<?php echo base_url('customers/balance?id=' . $details['id'].'&ref='. $details['hash_code']) ?>"
                                   class="btn btn-success btn-md"><i
                                            class="fa fa-briefcase"></i> <?php echo $this->lang->line('Wallet') ?>
                                </a>

                                 <a href="<?php echo base_url('customers/bulkpayment?id=' . $details['id'].'&ref='. $details['hash_code']) ?>"
                                   class="btn btn-grey-blue btn-md"><i
                                            class="fa fa-money"></i> <?php echo $this->lang->line('Bulk Payment') ?>
                                </a>

                                <a href="#sendMail" data-toggle="modal" data-remote="false"
                                   class="btn btn-primary btn-md " data-type="reminder"><i
                                            class="fa fa-envelope"></i> <?php echo $this->lang->line('Send Message') ?>
                                </a>


                                <a href="<?php echo base_url('customers/edit?id=' . $details['id'].'&ref='. $details['hash_code']) ?>"
                                   class="btn btn-info btn-md"><i
                                            class="fa fa-pencil"></i> <?php echo $this->lang->line('Edit Profile') ?>
                                </a>


                                <a href="<?php echo base_url('customers/changepassword?id=' . $details['id'].'&ref='. $details['hash_code']) ?>"
                                   class="btn btn-danger btn-md"><i
                                            class="fa fa-key"></i> <?php echo $this->lang->line('Change Password') ?>
                                </a>
                            </div>

                        </div>
                        <div class="">
                            <h4></h4>


                            <hr>
                            <?php if ($details['company']) { ?>
                                <div class="row m-t-lg">
                                    <div class="col-md-2">
                                        <strong><?php echo $this->lang->line('Company') ?></strong>
                                    </div>
                                    <div class="col-md-10">
                                        <?php echo $details['company'] ?>
                                    </div>

                                </div>
                                <hr>
                            <?php } ?>

                            <div class="row m-t-lg">
                                <div class="col-md-2">
                                    <strong>Email</strong>
                                </div>
                                <div class="col-md-10">
                                    <?php echo $details['email'] ?>
                                </div>

                            </div>
                            <hr>
                            <div class="row m-t-lg">
                                <div class="col-md-2">
                                    <strong><?php echo $this->lang->line('Phone') ?></strong>
                                </div>
                                <div class="col-md-10">
                                    <?php echo $details['phone'] ?>
                                </div>

                            </div>
                            <hr>
                            <div id="accordionWrapa1" role="tablist" aria-multiselectable="true">


                                <div id="heading2" class="card-header">
                                    <a data-toggle="collapse" data-parent="#accordionWrapa1" href="#accordion2"
                                       aria-expanded="false" aria-controls="accordion2"
                                       class="card-title lead collapsed">
                                        <i class="fa fa-plus-circle"></i> <?php echo $this->lang->line('Address') ?> <?php echo $this->lang->line('Details') ?>
                                    </a>
                                </div>
                                <div id="accordion2" role="tabpanel" aria-labelledby="heading2"
                                     class="card-collapse collapse" aria-expanded="false">
                                    <div class="card-body">
                                        <div class="card-block">
                                            <div class="row m-t-lg">
                                                <div class="col-md-2">
                                                    <strong><?php echo $this->lang->line('Address') ?></strong>
                                                </div>
                                                <div class="col-md-10">
                                                    <?php echo $details['address'] ?>
                                                </div>

                                            </div>
                                            <hr>
                                            <div class="row m-t-lg">
                                                <div class="col-md-2">
                                                    <strong><?php echo $this->lang->line('City') ?></strong>
                                                </div>
                                                <div class="col-md-10">
                                                    <?php echo $details['city'] ?>
                                                </div>

                                            </div>
                                            <hr>
                                            <div class="row m-t-lg">
                                                <div class="col-md-2">
                                                    <strong><?php echo $this->lang->line('Region') ?></strong>
                                                </div>
                                                <div class="col-md-10">
                                                    <?php echo $details['region'] ?>
                                                </div>

                                            </div>
                                            <hr>
                                            <div class="row m-t-lg">
                                                <div class="col-md-2">
                                                    <strong><?php echo $this->lang->line('Country') ?></strong>
                                                </div>
                                                <div class="col-md-10">
                                                    <?php echo $details['country'] ?>
                                                </div>

                                            </div>
                                            <hr>
                                            <div class="row m-t-lg">
                                                <div class="col-md-2">
                                                    <strong><?php echo $this->lang->line('PostBox') ?></strong>
                                                </div>
                                                <div class="col-md-10">
                                                    <?php echo $details['postbox'] ?>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="heading3" class="card-header">
                                    <a data-toggle="collapse" data-parent="#accordionWrapa1" href="#accordion3"
                                       aria-expanded="false" aria-controls="accordion3"
                                       class="card-title lead collapsed">
                                        <i class="fa  fa-plus-circle"></i> <?php echo $this->lang->line('Shipping Address') ?>
                                    </a>
                                </div>
                                <div id="accordion3" role="tabpanel" aria-labelledby="heading3"
                                     class="card-collapse collapse" aria-expanded="false">
                                    <div class="card-body">
                                        <div class="card-block">
                                            <div class="row m-t-lg">
                                                <div class="col-md-2">
                                                    <strong><?php echo $this->lang->line('Address') ?></strong>
                                                </div>
                                                <div class="col-md-10">
                                                    <?php echo $details['address_s'] ?>
                                                </div>

                                            </div>
                                            <hr>
                                            <div class="row m-t-lg">
                                                <div class="col-md-2">
                                                    <strong><?php echo $this->lang->line('City') ?></strong>
                                                </div>
                                                <div class="col-md-10">
                                                    <?php echo $details['city_s'] ?>
                                                </div>

                                            </div>
                                            <hr>
                                            <div class="row m-t-lg">
                                                <div class="col-md-2">
                                                    <strong><?php echo $this->lang->line('Region') ?></strong>
                                                </div>
                                                <div class="col-md-10">
                                                    <?php echo $details['region_s'] ?>
                                                </div>

                                            </div>
                                            <hr>
                                            <div class="row m-t-lg">
                                                <div class="col-md-2">
                                                    <strong><?php echo $this->lang->line('Country') ?></strong>
                                                </div>
                                                <div class="col-md-10">
                                                    <?php echo $details['country_s'] ?>
                                                </div>

                                            </div>
                                            <hr>
                                            <div class="row m-t-lg">
                                                <div class="col-md-2">
                                                    <strong><?php echo $this->lang->line('PostBox') ?></strong>
                                                </div>
                                                <div class="col-md-10">
                                                    <?php echo $details['postbox_s'] ?>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="heading9" class="card-header">
                                    <a data-toggle="collapse" data-parent="#accordionWrapa1" href="#accordion9"
                                       aria-expanded="false" aria-controls="accordion9"
                                       class="card-title lead collapsed">
                                        <i class="fa  fa-plus-circle"></i> <?php echo $this->lang->line('Extra') ?></a>
                                </div>
                                <div id="accordion9" role="tabpanel" aria-labelledby="heading3"
                                     class="card-collapse collapse" aria-expanded="false">
                                    <div class="card-body">
                                        <div class="card-block">
                                            <div class="row m-t-lg">
                                                <div class="col-md-4">
                                                    <strong><?php echo $this->lang->line('Register') ?><?php echo $this->lang->line('Date') ?></strong>
                                                </div>
                                                <div class="col-md-6">
                                                    <?php if ($details['reg_date']) echo dateformat($details['reg_date']) ?>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="row m-t-lg">
                                                <div class="col-md-4">
                                                    <strong><?php echo $this->lang->line('Document') ?> ID</strong>
                                                </div>
                                                <div class="col-md-6">
                                                    <?php echo $details['docid'] ?>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="row m-t-lg">
                                                <div class="col-md-4">
                                                    <strong><?php echo $this->lang->line('Other') ?></strong>
                                                </div>
                                                <div class="col-md-6">
                                                    <?php echo $details['custom1'] ?>
                                                </div>
                                            </div>
                                            <?php foreach ($custom_fields as $row) {
                                                ?>
                                                <hr>
                                                <div class="row m-t-lg">
                                                    <div class="col-md-2">
                                                        <strong><?php echo $row['name'] ?></strong>
                                                    </div>
                                                    <div class="col-md-10">
                                                        <?php echo $row['data'] ?>
                                                    </div>

                                                </div>


                                                <?php


                                            }
                                            ?>


                                        </div>
                                    </div>
                                </div>

                                <h5 class="bg-blue bg-lighten-4  p-1 mt-2"><?php echo $this->lang->line('Wallet') . ' ' . $this->lang->line('Balance') . ': ' . amountExchange($details['balance'], 0, $this->aauth->get_user()->loc) ?></h5>

                                <hr>
                                <h5><?php echo $this->lang->line('Summary') ?></h5>
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item">
                                        <span class="badge tag-default tag-pill bg-success float-xs-right"><?php echo amountExchange($money['credit'], 0, $this->aauth->get_user()->loc) ?></span>
                                        <?php echo $this->lang->line('Income') ?>
                                    </li>
                                    <li class="list-group-item">
                                        <span class="badge tag-default tag-pill bg-danger float-xs-right"><?php echo amountExchange($money['debit'], 0, $this->aauth->get_user()->loc) ?></span>
                                        <?php echo $this->lang->line('Expenses') ?>
                                    </li>

                                    <li class="list-group-item">
                                        <span class="badge tag-default tag-pill bg-pink float-xs-right"><?php echo amountExchange($due['total'] - $due['pamnt']) ?></span>
                                        <?php echo $this->lang->line('Total Due') ?>
                                    </li>
                                    <li class="list-group-item">
                                        <span class="badge tag-default tag-pill bg-blue float-xs-right"><?php echo amountExchange($due['discount'], 0, $this->aauth->get_user()->loc) ?></span>
                                        <?php echo $this->lang->line('Total Discount') ?>
                                    </li>


                                </ul>
                                <div id="heading6" class="card-header bg-grey bg-lighten-4 p-1 mt-2">
                                    <a data-toggle="collapse" data-parent="#accordionWrapa6" href="#accordion6"
                                       aria-expanded="false" aria-controls="accordion6"
                                       class="card-title lead collapsed">
                                        <i class="icon-circle-plus"></i> Wallet
                                        Recharge/<?php echo $this->lang->line('Payment History') ?></a>
                                </div>
                                <div id="accordion6" role="tabpanel" aria-labelledby="heading6"
                                     class="card-collapse collapse" aria-expanded="false">
                                    <div class="card-body">
                                        <div class="card-block">
                                            <table class="table table-striped">
                                                <thead>
                                                <tr>
                                                    <th><?php echo $this->lang->line('Amount') ?></th>
                                                    <th><?php echo $this->lang->line('Note') ?></th>


                                                </tr>
                                                </thead>
                                                <tbody id="activity">
                                                <?php foreach ($activity as $row) {

                                                    echo '<tr>
                            <td>' . amountExchange($row['col1'], 0, $this->aauth->get_user()->loc) . '</td><td>' . $row['col2'] . '</td>
                           
                        </tr>';
                                                } ?>

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>


                            </div>


                            <div id="progress" class="progress1">
                                <div class="progress-bar progress-bar-success"></div>
                            </div>

                            <div class="col-md-12"><br>
                                <h5><?php echo $this->lang->line('Change Customer Picture') ?></h5><input
                                        id="fileupload"
                                        type="file"
                                        name="files[]"></div>


                        </div>
                    </div>
                </div>


            </div>
        </div>

    </div>
</div>
<div id="sendMail" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">

                <h4 class="modal-title">Email</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>

            <div class="modal-body">
                <form id="sendmail_form"><input type="hidden"
                                                name="<?php echo $this->security->get_csrf_token_name(); ?>"
                                                value="<?php echo $this->security->get_csrf_hash(); ?>">
                    <div class="row">
                        <div class="col">
                            <div class="input-group">
                                <div class="input-group-addon"><span class="icon-envelope-o"
                                                                     aria-hidden="true"></span></div>
                                <input type="text" class="form-control" placeholder="Email" name="mailtoc"
                                       value="<?php echo $details['email'] ?>">
                            </div>

                        </div>

                    </div>


                    <div class="row">
                        <div class="col mb-1"><label
                                    for="shortnote"><?php echo $this->lang->line('Customer Name') ?></label>
                            <input type="text" class="form-control"
                                   name="customername" value="<?php echo $details['name'] ?>"></div>
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
                            <textarea name="text" class="summernote" id="contents" title="Contents"></textarea></div>
                    </div>

                    <input type="hidden" class="form-control"
                           id="cid" name="tid" value="<?php echo $details['id'] ?>">
                    <input type="hidden" id="action-url" value="communication/send_general">


                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default"
                        data-dismiss="modal"><?php echo $this->lang->line('Close') ?></button>
                <button type="button" class="btn btn-primary"
                        id="sendNow"><?php echo $this->lang->line('Send') ?></button>
            </div>
        </div>
    </div>
</div>

<script src="<?php echo assets_url('assets/myjs/jquery.ui.widget.js') ?>"></script>
<!-- The basic File Upload plugin -->
<script src="<?php echo assets_url('assets/myjs/jquery.fileupload.js') ?>"></script>
<script>
    /*jslint unparam: true */
    /*global window, $ */
    $(function () {
        'use strict';
        // Change this to the location of your server-side upload handler:
        var url = '<?php echo base_url() ?>customers/displaypic?id=<?php echo $details['id'] ?>&<?=$this->security->get_csrf_token_name()?>=' + crsf_hash;
        $('#fileupload').fileupload({
            url: url,
            dataType: 'json',
            formData: {'<?=$this->security->get_csrf_token_name()?>': crsf_hash},
            done: function (e, data) {
                //$('<p/>').text(file.name).appendTo('#files');
                $("#dpic").attr('src', '<?php echo base_url() ?>userfiles/customers/' + data.result + '?8978');
            },
            progressall: function (e, data) {
                var progress = parseInt(data.loaded / data.total * 100, 10);
                $('#progress .progress-bar').css(
                    'width',
                    progress + '%'
                );
            }
        }).prop('disabled', !$.support.fileInput)
            .parent().addClass($.support.fileInput ? undefined : 'disabled');
    });
</script>
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
    });
</script>