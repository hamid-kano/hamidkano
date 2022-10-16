<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Print Invoice #<?php echo $invoice['tid'] ?></title>
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
</head>
<body dir="<?= LTR ?>" >

          <table class="inv_info">
                  <tr>
        	<td colspan="2" style="text-align:center"><img style="max-height:70px;width:120px" src='<?php $loc = location($invoice['loc']);
        echo FCPATH . 'userfiles/company/' . $loc['logo'];
        ?>' alt='Logo'></td>
        </tr>

        <tr>
        	<td colspan="2" style="text-align:center"><b><?= $loc['cname'] ?></b></td>
        </tr>
         <tr>
        	<td colspan="2" style="text-align:center"><?php echo $address?></td>
        </tr>
        
            <?php   if ($loc['taxid']) {      ?> <tr>
                <td style="font-size:12px"><?php echo $this->lang->line('TAX ID') ?></td>
                <td style="font-size:13px"><?php echo $loc['taxid'] ?></td>
            </tr>
            <?php } ?>
            <tr>
                <td style="font-size:12px"> <?php echo $this->lang->line('Invoice') ?></td>
                <td style="font-size:13px"><?php echo $this->config->item('prefix') . ' #' . $invoice['tid'] ?></td>
            </tr>
            <tr>
                <td style="font-size:12px"><?php echo $this->lang->line('Invoice Date') ?></td>
                <td style="font-size:13px"><?php echo dateformat($invoice['invoicedate']).' - '.$invoice['invoicetime']  ?><br></td>
            </tr>
            <!-- <tr>
                <td><?php echo $this->lang->line('Time') ?></td>
                <td><?php echo $invoice['invoicetime'] ?><br></td>
            </tr> comment -->

           
            <tr>
                <td style="font-size:12px"><?php echo $this->lang->line('Customer') ?></td>
                <td style="font-size:13px"><?php echo $invoice['name']; ?></td>
            </tr>

            <tr>
                <td style="font-size:12px"><?php echo $this->lang->line('UserName') ?></td>
                <td style="font-size:13px"><?php echo $employee['name']; ?></td>
            </tr>

        </table>
    <hr>
   <table id="products">
            <tr class="product_row">
                <td style="width:35%;text-align:center"><b> <?php echo $this->lang->line('Description') ?></b></td>
                <td style="width:30%;text-align:center"><b><?php echo $this->lang->line('Qty') ?>&nbsp;</b></td>
                <td style="width:35%;text-align:center"><b><?php echo $this->lang->line('amount_req') ?></b></td>
            </tr>
            <tr>
                <td colspan="3">
                    <hr>
                </td>
            </tr>
            <?php
            $this->pheight = 0;
            foreach ($products as $row) {
                $this->pheight = $this->pheight + 8;
                echo '<tr>
            <td style="width:35%;text-align:center">' . $row['product'] . '</td>
             <td style="width:30%;text-align:center">' . +$row['qty'] . ' ' . $row['unit'] . '</td>
            <td style="width:35%;text-align:center">' . amountExchange($row['subtotal'], $invoice['multi'], $invoice['loc']) . '</td>
        </tr><tr><td colspan="3">&nbsp;</td></tr>';
            } ?>
        </table>
    <hr>
         <table class="inv_info">
     
        
            <tr>
                <td style="text-align:right;font-size:13px"><?php echo $this->lang->line('SubTotalInclude') ?></td>
                <td style="text-align:left;font-size:13px"><?php echo amountExchange($invoice['total'], $invoice['multi'], $invoice['loc']) ?></td>
            </tr>

             <tr>
            <td style="text-align:right;font-size:13px"><?php echo $this->lang->line('Total Tax'). ' ('.amountFormat_s($row['tax']) . '%)' ?></td>
            <td style="text-align:left;font-size:13px"><?php echo amountExchange($invoice['tax'], $invoice['multi'], $invoice['loc']) ?></td>
        </tr>
        </table>
    <hr>
    <div class="text-center">  <?=$massage_order["massage_order"]?></div>
    
  <br>
     		<?php $this->pheight = $this->pheight + 40; ?>
        <div class="text-center">
          
             <img style="max-height:90px;width:90px" src='<?php echo base_url('userfiles/pos_temp/' . $qrc) ?>' alt='QR'> 
             <small style="display:none"><?php echo $this->lang->line('Scan & Pay') ?></small>
        </div>
</div>


 <script type="text/javascript">
      $(document).ready(function () {
    window.print();
});
 </script>

</body>
</html>
