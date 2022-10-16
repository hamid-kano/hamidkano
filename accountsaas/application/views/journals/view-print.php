<!doctype html>
<html>
<head>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Print journal #<?php echo $journal['id'] ?></title>

    <style>

        body , * {
            direction: rtl;
        }
        @page {
            sheet-size: 210mm 297mm;
        }

        h1.bigsection {
            page-break-before: always;
            page: bigger;
        }

        table td {
            padding: 8pt;
        }

        table  {
            border: 2px solid #000;
        }

        table tr td , table tr th , table tr{
            border: 2px solid #000;
        }


    </style>

</head>
<body style="font-family: Helvetica;">

<h5><?php echo $this->lang->line('Journal') .'<br><span style="direction:ltr">'. ' ID : ' . $journal['id'].'</span>' ?></h5>


                <div class="row">

                    <hr>
                    <div class="col-md-12">
                        <address>
                            <?php $loc = location(0);
                            echo '<strong>' . $loc['cname'] . '</strong><br>' .
                                $loc['address'] . '<br>' . $loc['city'] . ', ' . $loc['region'] . '<br>' . $loc['country'] . ' -  ' . $loc['postbox'] . '<br> ' . $this->lang->line('Phone') . ': ' . $loc['phone'] . '<br>  ' . $this->lang->line('Email') . ': ' . $loc['email'];
                            ?>
                        </address>
                    </div>

                </div>
                <hr>
                <div class="row">


                    <?php echo '<div class="col-md-6">
                    <p>' . $this->lang->line('sum journal') . ' : ' . amountExchange($journal['sum'], 0, $this->aauth->get_user()->loc) . ' </p>
                    <p>' . $this->lang->line('Note') . ' : ' . $journal['note'] . '</p>
                </div>

                <div class="col-md-6 text-right">
                    <p>' . $this->lang->line('Date') . ' : ' . dateformat($journal['date']) . '</p>
            </div>'; ?>
            <div class="col-md-12" style="width: 100%">

                <table class="table table-bordered" style="width: 100%">
                    <tr>
                        <th><?php echo $this->lang->line('Account') ?></th>
                        <th><?php echo $this->lang->line('Payer') ?></th>
                        <th><?php echo $this->lang->line('Debit') ?></th>
                        <th><?php echo $this->lang->line('Credit') ?></th>
                        <th><?php echo $this->lang->line('Note') ?></th>
                    </tr>

                        <?php foreach ($transactions as $transaction) { ?>
                            <tr>
                            <td><?php echo $transaction['account'] ?></td>
                            <td><?php echo $transaction['payer'] ?></td>
                            <td><?php echo $transaction['debit'] ?></td>
                            <td><?php echo $transaction['credit'] ?></td>
                            <td><?php echo $transaction['note'] ?></td>
                            </tr>
                        <?php } ?>
                </table>
            </div>

            <div class="col-md-12" style="width: 100%">
                <hr>
                <h1><?php echo $this->lang->line('Attachments') ?></h1>

                    <div class="form-group">
                        <p>
                            <?php foreach (explode(',', $journal['files']) as $row) {
                                if($row) {
                             ?>


                                <section class="row">


                                    <div data-block="sec" class="col">
                                        <div class=""><?php


                                            echo '<a class="" href="' . base_url('userfiles/journal/' . $row) . '">' . $row . '</a> ';
                                            echo '<br>';

                                            ?></div>
                                    </div>
                                </section>
                            <?php } } ?>
                        </p>
                    </div>
            </div>

                </div>
</body>