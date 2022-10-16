<div class="card card-block">
    <?php if ($message) {

        echo '<div id = "notify" class="alert alert-success"  >
            <a href = "#" class="close" data - dismiss = "alert" >&times;</a >

            <div class="message" >Token updated successfully!</div >
        </div >';
    } ?>
    <div class="card-body">
        <div class="card-block"><h4>Automated Tasks & Cron Job Management </h4>

            <hr>
            <p>The software utility Cron is a time-based job scheduler. People who set up and maintain automated
                application task use cron to schedule jobs to run periodically at fixed times, dates, or intervals.
                Recommended cron job scheduling is in midnight.</p><br><a
                    href="<?php echo base_url('cronjob/generate'); ?>" class="btn btn-primary btn-md rounded"> <i
                        class="icon icon-refresh2"></i>
                Update Cron Token
            </a>
            <p></p>
            <h4 class="text-gray-dark"><?php echo $corn['cornkey']; ?></h4>

            <hr>
            <a
                    data-toggle="collapse" href="#accordion3c"
                    aria-expanded="false" aria-controls="accordion3c"
                    class="btn btn-default card-title font-size-large  collapsed blue"><i
                        class="fa fa-plus-circle"></i>
                Subscription Invoices Auto Management URL</a>

            <div id="accordion3c" role="tabpanel"
                 class="card-collapse collapse">


                <pre class="card-block card">WGET <?php echo base_url('cronjob/subscription?token=' . $corn['cornkey']) ?></pre>
                <pre class="card-block card">GET <?php echo base_url('cronjob/subscription?token=' . $corn['cornkey']) ?></pre>


            </div>
            <hr>

            <a
                    data-toggle="collapse" href="#a1"
                    aria-expanded="false" aria-controls="accordion3c"
                    class="btn btn-default card-title font-size-large  collapsed success"><i
                        class="fa fa-plus-circle"></i>
                Due Invoices Automatic Email URL</a>

            <div id="a1" role="tabpanel"
                 class="card-collapse collapse">
                <pre class="card-block card">GET <?php echo base_url('cronjob/due_invoices_email?token=' . $corn['cornkey']) ?></pre>
                <pre class="card-block card">WGET <?php echo base_url('cronjob/due_invoices_email?token=' . $corn['cornkey']) ?></pre>


            </div>
            <hr>

            <a
                    data-toggle="collapse" href="#a2"
                    aria-expanded="false" aria-controls="accordion3c"
                    class="btn btn-default card-title font-size-large  collapsed blue"><i
                        class="fa fa-plus-circle"></i>
                Automatic Report data update</a>

            <div id="a2" role="tabpanel"
                 class="card-collapse collapse">
                <p>
                    <small>This action will update the monthly sales,sold items, total income and expenses of past
                        12
                        months.
                    </small>
                </p>
                <pre class="card-block card">GET <?php echo base_url('cronjob/reports?token=' . $corn['cornkey']) ?></pre>
                <pre class="card-block card">WGET <?php echo base_url('cronjob/reports?token=' . $corn['cornkey']) ?></pre>


            </div>


            <hr>


            <a
                    data-toggle="collapse" href="#a3"
                    aria-expanded="false" aria-controls="accordion3c"
                    class="btn btn-default card-title font-size-large  collapsed success"><i
                        class="fa fa-plus-circle"></i>
                Automatic Currency Exchange Rates update</a>

            <div id="a3" role="tabpanel"
                 class="card-collapse collapse">
                <p>
                    <small>This action will update the payment Currency Exchange Rates.
                    </small>
                </p>
                <pre class="card-block card">GET <?php echo base_url('cronjob/update_exchange_rate?token=' . $corn['cornkey']) ?></pre>
                <pre class="card-block card">WGET <?php echo base_url('cronjob/update_exchange_rate?token=' . $corn['cornkey']) ?></pre>


            </div>
            <hr>

            <a
                    data-toggle="collapse" href="#a4"
                    aria-expanded="false" aria-controls="accordion3c"
                    class="btn btn-default card-title font-size-large  collapsed blue"><i
                        class="fa fa-plus-circle"></i>
                Clean Drafts URL</a>

            <div id="a4" role="tabpanel"
                 class="card-collapse collapse">

                <pre class="card-block card">WGET <?php echo base_url('cronjob/cleandrafts?token=' . $corn['cornkey']) ?></pre>
                <pre class="card-block card">GET <?php echo base_url('cronjob/cleandrafts?token=' . $corn['cornkey']) ?></pre>

            </div>
            <hr>


            <a
                    data-toggle="collapse" href="#a5"
                    aria-expanded="false" aria-controls="accordion3c"
                    class="btn btn-default card-title font-size-large  collapsed success"><i
                        class="fa fa-plus-circle"></i>
                Promo/Coupon Expired</a>

            <div id="a5" role="tabpanel"
                 class="card-collapse collapse">
                <p>
                <pre class="card-block card">WGET <?php echo base_url('cronjob/promo?token=' . $corn['cornkey']) ?></pre>
                <pre class="card-block card">GET <?php echo base_url('cronjob/promo?token=' . $corn['cornkey']) ?></pre>

            </div>
            <hr>
            <a
                    data-toggle="collapse" href="#a6"
                    aria-expanded="false" aria-controls="accordion3c"
                    class="btn btn-default card-title font-size-large  collapsed blue"><i
                        class="fa fa-plus-circle"></i>
                Low Stock Products Alert</a>

            <div id="a6" role="tabpanel"
                 class="card-collapse collapse">
                <p>
                <pre class="card-block card">WGET <?php echo base_url('cronjob/stock_alert?token=' . $corn['cornkey']) ?></pre>
                <pre class="card-block card">GET <?php echo base_url('cronjob/stock_alert?token=' . $corn['cornkey']) ?></pre>

            </div>
            <hr>
            <a
                    data-toggle="collapse" href="#a7"
                    aria-expanded="false" aria-controls="accordion3c"
                    class="btn btn-default card-title font-size-large  collapsed success"><i
                        class="fa fa-plus-circle"></i>
                Expiring Products Alert</a>

            <div id="a7" role="tabpanel"
                 class="card-collapse collapse">
                <p>
                <pre class="card-block card">WGET <?php echo base_url('cronjob/expiry_alert?token=' . $corn['cornkey']) ?></pre>
                <pre class="card-block card">GET <?php echo base_url('cronjob/expiry_alert?token=' . $corn['cornkey']) ?></pre>
            </div>
            <hr>

            <a
                    data-toggle="collapse" href="#a8"
                    aria-expanded="false" aria-controls="accordion3c"
                    class="btn btn-default card-title font-size-large  collapsed blue"><i
                        class="fa fa-plus-circle"></i>
                Database BackUp</a>

            <div id="a8" role="tabpanel"
                 class="card-collapse collapse">
                <p>
                <pre class="card-block card">WGET <?php echo base_url('cronjob/dbbackup?token=' . $corn['cornkey']) ?></pre>
                <pre class="card-block card">GET <?php echo base_url('cronjob/dbbackup?token=' . $corn['cornkey']) ?></pre>
            </div>
            <hr>
            <a
                    data-toggle="collapse" href="#a9"
                    aria-expanded="false" aria-controls="accordion3c"
                    class="btn btn-default card-title font-size-large  collapsed success"><i
                        class="fa fa-plus-circle"></i>
                Clean 7 Days Old Log</a>

            <div id="a9" role="tabpanel"
                 class="card-collapse collapse">
                <p>
                <pre class="card-block card">WGET <?php echo base_url('cronjob/cleanlog?token=' . $corn['cornkey']) ?></pre>
                <pre class="card-block card">GET <?php echo base_url('cronjob/cleanlog?token=' . $corn['cornkey']) ?></pre>
            </div>
            <hr>
            <a style="display: none"
                    data-toggle="collapse" href="#a10"
                    aria-expanded="false" aria-controls="accordion3c"
                    class="btn btn-default card-title font-size-large  collapsed success"><i
                        class="fa fa-plus-circle"></i>
               Anniversary  Email (Yearly)</a>

            <div id="a10" role="tabpanel" style="display: none"
                 class="card-collapse collapse">
                <p>
                <pre class="card-block card">WGET <?php echo base_url('cronjob/anniversary_mail?token=' . $corn['cornkey']) ?></pre>
                <pre class="card-block card">GET <?php echo base_url('cronjob/anniversary_mail?token=' . $corn['cornkey']) ?></pre>
            </div>
            <hr style="display: none">
               <a style="display: none"
                    data-toggle="collapse" href="#a11"
                    aria-expanded="false" aria-controls="accordion3c"
                    class="btn btn-default card-title font-size-large  collapsed success"><i
                        class="fa fa-plus-circle"></i>
               Anniversary  Sms (Yearly)</a>

            <div id="a11" role="tabpanel"
                 class="card-collapse collapse">
                <p>
                <pre class="card-block card">WGET <?php echo base_url('cronjob/anniversary_sms?token=' . $corn['cornkey']) ?></pre>
                <pre class="card-block card">GET <?php echo base_url('cronjob/anniversary_sms?token=' . $corn['cornkey']) ?></pre>
            </div>
            <hr style="display: none">


        </div>


    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {

        //datatables
        $('#acctable').DataTable({responsive: true});

    });
</script>