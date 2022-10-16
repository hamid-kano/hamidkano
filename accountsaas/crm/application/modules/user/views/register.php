<body data-open="click" data-menu="vertical-menu" data-col="1-column"
      class="vertical-layout vertical-menu 1-column bg-login">
<!-- ////////////////////////////////////////////////////////////////////////////-->
<div class="app-content content container-fluid">
    <div class="content-wrapper">
        <div class="content-header row">
        </div>
        <div class="content-body">
            <section class="flexbox-container">
                <div class="col-md-10 offset-md-1 col-xs-10 offset-xs-1  box-shadow-2 p-1">
                    <div class="card border-grey border-lighten-3 m-0">
                        <div class="card-header no-border">
                            <div class="card-title text-xs-center" >
                                <div class="p-1"><img class="col-md-4 offset-md-4" width="100%"  src="<?php echo substr_replace(base_url(), '', -4); ?>userfiles/company/<?php echo $this->config->item('logo'); ?>"
                                                      alt="Logo"></div>
                            </div>

                        </div> <h4 class="card-subtitle line-on-side text-muted text-xs-center  pt-2"><span><?php echo $this->lang->line('Register')  ?> <?php echo $this->lang->line('Customer')  ?> </span>
                            </h4>
                        <small class="text-xs- ml-1">*All Input Fields Are Required</small>
                        <div class="card-body collapse in">
                            <div class="card-block">
                                <?php if ($this->session->flashdata("messagePr")) { ?>
                                    <div class="alert alert-info">
                                        <?php echo $this->session->flashdata("messagePr") ?>
                                    </div>
                                <?php } ?>
        <form action="<?php echo base_url() . 'user/registration'; ?>" method="post">

            <div class="form-group  has-feedback row">
                <div class="col-md-6"><input type="text" name="name" class="form-control" data-validation="required" placeholder="<?php echo $this->lang->line('Name')  ?> ">
                <i class="icon icon-bar form-control-feedback"></i></div>     <div class="col-md-6">  <input type="text" name="city" class="form-control" data-validation="required" placeholder="City">
                <span class="glyphicon glyphicon-user form-control-feedback"></span></div>

            </div>

                           <div class="form-group  has-feedback row">
                                 <div class="col-md-6">
                      <input type="email" name="email" class="form-control" data-validation="required" placeholder="<?php echo $this->lang->line('Email')  ?> ">
                <span class="glyphicon glyphicon-user form-control-feedback"></span>
                    </div>
                                <div class="col-md-6">
              <input type="text" name="region" class="form-control" data-validation="required" placeholder="Region">
                <span class="glyphicon glyphicon-user form-control-feedback"></span>
                    </div>


            </div>

              <div class="form-group  has-feedback row"> <div class="col-md-6">   <input type="password" class="form-control" name="password_confirmation" placeholder="Password"
                       data-validation="required" id="user-pass">
                <span class="glyphicon glyphicon-user form-control-feedback"></span></div>
<div class="col-md-6">  <input type="text" name="country" class="form-control" data-validation="required" placeholder="Country">
                <span class="glyphicon glyphicon-user form-control-feedback"></span></div>


            </div>




                <div class="form-group  has-feedback row"> <div class="col-md-6">
             <input type="password" name="password" class="form-control" placeholder="Retype password"
                       data-validation="confirmation" id="user-pass2">
                <span class="glyphicon glyphicon-user form-control-feedback"></span>
                    </div>
            <div class="col-md-6">
              <input type="text" name="postbox" class="form-control" data-validation="required" placeholder="Postbox">
                <span class="glyphicon glyphicon-user form-control-feedback"></span>
                    </div>

            </div>

            <div class="form-group  has-feedback row">  <div class="col-md-6">
              <input type="text" name="address" class="form-control" data-validation="required" placeholder="Address">
                <span class="glyphicon glyphicon-user form-control-feedback"></span>
                    </div>
 <div class="col-md-6">  <input type="text" name="phone" class="form-control" data-validation="required" placeholder="Phone">
                <span class="glyphicon glyphicon-user form-control-feedback"></span></div>

            </div>
                                   <?php
                                   if($custom_fields) {
                                       echo '<div class="form-group row">';
                                       $r=0;
                                       foreach ($custom_fields as $row) {
                                           if ($row['f_type'] == 'text') { ?>


                                               <div class="col-sm-6">
                                                   <input type="text" placeholder="<?= $row['placeholder'] ?>"
                                                          class="form-control margin-bottom b_input <?= $row['other'] ?>"
                                                          name="custom[<?= $row['id'] ?>]">
                                               </div>


                                           <?php
                                            $r++;
                                            if($r%2==0)  echo '</div><div class="form-group row">';
                                           }
                                       }
                                       echo '</div>';
                                   }
                                ?>
            <div class="form-group  has-feedback row">
                <div class="col-md-6">  <select class="form-control" name="lang" >
                    <option value="arabic">Arabic</option>
                    <?= $langs ?>
                    </select> </div>
                <div class="col-md-6">
                <button type="submit" name="submit" class="btn btn-primary btn-block btn-flat btn-color"><?php echo $this->lang->line('Register')  ?>
                    </button>
                    </div>
            </div>


   <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">
            <div class="row">
                <div class="col-xs-12">
                 <div id="errors" class="well"></div>
                    <input type="hidden" name="call_from" value="reg_page">

                </div>
            </div>

        </form>
        <br>
                                <span class="float-xs-right" ><a href="<?php echo base_url('user/login'); ?>" class="">I already have a membership</a></span>
        </div>
                        </div>

                    </div>
                </div>
            </section>

        </div>
    </div>
</div>

<!-- /.register-box -->
</body>
<script>
    $(document).ready(function () {
        <?php if($this->input->get('invited') && $this->input->get('invited') != ''){ ?>
        $burl = '<?php echo base_url() ?>';
        $.ajax({
            url: $burl + 'user/chekInvitation',
            method: 'post',
            data: {
                code: '<?php echo $this->input->get('invited'); ?>'
            },
            dataType: 'json'
        }).done(function (data) {
            console.log(data);
            if (data.result == 'success') {
                $('[name="email"]').val(data.email);
                $('form').attr('action', $burl + 'user/register_invited/' + data.users_id);
            } else {
                window.location.href = $burl + 'user/login';
            }
        });
        <?php } ?>
    });
</script>
<script>
    $(document).ready(function () {
        $("#user-pass").passwordValidation({"confirmField": "#user-pass2"}, function (element, valid, match, failedCases) {

            $("#errors").html("<div class='alert alert-warning mb-2' role='alert'><strong>Password Rules</strong> MaxChar: 12<br>" + failedCases.join("<br>") + "</div>");

            if (valid) $(element).css("border", "2px solid green");
            if (!valid) {
                $(element).css("border", "2px solid red");
                $('#submit-data').attr('disabled', 'disabled');
            }
            if (valid && match) {
                $("#user-pass2").css("border", "2px solid green");
                $('#errors').html('');
                $('#submit-data').removeAttr('disabled');
            }
            if (!valid || !match) {
                $("#user-pass2").css("border", "2px solid red");
                $('#submit-data').attr('disabled', 'disabled');
            }
        });
    });
</script>