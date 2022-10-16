<article class="content">
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


            <?php echo form_open_multipart('customers/adddocument'); ?>
            <input type="hidden" value="<?= $id ?>" name="id">
            <input type="hidden" value="<?= $ref ?>" name="ref">
            <h5><?php echo $this->lang->line('Upload New Document') ?> </h5>
            <hr>

            <div class="form-group row">

                <label class="col-sm-4 col-form-label" for="name"><?php echo $this->lang->line('Title') ?></label>

                <div class="col-sm-6">
                    <input type="text" placeholder="Document Title"
                           class="form-control margin-bottom  required" name="title">
                </div>
            </div>

            <div class="form-group row">

                <label class="col-sm-4 col-form-label" for="name"><?php echo $this->lang->line('Document') ?>
                    (docx,docs,txt,pdf,xls)</label>

                <div class="col-sm-6">
                    <input type="file" name="userfile" size="20"/>
                </div>
            </div>


            <div class="form-group row">

                <label class="col-sm-4 col-form-label"></label>

                <div class="col-sm-4">
                    <input type="submit" id="document_add" class="btn btn-success margin-bottom"
                           value="<?php echo $this->lang->line('Upload Document') ?>" data-loading-text="Adding...">
                </div>
            </div>


            </form>
        </div>
    </div>
</article>

