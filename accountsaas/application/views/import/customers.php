<div class="content-body">
    <div class="card">
        <div class="card-header">
            <h5><?php echo $this->lang->line('Import Customers') ?></h5>
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
                        <div id="notify" class="alert alert-success" style="display:none;">
                            <a href="#" class="close" data-dismiss="alert">&times;</a>

                            <div class="message"></div>
                        </div>
                        <?php echo form_open_multipart('import/customers_upload'); ?>
                        <div class="card card-block">

                            <hr>
                            <p>Your customer data file should as per this template <a
                                        href="http://www.ultimatekode.com/samples/customers_import.csv"><strong>Download
                                        Template</strong></a>. Please download a database backup before importing the
                                geopos_products.
                            </p>
                            <p>Column Order in CSV File Must be like this</p>
                            <pre>


     1. (string)John Smith, 2. (string)Phone,  3. (string) Sample Address,

     4. (string) City, 5. (string)Region, 6. (string)Country, 7. (string)Postbox, 8. (string)walkin@example.com,

     9. (integer) 1-groupid , 10. (string)TAXID123,11. (string)ABC Company,

     12. (string)Shipping_Name, 13. (string)phone , 14. (string)ship_kin@example.com, 15. (string)shipping_address,

     16. (string)ship_city, 17. (string)ship_region, 18 (string)ship_country, 19. (string)ship_pobox,

     22. (number) Balance

</pre>

                            <hr>
                            <div class="form-group row">

                                <label class="col-sm-2 col-form-label" for="name">File
                                </label>

                                <div class="col-sm-6">
                                    <input type="file" name="userfile" size="15"/>(csv format only)
                                </div>
                            </div>

                            <div class="form-group row">

                                <label class="col-sm-2 col-form-label" for="name">Password
                                </label>

                                <div class="col-sm-6">
                                    <input type="radio" name="c_password" value="random" class="checkbox"
                                           checked="checked"/> Random
                                    <br>
                                    <input type="radio" name="c_password" class="mt-1" value="fixed"/> As per below
                                    field<br>
                                    <input value="123456" class="form-control mt-1" type="text"
                                           name="c_password_static">

                                </div>
                            </div>


                            <div class="form-group row">

                                <label class="col-sm-2 col-form-label"></label>

                                <div class="col-sm-4">
                                    <input type="submit" class="btn btn-success margin-bottom"
                                           value="<?php echo $this->lang->line('Import Customers') ?>"
                                           data-loading-text="Adding...">

                                </div>
                            </div>
                        </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
