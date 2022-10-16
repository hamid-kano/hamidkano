<div class="content-body">
    <div class="card">
        <div class="card-header">
            <h5 class="title">
                <?php echo $this->lang->line('Notes') ?> <a href="<?php echo base_url('tools/addnote') ?>"
                                                            class="btn btn-primary btn-sm rounded">
                    <?php echo $this->lang->line('Add new') ?>
                </a>
            </h5>
            <hr>
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

                <div class="content-body">
                    <div class="card">
                        <div class="card-header">
                            <h5><?php echo $this->lang->line('Upload New Document') ?></h5>
                            <hr>
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

                                <div class="content">
                                    <div class="card card-block">
                                        <?php if ($response == 1) {
                                            echo '<div id="notify" class="alert alert-success">
            <a href="#" class="close" data-dismiss="alert">&times;</a>

            <div class="message">' . $responsetext . '</div>
        </div>';
                                        } else if ($response == 0) {
                                            echo '<div id="notify" class="alert alert-danger">
            <a href="#" class="close" data-dismiss="alert">&times;</a>

            <div class="message">' . $responsetext . '</div>
        </div>';
                                        } ?>
                                        <div class="grid_3 grid_4">


                                            <?php echo form_open_multipart('tools/adddocument'); ?>


                                            <div class="form-group row">

                                                <label class="col-sm-4 col-form-label"
                                                       for="name"><?php echo $this->lang->line('Title') ?></label>

                                                <div class="col-sm-6">
                                                    <input type="text" placeholder="Document Title"
                                                           class="form-control margin-bottom  required" name="title">
                                                </div>
                                            </div>

                                            <div class="form-group row">

                                                <label class="col-sm-4 col-form-label"
                                                       for="name"><?php echo $this->lang->line('Document') ?>
                                                    (docx,docs,txt,pdf,xls)</label>

                                                <div class="col-sm-6">
                                                    <input type="file" name="userfile" size="20"/>
                                                </div>
                                            </div>


                                            <div class="form-group row">

                                                <label class="col-sm-4 col-form-label"></label>

                                                <div class="col-sm-4">
                                                    <input type="submit" id="document_add"
                                                           class="btn btn-success margin-bottom"
                                                           value="<?php echo $this->lang->line('Upload Document') ?>"
                                                           data-loading-text="Adding...">
                                                </div>
                                            </div>


                                            </form>
                                        </div>
                                    </div>
                                </div>

