<article class="content">
    <div class="card card-block">
        <div id="notify" class="alert alert-success" style="display:none;">
            <a href="#" class="close" data-dismiss="alert">&times;</a>

            <div class="message"></div>
        </div>
        <form method="post" id="data_form" class="form-horizontal">
            <div class="row">

                <h5><?php echo $this->lang->line('Address') ?></h5>
                <hr>
                <div class="col-md-6">
                    <h5><?php echo $this->lang->line('Billing Address') ?></h5>


  <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">
                    <div class="form-group row">

                        <label class="col-sm-2 col-form-label"
                               for="product_name"><?php echo $this->lang->line('Name') ?></label>

                        <div class="col-sm-10">
                            <input type="text" placeholder="Name"
                                   class="form-control margin-bottom required" name="name"
                                   value="<?php echo $customer['name'] ?>" id="mcustomer_name">
                        </div>
                    </div>
                    <div class="form-group row">

                        <label class="col-sm-2 col-form-label"
                               for="product_name"><?php echo $this->lang->line('Company') ?></label>

                        <div class="col-sm-10">
                            <input type="text" placeholder="Company"
                                   class="form-control margin-bottom" name="company"
                                   value="<?php echo $customer['company'] ?>">
                        </div>
                    </div>

                    <div class="form-group row">

                        <label class="col-sm-2 col-form-label"
                               for="phone"><?php echo $this->lang->line('Phone') ?></label>

                        <div class="col-sm-10">
                            <input type="text" placeholder="phone"
                                   class="form-control margin-bottom  required" name="phone"
                                   value="<?php echo $customer['phone'] ?>" id="mcustomer_phone">
                        </div>
                    </div>
                    <div class="form-group row">

                        <label class="col-sm-2 col-form-label" for="email">Email</label>

                        <div class="col-sm-10">
                            <input type="text" placeholder="email"
                                   class="form-control margin-bottom required" name="email"
                                   value="<?php echo $customer['email'] ?>" id="mcustomer_email" readonly>
                        </div>
                    </div>
                    <div class="form-group row">

                        <label class="col-sm-2 col-form-label"
                               for="product_name"><?php echo $this->lang->line('Address') ?></label>

                        <div class="col-sm-10">
                            <input type="text" placeholder="address"
                                   class="form-control margin-bottom" name="address"
                                   value="<?php echo $customer['address'] ?>" id="mcustomer_address1">
                        </div>
                    </div>
                    <div class="form-group row">

                        <label class="col-sm-2 col-form-label"
                               for="city"><?php echo $this->lang->line('City') ?></label>

                        <div class="col-sm-10">
                            <input type="text" placeholder="city"
                                   class="form-control margin-bottom" name="city"
                                   value="<?php echo $customer['city'] ?>" id="mcustomer_city">
                        </div>
                    </div>
                    <div class="form-group row">

                        <label class="col-sm-2 col-form-label"
                               for="region"><?php echo $this->lang->line('Region') ?></label>

                        <div class="col-sm-10">
                            <input type="text" placeholder="region"
                                   class="form-control margin-bottom" name="region"
                                   value="<?php echo $customer['region'] ?>" id="region">
                        </div>
                    </div>
                    <div class="form-group row">

                        <label class="col-sm-2 col-form-label"
                               for="country"><?php echo $this->lang->line('Country') ?></label>

                        <div class="col-sm-10">
                            <input type="text" placeholder="Country"
                                   class="form-control margin-bottom" name="country"
                                   value="<?php echo $customer['country'] ?>" id="mcustomer_country">
                        </div>
                    </div>
                    <div class="form-group row">

                        <label class="col-sm-2 col-form-label"
                               for="postbox"><?php echo $this->lang->line('PostBox') ?></label>

                        <div class="col-sm-10">
                            <input type="text" placeholder="region"
                                   class="form-control margin-bottom" name="postbox"
                                   value="<?php echo $customer['postbox'] ?>" id="postbox">
                        </div>
                    </div>
                    <div class="form-group row">

                        <label class="col-sm-2 col-form-label"
                               for="postbox"><?php echo $this->lang->line('Tax') ?> ID</label>

                        <div class="col-sm-10">
                            <input type="text" placeholder="TAX ID"
                                   class="form-control margin-bottom" name="taxid"
                                   value="<?php echo $customer['taxid'] ?>">
                        </div>
                    </div>
                                 <div class="form-group row">

                                    <label class="col-sm-2 col-form-label"
                                           for="postbox"><?php echo $this->lang->line('Document') ?> ID</label>

                                    <div class="col-sm-6">
                                        <input type="text" placeholder="Document ID"
                                               class="form-control margin-bottom b_input" name="docid"  value="<?php echo $customer['docid'] ?>">
                                    </div>      </div>


   <div class="form-group row">

                        <label class="col-sm-2 col-form-label"
                               for="customergroup">Language</label>
      <div class="col-sm-6">
                        <select name="language" class="form-control b_input">

