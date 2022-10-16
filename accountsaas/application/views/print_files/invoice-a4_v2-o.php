<!doctype html>
<html>
<head>

    <title>Print Invoice #<?php echo $invoice['tid'] ?></title>

    <style type="text/css">

        body {
            font: 14px/1.4 Georgia, serif;
        }


        div {
            border: 0;
            font: 14px Georgia, Serif;
            overflow: hidden;
            resize: none;
        }

        table {
            border-collapse: collapse;
        }

        table td, table th {
            border: 1px solid black;
            padding: 5px;
        }

        #header {
            height: 15px;
            width: 100%;
            margin: 20px 0;
            background: #222;
            text-align: center;
            color: white;
            font: bold 15px Helvetica, Sans-Serif;
            text-decoration: uppercase;
            padding: 8px 0px;
        }


        #meta {
            margin-top: 1px;
            width: 300px;
            float: right;
        }

        #meta td {
            text-align: right;
        }

        #meta td.meta-head {
            text-align: left;
            background: #eee;
        }

        #meta td div {
            width: 100%;
            height: 20px;
            text-align: right;
        }

        #items {
            clear: both;
            width: 100%;
            margin: 30px 0 0 0;
            border: 1px solid black;
        }

        #items th {
            background: #eee;
        }

        #items div {
            width: 80px;
            height: 50px;
        }

        #items tr.item-row td {
            vertical-align: top;
        }

        #items td.description {
            width: 300px;
        }

        #items td.item-name {
            width: 175px;
        }

        #items td.description div, #items td.item-name div {
            width: 100%;
        }

        #items td.total-line {
            text-align: right;
        }

        #items td.total-value {
            border-left: 0;
            padding: 10px;
        }

        #items td.total-value div {
            height: 20px;
            background: none;
        }

        #items td.balance {
            background: #eee;
        }

        #items td.blank {
            border: 0;
        }

        #terms {
            text-align: center;
            margin: 20px 0 0 0;
        }

        #terms h5 {
            text-transform: uppercase;
            font: 13px Helvetica, Sans-Serif;
            border-bottom: 1px solid black;
            padding: 0 0 8px 0;
            margin: 0 0 8px 0;
        }

        #terms div {
            width: 100%;
            text-align: center;
        }

        .top_logo {
            max-height: 180px;
            max-width: 250px;
        <?php if(LTR=='rtl') echo 'margin-left: 200px;' ?>

        }

        .company {
            width: 360pt;
        }

        .header_table td {
            border: 0px;
            padding: 5px;
        }

        }
    </style>


</head>

<body dir="<?= LTR ?>">
<div id="header"><?= $general['title'] ?></div>
<table class="header_table">
    <tr>
        <td class="company"><?php $loc = location($invoice['loc']);
            echo $this->lang->line('From') . '<br>';
            echo '<strong>' . $loc['cname']; ?></strong><br>
            <?php echo
                $loc['address'] . '<br>' . $loc['city'] . ', ' . $loc['region'] . '<br>' . $loc['country'] . ' -  ' . $loc['postbox'] . '<br>' . $this->lang->line('Phone') . ': ' . $loc['phone'] . '<br> ' . $this->lang->line('Email') . ': ' . $loc['email'];
            if ($loc['taxid']) echo '<br>' . $this->lang->line('Tax') . ' ID: ' . $loc['taxid'];
            ?></td>
        <td>


            <img id="image" src="<?php $loc = location($invoice['loc']);
            echo FCPATH . 'userfiles/company/' . $loc['logo'] ?>" alt="logo" class="top_logo"/>
        </td>
    </tr>
    <tr>
        <td class="company"> <?php echo $this->lang->line('To') . '<br>';
            echo '<strong>' . $invoice['name'] . '</strong><br>';
            if ($invoice['company']) echo $invoice['company'] . '<br>';
            echo $invoice['address'] . '<br>' . $invoice['city'] . ', ' . $invoice['region'] . '<br>' . $invoice['country'] . '-' . $invoice['postbox'] . '<br>' . $this->lang->line('Phone') . ': ' . $invoice['phone'] . '<br>' . $this->lang->line('Email') . ' : ' . $invoice['email'];
            if ($invoice['taxid']) echo '<br>' . $this->lang->line('Tax') . ' ID: ' . $invoice['taxid'];
            if (isset($c_custom_fields)) {
                echo '<br>';
                foreach ($c_custom_fields as $row) {
                    echo $row['name'] . ': ' . $row['data'] . '<br>';
                }
            }
            echo '<br><br>';
            ?> </td>
        <td>
            <table id="meta">
                <tr>
                    <td class="meta-head"><?= $general['title'] ?> #</td>
                    <td><?= $general['prefix'] . ' ' . $invoice['tid'] ?></td>
                </tr>
                <tr>

                    <td class="meta-head"><?= $this->lang->line('Due Date') ?></td>
                    <td><?php echo dateformat($invoice['invoiceduedate']) ?></td>
                </tr>
                <tr>
                    <td class="meta-head"><?= $this->lang->line('Total Amount') ?></td>
                    <td><?= amountExchange($invoice['total'], $invoice['multi'], $invoice['loc']) ?></td>
                </tr>

            </table>
        </td>
    </tr>
