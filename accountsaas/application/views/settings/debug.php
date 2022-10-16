<div class="card card-block">
    <div id="notify" class="alert alert-success" style="display:none;">
        <a href="#" class="close" data-dismiss="alert">&times;</a>

        <div class="message"></div>
    </div>
    <form method="post" id="product_action" class="form-horizontal">
        <div class="card-body">
            <h5>Application Debug Mode</h5>
            <hr>
            <p class="danger">
                You can enable the debug mode to Development Mode to read your server related issue - like PHP Version
                etc. Please do not enable the Development Mode , if you are not a developer - It will start displaying
                notices and interfere with the general application functionality.
            </p>


            <div class="form-group row">

                <label class="col-sm-2 col-form-label"
                       for="debug">Application Mode </label>
                <div class="col-sm-6"><select name="debug" class="form-control">

                        <?php switch (ENVIRONMENT) {
                            case 'production' :
                                echo '<option value="production">** Production Version ** - Recommended</option>';
                                break;
                            case 'development' :
                                echo '<option value="development">** Development Mode**</option>';
                                break;

                        } ?>
                        <option value="production"> Production Version - Recommended</option>
                        <option value="development">Development Mode</option>


                    </select>

                </div>
            </div>


            <div class="form-group row">

                <label class="col-sm-2 col-form-label"></label>

                <div class="col-sm-4">
                    <input type="submit" id="billing_update" class="btn btn-success margin-bottom"
                           value="<?php echo $this->lang->line('Update') ?>" data-loading-text="Updating...">
                </div>
            </div> <?php
            $php_version_success = false;
            $mysql_success = false;
            $curl_success = false;
            $gd_success = false;
            $allow_url_fopen_success = false;
            $timezone_success = true;
            $mbstring = false;
            $php_version_required = "7.1";
            $current_php_version = PHP_VERSION;

            //check required php version
            if (version_compare($current_php_version, $php_version_required) >= 0) {
                $php_version_success = true;
            }

            //check mySql
            if (function_exists("mysqli_connect")) {
                $mysql_success = true;
            }

            //check curl
            if (function_exists("curl_version")) {
                $curl_success = true;
            }

            //check gd
            if (extension_loaded('gd') && function_exists('gd_info')) {
                $gd_success = true;
            }


            //check allow_url_fopen
            if (ini_get('allow_url_fopen')) {
                $allow_url_fopen_success = true;
            }

            //check allow_url_fopen
            $timezone_settings = ini_get('date.timezone');
            if ($timezone_settings) {
                $timezone_success = true;
            }

            //check gd
            if (extension_loaded('mbstring')) {
                $mbstring = true;
            }

            ?>
            <p class="text-right"><a href="<?= base_url('settings/server') ?>" class="btn btn-blue"><i
                            class="ft-eye"></i>
                    <small>Server PHP Info</small>
                </a> | <a href="<?= base_url('settings/db_error') ?>" class="btn btn-pink"><i
                            class="fa fa-list-alt"></i>
                    <small>MySQL Issues</small>
                </a></p>
            <div class="section">
                <p><strong>Your PHP settings </strong></p>
                <hr/>
                <div>
                    <table class="table">
                        <thead>
                        <tr>
                            <th width="25%">PHP Settings</th>
                            <th width="27%">Current Version</th>
                            <th>Required Version</th>
                            <th class="text-center">Status</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>PHP Version</td>
                            <td><?php echo $current_php_version; ?></td>
                            <td><?php echo $php_version_required; ?>+</td>
                            <td class="text-center">
                                <?php if ($php_version_success) {
                                    $all_requirement_success = true;
                                    ?>
                                    <i class="status fa success fa-check-circle-o"></i>
                                <?php } else {
                                    $all_requirement_success = false;
                                    ?>
                                    <i class="status fa fa-times-circle-o"></i>
                                <?php } ?>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="section">
                <p><strong>Required extensions:</strong></p>
                <hr/>
                <div>
                    <table class="table">
                        <thead>
                        <tr>
                            <th width="25%">Extension</th>
                            <th width="27%">Current Settings</th>
                            <th>Required Settings</th>
                            <th class="text-center">Status</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>MySQLi</td>
                            <td> <?php if ($mysql_success) {
                                    $all_requirement_success = true; ?>
                                    On
                                <?php } else {
                                    $all_requirement_success = false; ?>
                                    Off
                                <?php } ?>
                            </td>
                            <td>On</td>
                            <td class="text-center">
                                <?php if ($mysql_success) {
                                    $all_requirement_success = true; ?>
                                    <i class="status success fa fa-check-circle-o"></i>
                                <?php } else {
                                    $all_requirement_success = false; ?>
                                    <i class="status fa fa-times-circle-o"></i>
                                <?php } ?>
                            </td>
                        </tr>
                        <tr>
                            <td>GD</td>
                            <td> <?php if ($gd_success) {
                                    $all_requirement_success = true; ?>
                                    On
                                <?php } else { ?>
                                    Off
                                <?php } ?>
                            </td>
                            <td>On</td>
                            <td class="text-center">
                                <?php if ($gd_success) {
                                    $all_requirement_success = true; ?>
                                    <i class="status success fa fa-check-circle-o"></i>
                                <?php } else {
                                    $all_requirement_success = false; ?>
                                    <i class="status fa fa-times-circle-o"></i>
                                <?php } ?>
                            </td>
                        </tr>
                        <tr>
                            <td>cURL</td>
                            <td> <?php if ($curl_success) {
                                    $all_requirement_success = true; ?>
                                    On
                                <?php } else {
                                    $all_requirement_success = false; ?>
                                    Off
                                <?php } ?>
                            </td>
                            <td>On</td>
                            <td class="text-center">
                                <?php if ($curl_success) {
                                    $all_requirement_success = true; ?>
                                    <i class="status success fa fa-check-circle-o"></i>
                                <?php } else { ?>
                                    <i class="status fa fa-times-circle-o"></i>
                                <?php } ?>
                            </td>
                        </tr>

                        <tr>
                            <td>mbstring</td>
                            <td> <?php if ($mbstring) { ?>
                                    On
                                <?php } else {
                                    $all_requirement_success = false; ?>
                                    Off
                                <?php } ?>
                            </td>
                            <td>On</td>
                            <td class="text-center">
                                <?php if ($mbstring) {
                                    $all_requirement_success = true; ?>
                                    <i class="status success fa fa-check-circle-o"></i>
                                <?php } else {
                                    $all_requirement_success = false; ?>
                                    <i class="status fa fa-times-circle-o"></i>
                                <?php } ?>
                            </td>
                        </tr>


                        <tr>
                            <td>Server timezone</td>
                            <td> <?php if ($timezone_success) {
                                    echo $timezone_settings;
                                } else {
                                    echo "Null";
                                } ?>
                            </td>
                            <td>-</td>
                            <td class="text-center">
                                <?php if ($timezone_success) { ?>
                                    <i class="status success fa fa-check-circle-o"></i>
                                <?php } else { ?>
                                    <i class="status fa fa-times-circle-o"></i>
                                <?php } ?>
                            </td>
                        </tr>

                        </tbody>
                    </table>
                    <p>
                        <small>You can set different timezone in datetime settings for the application</small>
                    </p>
                </div>
            </div>

        </div>
    </form>

</div>
<script type="text/javascript">
    $("#billing_update").click(function (e) {
        e.preventDefault();
        var actionurl = baseurl + 'settings/debug';
        actionProduct(actionurl);
    });
</script>