<?php echo' <option value="'.$customer['lang'].'">'.$customer['lang'].'</option>' ;
                            echo $this->common->languages();
                            ?>
                        </select>
                    </div>
                    </div>


                </div>

                <div class="col-md-6">
                    <h5><?php echo $this->lang->line('Shipping Address') ?></h5>
                    <div class="form-group row">



                        <div class="col-sm-10">
                            <?php echo $this->lang->line("leave Shipping Address") ?>
                        </div>
                    </div>

                    <div class="form-group row">

                        <label class="col-sm-2 col-form-label"
                               for="product_name"><?php echo $this->lang->line('Name') ?></label>

                        <div class="col-sm-10">
                            <input type="text" placeholder="Name"
                                   class="form-control margin-bottom" name="name_s"
                                   value="<?php echo $customer['name_s'] ?>" id="mcustomer_name_s">
                        </div>
                    </div>


                    <div class="form-group row">

                        <label class="col-sm-2 col-form-label"
                               for="phone"><?php echo $this->lang->line('Phone') ?></label>

                        <div class="col-sm-10">
                            <input type="text" placeholder="phone"
                                   class="form-control margin-bottom" name="phone_s"
                                   value="<?php echo $customer['phone_s'] ?>" id="mcustomer_phone_s">
                        </div>
                    </div>
                    <div class="form-group row">

                        <label class="col-sm-2 col-form-label" for="email">Email</label>

                        <div class="col-sm-10">
                            <input type="text" placeholder="email"
                                   class="form-control margin-bottom" name="email_s"
                                   value="<?php echo $customer['email_s'] ?>" id="mcustomer_email_s">
                        </div>
                    </div>
                    <div class="form-group row">

                        <label class="col-sm-2 col-form-label"
                               for="product_name"><?php echo $this->lang->line('Address') ?></label>

                        <div class="col-sm-10">
                            <input type="text" placeholder="address"
                                   class="form-control margin-bottom" name="address_s"
                                   value="<?php echo $customer['address_s'] ?>" id="mcustomer_address1_s">
                        </div>
                    </div>
                    <div class="form-group row">

                        <label class="col-sm-2 col-form-label"
                               for="city"><?php echo $this->lang->line('City') ?></label>

                        <div class="col-sm-10">
                            <input type="text" placeholder="city"
                                   class="form-control margin-bottom" name="city_s"
                                   value="<?php echo $customer['city_s'] ?>" id="mcustomer_city_s">
                        </div>
                    </div>
                    <div class="form-group row">

                        <label class="col-sm-2 col-form-label"
                               for="region"><?php echo $this->lang->line('Region') ?></label>

                        <div class="col-sm-10">
                            <input type="text" placeholder="region"
                                   class="form-control margin-bottom" name="region_s"
                                   value="<?php echo $customer['region_s'] ?>" id="region_s">
                        </div>
                    </div>
                    <div class="form-group row">

                        <label class="col-sm-2 col-form-label"
                               for="country"><?php echo $this->lang->line('Country') ?></label>

                        <div class="col-sm-10">
                            <input type="text" placeholder="Country"
                                   class="form-control margin-bottom" name="country_s"
                                   value="<?php echo $customer['country_s'] ?>" id="mcustomer_country_s">
                        </div>
                    </div>
                    <div class="form-group row">

                        <label class="col-sm-2 col-form-label"
                               for="postbox"><?php echo $this->lang->line('PostBox') ?></label>

                        <div class="col-sm-10">
                            <input type="text" placeholder="region"
                                   class="form-control margin-bottom" name="postbox_s"
                                   value="<?php echo $customer['postbox_s'] ?>" id="postbox_s">
                        </div>
                    </div>


                </div>

            </div>
            <div class="form-group row">

                <label class="col-sm-2 col-form-label"></label>

                <div class="col-sm-4">
                    <input type="submit" id="submit-data" class="btn btn-success margin-bottom"
                           value="Update" data-loading-text="Updating...">
                    <input type="hidden" value="user/update_address" id="action-url">
                </div>
            </div>
        </form>
    </div>
</article>