</table>

<table id="items">

    <tr>
        <th><?php echo $this->lang->line('Products') ?></th>
        <th> <?php echo $this->lang->line('Description') ?></th>
        <th><?php echo $this->lang->line('Price') ?></th>
        <th><?php echo $this->lang->line('Qty') ?></th>
        <th><?php echo $this->lang->line('Amount') ?></th>
    </tr>

    <?php
    $sub_t = 0;
    foreach ($products as $row) {
        $sub_t += $row['price'] * $row['qty'];


        echo '	  <tr class="item-row">
		      <td class="item-name">' . $row['product'] . '</td>
		      <td class="description">' . $row['product_des'] . '</td>
		      <td>' . amountExchange($row['price'], $invoice['multi'], $invoice['loc']) . '</td>
		      <td>' . +$row['qty'] . $row['unit'] . '</td>
		      <td>' . amountExchange($row['subtotal'], $invoice['multi'], $invoice['loc']) . '</td>
		  </tr>';


    }
    ?>


    <tr>
        <td colspan="2" class="blank">
            <hr>
        </td>
        <td colspan="2" class="total-line"><?= $this->lang->line('SubTotal') ?></td>
        <td class="total-value"><?php echo amountExchange($sub_t, $invoice['multi'], $invoice['loc']); ?></td>
    </tr>
    <?php if ($invoice['tax'] > 0) {
        echo '<tr>

		      <td colspan="2" class="blank"> </td>
		      <td colspan="2" class="total-line">' . $this->lang->line('Total Tax') . '</td>
		      <td class="total-value"><div id="total">' . amountExchange($invoice['tax'], $invoice['multi'], $invoice['loc']) . '</div></td>
		  </tr>';
    }
    ?>
    <?php if ($invoice['discount'] > 0) {
        echo '<tr>

		      <td colspan="2" class="blank"> </td>
		      <td colspan="2" class="total-line">' . $this->lang->line('Total Discount') . '</td>
		      <td class="total-value"><div id="total">' . amountExchange($invoice['discount'], $invoice['multi'], $invoice['loc']) . '</div></td>
		  </tr>';
    }
    ?>
    <?php if ($invoice['shipping'] > 0) {
        echo '<tr>

		      <td colspan="2" class="blank"> </td>
		      <td colspan="2" class="total-line">' . $this->lang->line('Shipping') . '</td>
		      <td class="total-value"><div id="total">' . amountExchange($invoice['shipping'], $invoice['multi'], $invoice['loc']) . '</div></td>
		  </tr>';
    }

    echo '<tr>

		      <td colspan="2" class="blank"> </td>
		      <td colspan="2" class="total-line">' . $this->lang->line('Total Amount') . '</td>
		      <td class="total-value"><div id="total">' . amountExchange($invoice['total'], $invoice['multi'], $invoice['loc']) . '</div></td>
		  </tr>';
    $rming = $invoice['total'] - $invoice['pamnt'];
    if ($rming < 0) {
        $rming = 0;

    }
    echo '<tr>

		      <td colspan="2" class="blank"> </td>
		      <td colspan="2" class="total-line">' . $this->lang->line('Balance Due') . '</td>
		      <td class="total-value"><div id="total">' . amountExchange($rming, $invoice['multi'], $invoice['loc']) . '</div></td>
		  </tr>';
    ?>


</table>
<?php if ($invoice['notes']) echo $this->lang->line('Note') . ': ' . $invoice['notes'] . '<br>'; ?>
<div id="terms">
    <h5><?= $invoice['termtit'] ?></h5>
    <?= $invoice['terms'] ?>
</div>


</body>

</html>