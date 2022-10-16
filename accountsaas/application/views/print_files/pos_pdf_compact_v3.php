<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Print Invoice #<?php echo $invoice['tid'] ?></title>
    <style>
        html, article {
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
            margin: 3pt;
            padding: 3px;
            text-align: justify;
        }

        .inv_info tr td {
            padding-right: 10pt;
        }

        .product_row {
            margin: 12pt;
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
<article>
    
    <div id='printbox'>
        
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
            <?php if ($invoice['taxstatus'] == 'cgst') {
                $gst = $row['totaltax'] / 2;
                $rate = $row['tax'] / 2;
                ?>
                <!--<tr>-->
                <!--    <td><b><?php echo $this->lang->line('CGST') ?></b></td>-->
                <!--    <td><b><?php echo amountExchange($gst, $invoice['multi'], $invoice['loc']) ?></b> (<?= $rate ?>%)</td>-->
                <!--</tr>-->
                <!--<tr>-->
                <!--    <td><b><?php echo $this->lang->line('SGST') ?></b></td>-->
                <!--    <td><b><?php echo amountExchange($gst, $invoice['multi'], $invoice['loc']) ?></b> (<?= $rate ?>%)</td>-->
                <!--</tr>-->
            <?php } else if ($invoice['taxstatus'] == 'igst') {
                ?>
                <!--<tr>-->
                <!--    <td><b><?php echo $this->lang->line('IGST') ?></b></td>-->
                <!--    <td><b><?php echo amountExchange($invoice['tax'], $invoice['multi']) ?></b>-->
                <!--        (<?= amountFormat_general($row['tax']) ?>%)-->
                <!--    </td>-->
                <!--</tr>-->
            <?php } ?>
          
        

            <?php if($invoice['tax']!=0) {?>
    <!-- <tr>
            <td><b><?php echo $this->lang->line('Sub Total') ?></b></td>
            <td><b> <?php echo amountExchange($sub_t, 0, $this->aauth->get_user()->loc) ?></b></td>
        </tr>-->
        
       
            <?php }
            if($invoice['discount']!=0)
            { ?>
                <tr>
                    <td><b><?php echo $this->lang->line('Total Discount') ?></b></td>
                    <td><b><?php echo amountExchange($invoice['discount'], $invoice['multi'], $invoice['loc']) ?></b></td>
                </tr>
            <?php }?>
            <tr>
                <td style="text-align:right;font-size:13px"><?php echo $this->lang->line('SubTotalInclude') ?></td>
                <td style="text-align:left;font-size:13px"><?php echo amountExchange($invoice['total'], $invoice['multi'], $invoice['loc']) ?></td>
            </tr>

             <tr>
            <td style="text-align:right;font-size:13px"><?php echo $this->lang->line('Total Tax'). ' ('.amountFormat_s($row['tax']) . '%)' ?></td>
            <td style="text-align:left;font-size:13px"><?php echo amountExchange($invoice['tax'], $invoice['multi'], $invoice['loc']) ?></td>
        </tr>


            <?php
           
            if ($round_off['other']) {
                $final_amount = round($invoice['total'], $round_off['active'], constant($round_off['other']));
                ?>
                <tr>
                    <td><b><?php echo $this->lang->line('Total') ?></b>(<?php echo $this->lang->line('Round Off') ?>)</td>
                    <td><b><?php echo amountExchange($final_amount, $invoice['multi'], $invoice['loc']) ?></b></td>
                </tr>
                <?php
            }
            ?>
        </table>
        <hr>
     <div class="text-center">  <?=$massage_order["massage_order"]?></div>
     <br>
     		<?php $this->pheight = $this->pheight + 40; ?>
        <div class="text-center">
          
             <img style="max-height:90px;width:90px" src='<?=$qr_code_image?>' alt='QR'> 
             <small style="display:none"><?php echo $this->lang->line('Scan & Pay') ?></small>
        </div>

       
    </div>
</article>
<br><br><br><br><br><br><br>
<article>
   
    <div id='printbox'>
      
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
                <td style="width:50%;text-align:center"><b> <?php echo $this->lang->line('Description') ?></b></td>
                <td style="width:50%;text-align:center"><b><?php echo $this->lang->line('Qty') ?>&nbsp;</b></td>
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
            <td style="width:50%;text-align:center">' . $row['product'] . '</td>
             <td style="width:50%;text-align:center">' . +$row['qty'] . ' ' . $row['unit'] . '</td>
        </tr><tr><td colspan="3">&nbsp;</td></tr>';
            } ?>
        </table>
    </div>
</article>

 <script type="text/javascript">
     $(document).ready(function () {
         window.print();
     });
 </script>

</body>
</html>
