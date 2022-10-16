<div class="content-body">
    <div class="card">
        <div class="card-header">
            <h5><?php echo $this->lang->line('Edit Customer Group') ?></h5>
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
                <form method="post" id="data_form" class="form-horizontal">


                    <input type="hidden" name="gid" value="<?php echo $group['id'] ?>">
                     <input type="hidden" name="ref_id" value="<?php echo $group['hash_code'] ?>">

                    <div class="form-group row">

                        <label class="col-sm-2 col-form-label"
                               for="group_name"><?php echo $this->lang->line('Group Name') ?></label>

                        <div class="col-sm-8">
                            <input type="text" placeholder=" Name"
                                   class="form-control margin-bottom  required" name="group_name"
                                   value="<?php echo $group['title'] ?>">
                        </div>
                    </div>


                    <div class="form-group row">

                        <label class="col-sm-2 col-form-label"><?php echo $this->lang->line('Description') ?></label>

                        <div class="col-sm-8">


                            <input type="text" name="group_desc" class="form-control required"
                                   placeholder="0.00" aria-describedby="sizing-addon1"
                                   value="<?php echo $group['summary'] ?>">

                        </div>

                    </div>


                    <div class="form-group row">

                        <label class="col-sm-2 col-form-label"></label>

                        <div class="col-sm-4">
                            <input type="submit" id="submit-data" class="btn btn-success margin-bottom"
                                   value="<?php echo $this->lang->line('Update') ?>" data-loading-text="Updating...">
                            <input type="hidden" value="clientgroup/editgroupupdate" id="action-url">
                        </div>
                    </div>

            </div>
            </form>
        </div>
    </div>
</div>
