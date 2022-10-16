<!doctype html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Print Invoice #<?php echo $invoice['tid'] ?></title>
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
            width: 200pt;
        }

        .myw {
            width: 300pt;
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

        .top_logo {
            max-height: 180px;
            max-width: 250px;


        }


    </style>
</head>

<body>

<div class="invoice-box">


    <br>
    <table class="party">
        <thead>
        <tr class="heading">
            <td> <?php echo $this->lang->line('Our Info') ?>:</td>

            <td><?= $general['person'] ?>:</td>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td><strong><?php $loc = location($invoice['loc']);
                    echo $loc['cname']; ?></strong><br>
                <?php echo
                    $loc['address'] . '<br>' . $loc['city'] . ', ' . $loc['region'] . '<br>' . $loc['country'] . ' -  ' . $loc['postbox'] . '<br>' . $this->lang->line('Phone') . ': ' . $loc['phone'] . '<br> ' . $this->lang->line('Email') . ': ' . $loc['email'];
                if ($loc['taxid']) echo '<br>' . $this->lang->line('GSTIN') . ' : ' . $loc['taxid'];
                ?>
            </td>

            <td>
                <?php echo '<strong>' . $invoice['name'] . '</strong><br>';
                if ($invoice['company']) echo $invoice['company'] . '<br>';
                echo $invoice['address'] . '<br>' . $invoice['city'] . ', ' . $invoice['region'] . '<br>' . $invoice['country'] . '-' . $invoice['postbox'] . '<br>' . $this->lang->line('Phone') . ': ' . $invoice['phone'] . '<br>' . $this->lang->line('Email') . ' : ' . $invoice['email'];
                if ($invoice['taxid']) echo '<br>' . $this->lang->line('GSTIN') . ' : ' . $invoice['taxid'];
                if (isset($c_custom_fields)) {
                    echo '<br>';
                    foreach ($c_custom_fields as $row) {
                        echo $row['name'] . ': ' . $row['data'] . '<br>';
                    }
                }
                ?>
            </td>
        </tr><?php if (@$invoice['name_s']) { ?>

            <tr>

                <td>
                    <?php echo '<strong>' . $this->lang->line('Shipping Address') . '</strong>:<br>';
                    echo $invoice['name_s'] . '<br>';

                    echo $invoice['address_s'] . '<br>' . $invoice['city_s'] . ', ' . $invoice['region_s'] . '<br>' . $invoice['country_s'] . '-' . $invoice['postbox_s'] . '<br> ' . $this->lang->line('Phone') . ': ' . $invoice['phone_s'] . '<br> ' . $this->lang->line('Email') . ': ' . $invoice['email_s'];

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
                <?php echo $this->lang->line('HSN') ?>
            </td>
            <td>
                <?php echo $this->lang->line('Price') ?>
            </td>
            <td>
                <?php echo $this->lang->line('Qty') ?>
            </td>
            <?php
            if ($invoice['discount'] > 0) echo '<td>' . $this->lang->line('Discount') . '</td>';
            if ($invoice['taxstatus'] == 'cgst') { ?>
                <td>
                    <?php echo $this->lang->line('CGST') ?>
                </td>
                <td>
                    <?php echo $this->lang->line('SGST') ?>
                </td>
            <?php } else {

                ?>
                <td>
                    <?php echo $this->lang->line('IGST') ?>
                </td>
                <?php
            }
            ?>
            <td class="t_center">
                <?php echo $this->lang->line('SubTotal') ?>
            </td>
        </tr>

        <?php
        $fill = true;
        $sub_t = 0;
        $sub_t_col = 4;
        foreach ($products as $row) {
            $gst = $row['totaltax'] / 2;
            $rate = $row['tax'] / 2;
            $cols = 4;

            if ($fill == true) {
                $flag = ' mfill';
            } else {
                $flag = '';
            }
            $sub_t += $row['price'] * $row['qty'];


            echo '<tr class="item' . $flag . '"> 
                            <td>' . $row['product'] . '</td>
                            <td style="width:12%;" >' . $row['code'] . '</td> 
							<td style="width:12%;">' . amountExchange($row['price'], $invoice['multi'], $invoice['loc']) . '</td>
                            <td style="width:12%;" >' . amountFormat_general($row['qty']) . $row['unit'] . '</td>   ';
            if ($invoice['discount'] > 0) {
                $cols++;
                echo ' <td style="width:16%;">' . amountExchange($row['totaldiscount'], $invoice['multi'], $invoice['loc']) . '</td>';
            }
            if ($invoice['taxstatus'] == 'cgst') {
                echo '<td style="width:16%;">' . amountExchange($gst, $invoice['multi'], $invoice['loc']) . ' <span class="tax">(' . amountFormat_s($rate) . '%)</span></td>';
                echo '<td style="width:16%;">' . amountExchange($gst, $invoice['multi'], $invoice['loc']) . ' <span class="tax">(' . amountFormat_s($rate) . '%)</span></td>';
            } else if ($invoice['taxstatus'] == 'igst') {
                echo '<td style="width:16%;">' . amountExchange($row['totaltax'], $invoice['multi'], $invoice['loc']) . ' <span class="tax">(' . amountFormat_s($row['tax']) . '%)</span></td>';
            }

            $cols++;

            echo '<td class="t_center">' . amountExchange($row['subtotal'], $invoice['multi'], $invoice['loc']) . '</td>
                        </tr>';
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
            $sub_t_col++;
        }
        if ($invoice['discount'] > 0) {
            $sub_t_col++;
        }

        ?>


    </table>
    <br>
    <table class="subtotal">


        <tr>
            <td class="myco2" rowspan="<?php echo $sub_t_col ?>"><br>
                <p><?php echo '<strong>' . $this->lang->line('Status') . ': ' . $this->lang->line(ucwords($invoice['status'])) . '</strong></p>';
                    if (!$general['t_type']) {

                        echo '<br><p>' . $this->lang->line('Total Amount') . ': ' . amountExchange($invoice['total'], $invoice['multi'], $invoice['loc']) . '</p><br><p>' . $this->lang->line('Paid Amount') . ': ' . amountExchange($invoice['pamnt'], $invoice['multi'], $invoice['loc']);
                    }

                    if ($general['t_type']) {
                        echo '<hr>' . $this->lang->line('Proposal') . ': </br></br><small>' . $invoice['proposal'] . '</small>';
                    }
                    ?></p>
            </td>
            <td><strong><?php echo $this->lang->line('Summary') ?>:</strong></td>
            <td></td>


        </tr>
        <tr class="f_summary">


            <td><?php echo $this->lang->line('SubTotal') ?>:</td>

            <td><?php echo amountExchange($sub_t, $invoice['multi'], $invoice['loc']); ?></td>
        </tr>
        <?php if ($invoice['taxstatus'] == 'cgst') {

            echo ' <tr>

            <td>Total CGST + SGST</td>

            <td>' . amountExchange($invoice['tax'], $invoice['multi'], $invoice['loc']) . '</td></tr>';
        } else {
            echo ' <tr>

            <td>Total IGST</td>

            <td>' . amountExchange($invoice['tax'], $invoice['multi'], $invoice['loc']) . '</td></tr>';
        } ?>
        <?php
        if ($invoice['discount'] > 0) {
            echo '<tr>


            <td>' . $this->lang->line('Total Discount') . ':</td>

            <td>' . amountExchange($invoice['discount'], $invoice['multi'], $invoice['loc']) . '</td>
        </tr>';

        }
        if ($invoice['shipping'] > 0) {
            echo '<tr>


            <td>' . $this->lang->line('Shipping') . ':</td>

            <td>' . amountExchange($invoice['shipping'], $invoice['multi'], $invoice['loc']) . '</td>
        </tr>';

        }
        ?>
        <tr>


            <td><?php echo $this->lang->line('Balance Due') ?>:</td>

            <td><strong><?php $rming = $invoice['total'] - $invoice['pamnt'];
    if ($rming < 0) {
        $rming = 0;

    }
    echo amountExchange($rming, $invoice['multi'], $invoice['loc']);
    echo '</strong></td>
		</tr>
		</table><br><div class="sign">' . $this->lang->line('Authorized person') . '</div><div class="sign1"><img src="' . base_url('userfiles/employee_sign/' . $employee['sign']) . '" width="160" height="50" border="0" alt=""></div><div class="sign2">(' . $employee['name'] . ')</div> <div class="terms">' . $invoice['notes'] . '<hr><strong>' . $this->lang->line('Terms') . ':</strong><br>';

    echo '<strong>' . $invoice['termtit'] . '</strong><br>' . $invoice['terms'];
    ?></div>
</div>
</body>
</html>