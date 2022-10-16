<article class="content">
    <div class="card card-block">
        <div id="notify" class="alert alert-success" style="display:none;">
            <a href="#" class="close" data-dismiss="alert">&times;</a>

            <div class="message"></div>
        </div>
        <form method="post" id="data_form" class="form-horizontal">
            <div class="card card-block">

                <h5>Woocommerce Integration Using REST</h5>
                <hr>
                <p>WooCommerce (WC) 2.6+ is fully integrated with the WordPress REST API. <br><span
                            class="text-primary">You can link your WooCommerce Store to Geo POS. To create or manage keys for a specific WordPress user, go to WooCommerce > Settings >Advanced > REST API.</span>
                </p>

                <div class="form-group row">

                    <label class="col-sm-2 col-form-label" for="terms">Consumer Key</label>

                    <div class="col-sm-8">
                        <input type="text"
                               class="form-control margin-bottom  required" name="key1"
                               value="<?php echo $universal['key1'] ?>">
                    </div>
                </div>

                <div class="form-group row">

                    <label class="col-sm-2 col-form-label" for="terms">Consumer Secret</label>

                    <div class="col-sm-8">
                        <input type="text"
                               class="form-control margin-bottom  required" name="key2"
                               value="<?php echo $universal['key2'] ?>">
                    </div>
                </div>

                <div class="form-group row">

                    <label class="col-sm-2 col-form-label" for="terms">Store Url</label>

                    <div class="col-sm-8">
                        <input type="text"
                               class="form-control margin-bottom  required" name="url"
                               value="<?php echo $universal['url'] ?>">
                    </div>
                </div>

                <div class="form-group row">

                    <label class="col-sm-2 col-form-label" for="terms">Employee for store invoices</label>

                    <div class="col-sm-8">
                        <select name="emp" class="form-control">
                            <option value='<?php echo $universal['method'] ?>'>Do not change</option>
                            <?php
                            foreach ($emp as $row) {
                                $cid = $row['id'];
                                $title = $row['name'];
                                echo "<option value='$cid'>$title</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>


                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"></label>

                    <div class="col-sm-4">
                        <input type="submit" id="submit-data" class="btn btn-success margin-bottom"
                               value="<?php echo $this->lang->line('Update') ?>" data-loading-text="Updating...">
                        <input type="hidden" value="plugins/woocommerce" id="action-url">
                    </div>
                </div>

            </div>
        </form>

        <div class="card card-block">
            <h5>Import Woocommerce Products</h5>
            <hr>


            <p>You can import your woocommerce products to geo pos with one click.</p>
            <a href="#" data-toggle="modal" data-target="#importProducts" class="btn btn-blue-grey btn-lg margin-bottom"
               data-loading-text="Importt..."><?php echo $this->lang->line('Import') ?></a>
            <div class="card card-block" id="products"></div>
        </div>
        <div class="card card-block">
            <h5>Import Woocommerce Orders</h5>
            <hr>


            <p>You can import your woocommerce orders to geo pos with one click.</p>
            <a href="#" data-toggle="modal" data-target="#importOrders" class="btn btn-indigo btn-lg margin-bottom"
               data-loading-text="Importt..."><?php echo $this->lang->line('Import') ?></a>
            <div class="card card-block" id="orders"></div>
        </div>
        <p>Auto import feature can be found in <strong>Settings>CronJob</strong> section.</p>
    </div>


</article>
<div id="importProducts" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Import products</h4>
            </div>
            <div class="modal-body">
                <p>Do you want to import products from WooCommerce Store ?</p>
            </div>
            <div class="modal-footer">


                <button type="button" data-dismiss="modal" class="btn btn-primary"
                        id="wimport_products"><?php echo $this->lang->line('Yes') ?></button>
                <button type="button" data-dismiss="modal"
                        class="btn"><?php echo $this->lang->line('Cancel') ?></button>
            </div>
        </div>
    </div>
</div>
<div id="importOrders" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Import Orders</h4>
            </div>
            <div class="modal-body">
                <p>Do you want to import Orders from WooCommerce Store ?</p>
            </div>
            <div class="modal-footer">


                <button type="button" data-dismiss="modal" class="btn btn-primary"
                        id="wimport_orders"><?php echo $this->lang->line('Yes') ?></button>
                <button type="button" data-dismiss="modal"
                        class="btn"><?php echo $this->lang->line('Cancel') ?></button>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">

    $(document).on('click', "#wimport_products", function (e) {
        e.preventDefault();

        var aurl = '<?=base_url() ?>cronjob/woo_products?token=<?=$cornkey ?>';
        var div_id = 'products';
        var message = 'Product Import Successful!';

        woo_action(aurl, div_id, message);


    });
    $(document).on('click', "#wimport_orders", function (e) {
        e.preventDefault();
        var aurl = '<?=base_url() ?>cronjob/woo_orders?token=<?=$cornkey ?>';
        var div_id = 'orders';
        var message = 'Orders Import Successful!';

        woo_action(aurl, div_id, message);


    });

    function woo_action(aurl, div_id, message) {
        jQuery.ajax({

            url: aurl,
            type: 'GET',
            dataType: 'html',
            success: function (data) {
                $('#' + div_id).html(message);
            }
        });
    }

</script>