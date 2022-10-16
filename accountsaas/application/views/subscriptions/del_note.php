<!doctype html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Print DO #<?php echo $invoice['tid'] ?></title>
    <style>
        body {
            color: #2B2000;
            font-family: 'Helvetica';
        }

        .invoice-box {
            width: 210mm;
            height: 297mm;
            margin: auto;
            padding: 4mm;
            border: 0;
            font-size: 12pt;
            line-height: 14pt;
            color: #000;
        }

        table {
            width: 100%;
            line-height: 16pt;
            text-align: left;
            border-collapse: collapse;
        }

        .plist tr td {
            line-height: 12pt;
        }

        .subtotal tr td {
            line-height: 10pt;
            padding: 6pt;
        }

        .subtotal tr td {
            border: 1px solid #ddd;
        }

        .sign {
            text-align: left;
            font-size: 10pt;
            margin-left: 90pt;
        }

        .signr {
            text-align: right;
            font-size: 10pt;
            margin-right: 110pt;
            margin-top: -80pt;
        }

        .sign1 {
            text-align: left;
            font-size: 10pt;
            margin-left: 70pt;
        }

        .sign2 {
            text-align: left;
            font-size: 10pt;
            margin-left: 95pt;
        }

        .sign3 {
            text-align: left;
            font-size: 10pt;
            margin-left: 95pt;
        }

        .terms {
            font-size: 9pt;
            line-height: 16pt;
            margin-right: 20pt;
        }

        .invoice-box table td {
            padding: 10pt 4pt 8pt 4pt;
            vertical-align: top;

        }

        .invoice-box table.top_sum td {
            padding: 0;
            font-size: 12pt;
        }

        .party tr td:nth-child(3) {
            text-align: center;
        }

        .invoice-box table tr.top table td {
            padding-bottom: 20pt;

        }

        table tr.top table td.title {
            font-size: 45pt;
            line-height: 45pt;
            color: #555;
        }

        table tr.information table td {
            padding-bottom: 20pt;
        }

        table tr.heading td {
            background: #515151;
            color: #FFF;
            padding: 6pt;

        }

        table tr.details td {
            padding-bottom: 20pt;
        }

        .invoice-box table tr.item td {
            border: 1px solid #ddd;
        }

        table tr.b_class td {
            border-bottom: 1px solid #ddd;
        }

        table tr.b_class.last td {
            border-bottom: none;
        }

        table tr.total td:nth-child(4) {
            border-top: 2px solid #fff;
            font-weight: bold;
        }

        .myco {
            width: 400pt;
        }

        .myco2 {
            width: 300pt;
        }

        .myw {
            width: 240pt;
            font-size: 14pt;
            line-height: 14pt;

        }

        .mfill {
            background-color: #eee;
        }

        .descr {
            font-size: 10pt;
            color: #515151;
        }

        .tax {
            font-size: 10px;
            color: #515151;
        }

        .t_center {
            text-align: right;

        }

        .party {
            border: #ccc 1px solid;
        }


    </style>
</head>

<body <?php if (LTR == 'rtl') echo 'dir="rtl"'; ?>>

