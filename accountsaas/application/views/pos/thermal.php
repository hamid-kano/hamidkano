<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Print Invoice #<?php echo $invoice['tid'] ?></title>
    <style>
        @page {
            margin: 0 auto;
            sheet-size: 300px 250mm;
        }

        html, body {
            margin: 0;
            padding: 0;
            font-size: 9pt;
        }

        #products {
            width: 100%;
        }

        #products tr td {
            font-size: 8pt;
        }

        #printbox {
            width: 280px;
            margin: 5pt;
            padding: 5px;
            text-align: justify;
        }

        .inv_info tr td {
            padding-right: 10pt;
        }

        .product_row {
            margin: 15pt;
        }

        .stamp {
            margin: 5pt;
            padding: 3pt;
            border: 3pt solid #111;
            text-align: center;
            font-size: 20pt;
            color
        }

        .text-center {
            text-align: center;
        }

    </style>
</head>
<body>
<h3 id="logo" class="text-center"><br><img style="max-height:100px;" src='<?php $loc = location($invoice['loc']);
    echo base_url('userfiles/company/' . $loc['logo']) ?>' alt='Logo'></h3>
<div id='printbox'>
    <h2 style="margin-top:0" class="text-center"><?= $loc['cname'] ?></h2>
    <table class="inv_info">
        <tr>
            <td><?php echo $this->lang->line('Invoice') ?></td>
            <td><?php echo $this->config->item('prefix') . ' #' . $invoice['tid'] ?></td>
        </tr>
        <tr>
            <td><?php echo $this->lang->line('Invoice Date') ?></td>
            <td><?php echo dateformat($invoice['invoicedate']) . ' ' . date('H:i:s') ?><br></td>
        </tr>

        <tr>
            <td><?php echo $this->lang->line('Customer') ?></td>
            <td><?php echo $invoice['name']; ?></td>
        </tr>
    </table>
    <hr>
    <table id="products">
        <tr class="product_row">
            <td><b> <?php echo $this->lang->line('Description') ?></b></td>
            <td><b><?php echo $this->lang->line('Qty') ?>&nbsp;</b></td>
            <td><b><?php echo $this->lang->line('SubTotal') ?></b></td>
        </tr>
        <tr>
            <td colspan="3">
                <hr>
            </td>
        </tr>
        <?php foreach ($products as $row) {
            echo '<tr>
            <td >' . $row['product'] . '</td>
             <td>' . amountFormat_general($row['qty']) . ' ' . $row['unit'] . '</td>
            <td>' . amountExchange($row['subtotal'], $invoice['multi'], $invoice['loc']) . '</td>
        </tr><tr><td colspan="3">&nbsp;</td></tr>';
        } ?>
    </table>
    <hr>
    <table class="inv_info">
        <?php if ($invoice['taxstatus'] == 'cgst') {
            $gst = $row['totaltax'] / 2;
            $rate = $row['tax'] / 2;
            ?>
            <tr>
                <td><b><?php echo $this->lang->line('CGST') ?></b></td>
                <td><b><?php echo amountExchange($gst, $invoice['multi'], $invoice['loc']) ?></b> (<?= $rate ?>%)</td>
            </tr>
            <tr>
                <td><b><?php echo $this->lang->line('SGST') ?></b></td>
                <td><b><?php echo amountExchange($gst, $invoice['multi'], $invoice['loc']) ?></b> (<?= $rate ?>%)</td>
            </tr>

        <?php } else if ($invoice['taxstatus'] == 'igst') {

            ?>
            <tr>
                <td><b><?php echo $this->lang->line('IGST') ?></b></td>
                <td><b><?php echo amountExchange($invoice['tax'], $invoice['multi']) ?></b>
                    (<?= amountFormat_general($row['tax']) ?>%)
                </td>
            </tr>
        <?php } ?>
        <tr>
            <td><b><?php echo $this->lang->line('Total Tax') ?></b></td>
            <td><b><?php echo amountExchange($invoice['tax'], $invoice['multi'], $invoice['loc']) ?></b></td>
        </tr>
        <tr>
            <td><b><?php echo $this->lang->line('Total Discount') ?></b></td>
            <td><b><?php echo amountExchange($invoice['discount'], $invoice['multi'], $invoice['loc']) ?></b></td>
        </tr>
        <tr>
            <td><b><?php echo $this->lang->line('Total') ?></b></td>
            <td><b><?php echo amountExchange($invoice['total'], $invoice['multi'], $invoice['loc']) ?></b></td>
        </tr>
    </table>
    <hr>
    <div class="text-center">  <?php echo $this->lang->line('Thank you') ?></div>
    <?php if ($qrc AND $invoice['status'] != 'paid') { ?>
        <div class="text-center">
            <small><?php echo $this->lang->line('Scan & Pay') ?></small>
            <img style="max-height:230px;" src='<?php echo base_url('userfiles/pos_temp/' . $qrc) ?>' alt='QR'></div>
    <?php } else {
        echo '<div class="stamp">' . $this->lang->line(ucwords($invoice['status'])) . '</div>';
    } ?>
</div>
</body>
</html>