<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Print paymeny summery #<?php echo date("Y-m-d",strtotime($open_date)); ?></title>
    <style>
        html, body {
            margin: 0;
            padding: 0;
            font-size: 9pt;
            background-color: #fff;
        }
        table{
            width: 100%;
        }
        tr , td{
            border:1px solid #000;
            text-align:center;
            margin :0;
        }
        #products {
            width: 100%;
        }

        #products tr td {
            font-size: 8pt;
        }

        #printbox {
            width: 100%;
            margin: 5pt;
            padding: 5px;
            text-align: center;
        }
        
        .contrast td{
             width: 100%;
            background: #000;
            color: #fff;
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

        }

        .text-center {
            text-align: center;
        }
    </style>
</head>
<body dir="<?= LTR ?>">
<h3 id="logo" class="text-center"><br><img style="max-height:100px;" src='<?php $loc = location(0);
    echo FCPATH . 'userfiles/company/' . $loc['logo'];
    ?>' alt='Logo'></h3>
<div id='printbox'>
    <h2 style="margin-top:0" class="text-center"><?= $loc['cname'] ?></h2>
    <h2 style="margin-top:0;direction:rtl;" class="text-center"> 
    <?php echo date("Y-m-d",strtotime($open_date)); ?>
    <?php echo date("g:ia",strtotime($open_t_time)); ?>
    <?php echo date("Y-m-d",strtotime($open_t_date)); ?>  
       <?php echo date("g:ia",strtotime($open_time)); ?>  
    </h2>
    <?php
        $sum_cash = 0;
        $sum_card = 0;
        $sum_onaccount = 0;
    ?>
    <table class="inv_info">
                <tr style="background-color:#b2f4e5;">
            <td colspan="2"><?php echo $this->lang->line('Cash') ?></td>
            <td colspan="2"> <?php  echo $cashInvoices['cashTotal'][0]['cashTotal']+$cashInvoices['cashTotal2'][0]['cashTotal']; ?></td>
            </tr>
             <?php
                foreach ($cashInvoices as $row) {
if($row['tid'])
{
            echo '<tr>
            <td colspan="">' . $row['tid'] . '#</td>
             <td colspan="">' . $row['invoicetime'] . '</td>
            <td colspan="">' . $row['invoicedate'] . '</td>';
            if($row['amount_cash'] == 0 || $row['amount_cash'] == null){
             echo' <td colspan="">' . $row['total'] . '</td>';
             }
             else{
                  echo' <td colspan="">' . $row['amount_cash'] . '</td>';
             }
        echo'</tr>';
        } }?>
        
        <!--    <tr style="background-color:#e9f4b2;">-->
        <!--    <td colspan="2"><?php echo $this->lang->line('Card Swipe') ?></td>-->
        <!--    <td colspan="2"><?php echo $register['card']+$register['cardInvoices']['cardTotal2'][0]['cardTotal'] ?></td>-->
        <!--</tr>-->
       
         
        <?php 
            $sum_cash += $register['cash'];
            $sum_card += $register['card'];
            $sum_onaccount+=$register['bank'];
         
        
        
        ?>
       
    </table>



</div>

</body>
</html>