<div class="invoice-box">
    <table>
        <tr>
            <td class="myco">
                <img src="<?php echo base_url('userfiles/company/' . $this->config->item('logo')) ?>"
                     style="max-width:260px;">
            </td>
            <td>

            </td>
            <td class="myw">
                <table class="top_sum">
                    <tr>
                        <td colspan="1" class="t_center"><h2><?php echo $this->lang->line('Delivery Note') ?></h2>
                            <br><br></td>
                    </tr>
                    <tr>
                        <td><?php echo $this->lang->line('Delivery Order') ?>:</td>
                        <td><?php echo prefix(3) . '_DO ' . $invoice['tid'] ?></td>
                    </tr>
                    <tr>
                        <td><?php echo $this->lang->line('Invoice') ?></td>
                        <td><?php echo $this->config->item('prefix') . ' #' . $invoice['tid'] ?></td>
                    </tr>
                    <tr>
                        <td>DO Date</td>
                        <td><?php echo dateformat(date('Y-m-d')) ?></td>
                    </tr>

                    <?php if ($invoice['refer']) { ?>
                        <tr>
                            <td><?php echo $this->lang->line('Reference') ?></td>
                            <td><?php echo $invoice['refer'] ?></td>
                        </tr>
                    <?php } ?>
                </table>


            </td>
        </tr>
    </table>

    <br>
    <table class="party">
        <thead>
        <tr class="heading">
            <td> <?php echo $this->lang->line('Our Info') ?>:</td>

            <td><?php echo $this->lang->line('Customer') ?>:</td>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td><strong><?php echo $this->config->item('ctitle'); ?></strong><br>
                <?php echo
                    $this->config->item('address') . '<br>' . $this->config->item('city') . ',' . $this->config->item('country') . '<br>' . $this->lang->line('Phone') . ': ' . $this->config->item('phone') . '<br> ' . $this->lang->line('Email') . ': ' . $this->config->item('email');
                if ($this->config->item('taxno')) echo '<br>' . $this->lang->line('Tax') . ' ID: ' . $this->config->item('taxno');
                ?>
            </td>

            <td>
                <?php echo '<strong>' . $invoice['name'] . '</strong><br>';
                if ($invoice['company']) echo $invoice['company'] . '<br>';
                echo $invoice['address'] . '<br>' . $invoice['city'] . '<br>' . $this->lang->line('Phone') . ': ' . $invoice['phone'] . '<br>' . $this->lang->line('Email') . ' : ' . $invoice['email'];
                if ($invoice['taxid']) echo '<br>' . $this->lang->line('Tax') . ' ID: ' . $invoice['taxid'];
                ?>
            </td>
        </tr><?php if ($invoice['name_s']) { ?>

            <tr>

                <td>
                    <?php echo '<strong>' . $this->lang->line('Shipping Address') . '</strong>:<br>';
                    echo $invoice['name_s'] . '<br>';

                    echo $invoice['address_s'] . '<br>' . $invoice['city_s'] . '<br> ' . $this->lang->line('Phone') . ': ' . $invoice['phone_s'] . '<br> ' . $this->lang->line('Email') . ': ' . $invoice['email_s'];

                    ?>
                </td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
    <br/>
    <table class="plist" cellpadding="0" cellspacing="0">


        <tr class="heading">
            <td>
                <?php echo $this->lang->line('Description') ?>
            </td>


            <td>
                <?php echo $this->lang->line('Qty') ?>
            </td>


        </tr>

        <?php
        $fill = true;
        $sub_t = 0;
        foreach ($products as $row) {

            $cols = 1;

            if ($fill == true) {
                $flag = ' mfill';
            } else {
                $flag = '';
            }
            $sub_t += $row['price'] * $row['qty'];


            echo '<tr class="item' . $flag . '"> 
                            <td>' . $row['product'] . '</td>
							
                            <td style="width:6%;" >' . amountFormat_general($row['qty']) . '</td></tr>   ';


            if ($row['product_des']) {
                $cc = $cols + 1;
                echo '<tr class="item' . $flag . ' descr"> 
                            <td colspan="' . $cc . '">' . $row['product_des'] . '<br>&nbsp;</td>
							
                        </tr>';
            }
            $fill = !$fill;

        }

        if ($invoice['shipping'] > 0) {
            $cols++;
        }

        ?>


    </table>
    <br>
    <?php


    echo '<br><div class="sign">' . $this->lang->line('Authorized person') . '</div><div class="sign1"><img src="' . base_url('userfiles/employee_sign/' . $employee['sign']) . '" width="160" height="50" border="0" alt=""></div><div class="sign2">(' . $employee['name'] . ')</div><div class="sign3">' . user_role($employee['roleid']) . '</div><br><br><br><div class="signr">_____________________________<br>' . $this->lang->line('Received by') . ' &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;</div><hr><strong>' . $this->lang->line('Terms') . ':</strong><div class="terms">' . $invoice['notes'] . '';

    echo '<strong>' . $invoice['termtit'] . '</strong><br>' . $invoice['terms'];
    ?></div>
</div>
</body>
</html>