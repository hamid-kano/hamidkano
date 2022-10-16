<article class="content-body">

    <div class="row animated fadeInRight">

        <div class="col-md-8">
            <div class="card card-block">
                <div class="card-body">
                    <h5><i class="fa fa-print"></i> Printer <?php echo $this->lang->line('Details') ?></h5>
                    <hr>
                    <div class="card">
                        <div class="card-block">

                            <div class="row row-sm stats-container">
                                <div class="col-xs-12 col-sm-6 stat-col">

                                    <div class="stat">
                                        <div class="name"> Printer Name</div>
                                        <div class="value"> <?php echo $printer['val1'] ?></div>

                                    </div>
                                    <hr>
                                </div>
                                <div class="col-xs-12 col-sm-6 stat-col">

                                    <div class="stat">
                                        <div class="name"> Printer Type</div>
                                        <div class="value">  <?php echo $printer['val2'] ?></div>

                                    </div>
                                    <hr>
                                </div>

                                <div class="col-xs-12 col-sm-6 stat-col">

                                    <div class="stat">
                                        <div class="name">Connector</div>
                                        <div class="value"> <?php echo $printer['val3'] ?></div>

                                    </div>
                                    <hr>
                                </div>
                                <div class="col-xs-12 col-sm-6 stat-col">

                                    <div class="stat">
                                        <div class="name"> <?php echo $this->lang->line('Business Location') ?></div>
                                        <div class="value"> <?php $loc = location($printer['val4']);
                                            echo $loc['cname']; ?></div>

                                    </div>
                                    <hr>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>

</article>