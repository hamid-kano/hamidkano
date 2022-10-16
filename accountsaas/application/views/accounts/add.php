<div class="card card-block">
    <div id="notify" class="alert alert-success" style="display:none;">
        <a href="#" class="close" data-dismiss="alert">&times;</a>

        <div class="message"></div>
    </div>
    <div class="card card-block">
        <?php
        $attributes = array('class' => 'card-body', 'id' => 'data_form');
        echo form_open('', $attributes);
        ?>


        <h5><?php echo $this->lang->line('Add New Account') ?></h5>
        <hr>

        <div class="form-group row">

            <label class="col-sm-2 col-form-label" for="holder"><?php echo $this->lang->line('Name') ?></label>

            <div class="col-sm-6">
                <input type="text" placeholder="<?php echo $this->lang->line('Name') ?>"
                       class="form-control margin-bottom required" name="holder">
            </div>
        </div>

        <div class="form-group row">

            <label class="col-sm-2 col-form-label"
                   for="intbal"><?php echo $this->lang->line('Intial Balance') ?></label>

            <div class="col-sm-6">
                <input type="text" placeholder="<?php echo $this->lang->line('Intial Balance') ?>" onkeypress="return isNumber(event)"
                       class="form-control margin-bottom required" name="intbal">
            </div>
        </div>
        <div class="form-group row">

            <label class="col-sm-2 col-form-label" for="acode"><?php echo $this->lang->line('Note') ?></label>

            <div class="col-sm-6">
                <input type="text" placeholder="<?php echo $this->lang->line('Note') ?>"
                       class="form-control margin-bottom" name="acode">
            </div>
        </div>
        <div class="form-group row">

            <label class="col-sm-2 col-form-label"
                   for="lid"><?php echo $this->lang->line('Business Locations') ?></label>

            <div class="col-sm-6">
                <select name="lid" class="form-control">
                    <?php
                    if (!$this->aauth->get_user()->loc) echo "<option value='0'>" . $this->lang->line('All') . "</option>";
                    foreach ($locations as $row) {
                        $cid = $row['id'];
                        $acn = $row['cname'];
                        $holder = $row['address'];
                        echo "<option value='$cid'>$acn - $holder</option>";
                    }
                    ?>
                </select>


            </div>
        </div>

        <div class="form-group row ">

            <label class="col-sm-2 col-form-label"
                   for="parent_id"><?php echo $this->lang->line('Account Type') ?></label>

            <div class="col-sm-6">
                <select name="parent_id" class="form-control">
                    <option value=""><?php echo $this->lang->line('Main Account') ?></option>
                    <?php
                        foreach ($accounts as $account) {
                                echo "<option value='".$account['id']."'>".$this->lang->line('Related To').'  '.$account['holder']."</option>";
                    }
                    ?>
                </select>
            </div>
        </div>

        <div class="form-group row ">

            <label class="col-sm-2 col-form-label"
                   for="analytical"><?php echo $this->lang->line('Analytical') ?></label>

            <div class="col-sm-6">
                <label for="analytical"><input type="radio" name="analytical" id="analytical" value="1"><?php echo $this->lang->line('true') ?></label>
                <label for="notanalytical"><input type="radio" name="analytical" id="notanalytical" value="0" checked=""><?php echo $this->lang->line('false') ?></label>
            </div>
        </div>
        
        <div class="form-group row ">

            <label class="col-sm-2 col-form-label"
                   for="type"><?php echo $this->lang->line('Account Nature') ?></label>

            <div class="col-sm-6">
                <label for="debit"><input type="radio" name="type" id="debit" value="debit">  <?php echo $this->lang->line('Debit') ?></label>
                <label for="credit"><input type="radio" name="type" id="credit" value="credit">   <?php echo $this->lang->line('Credit') ?></label>
            </div>
        </div>


        <div class="form-group row">

            <label class="col-sm-2 col-form-label"></label>

            <div class="col-sm-4">
                <input type="submit" id="submit-data" class="btn btn-success margin-bottom"
                       value="<?php echo $this->lang->line('Add Account') ?>" data-loading-text="Adding...">
                <input type="hidden" value="accounts/addacc" id="action-url">
            </div>
        </div>


        </form>
    </div>
</div>