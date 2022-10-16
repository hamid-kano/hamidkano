<!doctype html>
<html>
<head>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Print Statement</title>

    <style>
        body {
            color: #2B2000;
        }

        .invoice-box {
            width: 210mm;
            height: 297mm;
            margin: auto;
            padding: 4mm;
            border: 0;

            font-size: 16pt;
            line-height: 24pt;

            color: #000;
        }

        .invoice-box table {
            width: 100%;
            line-height: 17pt;
            text-align: left;
        }

        .plist tr td {
            line-height: 12pt;
        }

        .subtotal tr td {
            line-height: 10pt;
        }

        .sign {
            text-align: right;
            font-size: 10pt;
            margin-right: 110pt;
        }

        .sign1 {
            text-align: right;
            font-size: 10pt;
            margin-right: 90pt;
        }

        .sign2 {
            text-align: right;
            font-size: 10pt;
            margin-right: 115pt;
        }

        .sign3 {
            text-align: right;
            font-size: 10pt;
            margin-right: 115pt;
        }

        .terms {
            font-size: 9pt;
            line-height: 16pt;
        }

        .invoice-box table td {
            padding: 10pt 4pt 5pt 4pt;
            vertical-align: top;

        }

        .invoice-box table tr td:nth-child(2) {
            text-align: left;
        }

        .invoice-box table tr.top table td {
            padding-bottom: 20pt;

        }

        .invoice-box table tr.top table td.title {
            font-size: 45pt;
            line-height: 45pt;
            color: #555;
        }

        .invoice-box table tr.information table td {
            padding-bottom: 20pt;
        }

        .invoice-box table tr.heading td {
            background: #515151;
            color: #FFF;
            padding: 6pt;

        }

        .invoice-box table tr.details td {
            padding-bottom: 20pt;
        }

        .invoice-box table tr.item td {
            border-bottom: 1px solid #fff;
        }

        .invoice-box table tr.item.last td {
            border-bottom: none;
        }

        .invoice-box table tr.total td:nth-child(4) {
            border-top: 2px solid #fff;
            font-weight: bold;
        }

        .myco {
            width: 500pt;
        }

        .myco2 {
            width: 290pt;
        }

        .myw {
            width: 180pt;
            font-size: 14pt;
            line-height: 30pt;
        }

        .mfill {
            background-color: #eee;
        }

        .tax {
            font-size: 10px;
            color: #515151;
        }

        @media only screen and (max-width: 600px) {
            .invoice-box table tr.top table td {
                width: 100%;
                display: block;
                text-align: center;
            }

            .invoice-box table tr.information table td {
                width: 100%;
                display: block;
                text-align: center;
            }
        }
    </style>
</head>

<body dir="rtl">
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
                <?php echo $this->lang->line('Account Statement');
                $balance = 0; ?>
            </td>
        </tr>
    </table>
    <br>
    <table>
        <thead>
        <tr class="heading">
            <td> <?php echo $this->lang->line('Our Info') ?>:</td>

            <td><?php echo $this->lang->line('Account') ?>:</td>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td><h3><?php echo $this->config->item('ctitle'); ?></h3>
                <?php echo
                    $this->config->item('address') . '<br>' . $this->config->item('city') . ',' . $this->config->item('country') . '<br>Phone: ' . $this->config->item('phone') . '<br> Email: ' . $this->config->item('email'); ?>
            </td>

            <td>
                <?php echo $account['holder'] . '</strong><br>' . $account['acn']; ?>
            </td>
        </tr>
        </tbody>
    </table>
    <hr>
    <table class="plist" cellpadding="0" cellspacing="0">

        <tr>
            <td><strong><?php echo $this->lang->line('Date') ?></strong></td>
            <td><strong><?php echo $this->lang->line('Description') ?></strong></td>

            <td><strong><?php echo $this->lang->line('Debit') ?></strong></td>
            <td><strong><?php echo $this->lang->line('Credit') ?></strong></td>

            <td><strong><?php echo $this->lang->line('Balance') ?></strong></td>


        </tr>

        <?php
        $fill = false;
        foreach ($list as $row) {
            if ($fill == true) {
                $flag = ' mfill';
            } else {
                $flag = '';
            }
            $balance += $row['credit'] - $row['debit'];
            echo '<tr class="item' . $flag . '"><td>' . $row['date'] . '</td><td>' . $row['note'] . '</td><td>' . amountExchange($row['debit'], 0, $this->aauth->get_user()->loc) . '</td><td>' . amountExchange($row['credit'], 0, $this->aauth->get_user()->loc) . '</td><td>' . amountExchange($balance, 0, $this->aauth->get_user()->loc) . '</td></tr>';
            $fill = !$fill;
        }
        ?>
    </table>


    <table class="subtotal">
        <thead>
        <tbody>
        <tr>
            <td class="myco2" rowspan="2"><br><br><br>

            </td>
            <td><strong><?php echo $this->lang->line('Summary') ?>:</strong></td>
            <td></td>


        </tr>
        <tr>


            <td><?php echo $this->lang->line('Balance') ?>:</td>

            <td><?php echo amountExchange($balance, 0, $this->aauth->get_user()->loc); ?></td>
        </tr>

        </tbody>
    </table>
    <br>
    <div class="sign">Authorized person</div>
    <div class="sign1"></div>
    <div class="sign2"></div>
    <div class="sign3"></div>
    <br>
    <div class="terms">
        <hr>

    </div>
</div>
</body>
</html>
