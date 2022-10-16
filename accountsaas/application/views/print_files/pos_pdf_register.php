<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Print paymeny summery #<?php echo $o_date ?></title>
    <style>
        html, body {
            margin: 0;
            padding: 0;
            font-size: 9pt;
            background-color: #fff;
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
<body dir="<?= LTR ?>" onload="window.print()">
<h3 id="logo" class="text-center"><br><img style="max-height:100px;" src='<?php $loc = location($invoice['loc']);
    echo FCPATH . 'userfiles/company/' . $loc['logo'];
    ?>' alt='Logo'></h3>
<div id='printbox'>
    <h2 style="margin-top:0" class="text-center"><?= $loc['cname'] ?></h2>
    <h2 style="margin-top:0" class="text-center"> <?php echo $o_date ?></h2>

    <table class="inv_info">
        
        <tr style="background-color:#b2f4e5;">
            <td><?php echo $this->lang->line('Cash') ?></td>
        
            <td> <?php  echo $cash ?></td>
    
        
        
                </tr>
                 <tr>
            <td colspan="3">
                <hr>
            </td>
        </tr>
                <tr>
              <td><?php echo $this->lang->line('InvoiceNumber') ?></td>
            
            <td> <?php echo $this->lang->line('InvoiceAmount') ?></td>
        
        
            <?php
                foreach ($cashInvoices as $row) {
if($row['tid'])
{
            echo '<tr>
            <td >' . $row['tid'] . '#</td>
             <td>' . +$row['total'] . '</td>
        </tr>';
        } }?>
        </tr>
        <tr>
       <td colspan="3">
                <hr>
            </td>
            </tr>
            <tr>
            <td><?php echo $this->lang->line('InvoiceCashAmountTotal') ?></td>
        
            <td> <?php  echo $cashInvoices['cashTotal'][0]['cashTotal'] ?></td>
                </tr>
            <tr>
                <tr>
            <td><?php echo $this->lang->line('CashAmountTotal') ?></td>
        
            <td> <?php  echo $cash-$cashInvoices['cashTotal'][0]['cashTotal']?></td>
                </tr>
            <tr>
            <td colspan="3">
                <hr>
            </td>
             </tr>
        <tr style="background-color:#b2d4f4;">
            <td><?php echo $this->lang->line('Card Swipe') ?></td>
            <td><?php echo $card ?><br></td>
        </tr>
                         <tr>
            <td colspan="3">
                <hr>
            </td>
        </tr>
                <tr>
              <td><?php echo $this->lang->line('InvoiceNumber') ?></td>
            
            <td> <?php echo $this->lang->line('InvoiceAmount') ?></td>
        
        
            <?php
                foreach ($cardInvoices as $row) {
if($row['tid'])
{
            echo '<tr>
            <td >' . $row['tid'] . '#</td>
             <td>' . +$row['total'] . '</td>
        </tr>';
        } }?>
        </tr>
        <tr>
       <td colspan="3">
                <hr>
            </td>
            </tr>
            <tr>
            <td><?php echo $this->lang->line('InvoiceCardAmountTotal') ?></td>
        
            <td> <?php  echo $cardInvoices['cardTotal'][0]['cardTotal'] ?></td>
                </tr>
            <tr>
            <td colspan="3">
                <hr>
            </td>
            
             </tr>
             
             
              <tr style="background-color:#b2f4e5;">
            <td><?php echo $this->lang->line('OnAccount') ?></td>
            <td><?php echo $bank ?><br></td>
        </tr>
                         <tr>
            <td colspan="3">
                <hr>
            </td>
        </tr>
                <tr>
              <td><?php echo $this->lang->line('InvoiceNumber') ?></td>
            
            <td> <?php echo $this->lang->line('InvoiceAmount') ?></td>
        
        
            <?php
                foreach ($onAccountInvoices as $row) {
if($row['tid'])
{
            echo '<tr>
            <td >' . $row['tid'] . '#</td>
             <td>' . +$row['total'] . '</td>
        </tr>';
        } }?>
        </tr>
        <tr>
       <td colspan="3">
                <hr>
            </td>
            </tr>
            <tr>
            <td><?php echo $this->lang->line('totalOnAccount') ?></td>
        
            <td> <?php  echo $bank ?></td>
                </tr>
            <tr>
    </table>



</div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
</body>
</html>
