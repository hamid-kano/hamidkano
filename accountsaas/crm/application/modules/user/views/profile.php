<!-- ////////////////////////////////////////////////////////////////////////////-->
<div class="app-content content container-fluid">
    <div class="content-wrapper">
        <div class="content-header row">
        </div>
        <div class="content-body">
            <section class="flexbox-container">
                <!-- Main content -->
                <div class="col-md-12 form f-label">
                    <?php if ($this->session->flashdata("messagePr")) { ?>
                        <div class="alert alert-info">
                            <?php echo $this->session->flashdata("messagePr") ?>
                        </div>
                    <?php } ?>
                    <!-- Profile Image -->
                    <div class="card card-block">
                        <div class="">
                            <h3 class="box-title text-center"><?php echo $this->lang->line('My account') ?><small></small>
                            </h3>
                        </div>
                        <form method="post" enctype="multipart/form-data"
                              action="<?php echo base_url() . 'user/add_edit' ?>" class="form-label-left"><input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">
                            <div class="box-body box-profile">
                                <div class="col-md-4">
                                    <div class="pic_size" id="image-holder">

                                        <img class="height-200 setpropileam"
                                             src="../../userfiles/customers/<?php $profile_pic = $user_data[0]->picture;
                                             echo isset($profile_pic) ? $profile_pic : 'user.png'; ?>"
                                             alt="User profile picture">
                                    </div>
                                    <br>
                                    <div class="fileUpload btn btn-success wdt-bg">
                                        <span><?php echo $this->lang->line('Change pic') ?></span>
                                        <input id="fileUpload" class="width-100 upload" name="profile_pic" type="file"
                                               accept="image/*"/><br/>
                                        <input type="hidden" name="fileOld"
                                               value="<?php echo isset($user_data[0]->profile_pic) ? $user_data[0]->profile_pic : ''; ?>"/>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <h4><?php echo $this->lang->line('Personal info') ?></h4>


                                    <hr>


                                    <div class="form-group has-feedback clear-both">

                                        <h5><?php echo(isset($user_data[0]->name) ? $user_data[0]->name : ''); ?></h5>

                                    </div>


                                    <div class="form-group has-feedback clear-both">

                                        <h5><?php echo(isset($user_data[0]->email) ? $user_data[0]->email : ''); ?></h5>
                                    </div>


                                    <hr>
                                    <h5><?php echo $this->lang->line('Change password') ?></h5>
                                    <div class="form-group has-feedback">
                                        <label for="exampleInputEmail1"><?php echo $this->lang->line('Current password') ?></label>
                                        <input id="pass11" class="form-control" pattern=".{6,}" type="password"
                                               placeholder="********" name="currentpassword" title="6-14 characters">
                                        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                                    </div>
                                    <div class="form-group has-feedback">
                                        <label for="exampleInputEmail1"><?php echo $this->lang->line('New password') ?></label>
                                        <input type="password" class="form-control" placeholder="New Password"
                                               name="password">
                                        <span class="glyphicon glyphicon-pencil form-control-feedback"></span>
                                    </div>
                                    <div class="form-group has-feedback">
                                        <label for="exampleInputEmail1"><?php echo $this->lang->line('Confirm new password') ?></label>
                                        <input type="password" class="form-control" placeholder="Confirm New Password"
                                               name="confirmPassword">
                                        <span class="glyphicon glyphicon-pencil form-control-feedback"></span>
                                    </div>
                                    <br>
                                    <div class="form-group has-feedback sub-btn-wdt">
                                        <input type="hidden" name="users_id"
                                               value="<?php echo isset($user_data[0]->users_id) ? $user_data[0]->users_id : ''; ?>">
                                        <input type="hidden" name="user_type"
                                               value="<?php echo isset($user_data[0]->user_type) ? $user_data[0]->user_type : ''; ?>">
                                        <button name="submit1" type="button" id="profileSubmit"
                                                class="btn btn-success btn-md wdt-bg"><?php echo $this->lang->line('Save') ?>
                                        </button>
                                        <!-- <div class=" pull-right">
                                        </div> -->
                                    </div>
                                </div>
                                <!-- /.box-body -->
                            </div>
                        </form>
                        <!-- /.box -->
                    </div>
                    <!-- /.content -->
                </div>
        </div>
        <!-- /.content-wrapper -->

    </div>
</div>
</div>