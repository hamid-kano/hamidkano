<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Print VAT summary #<?php echo date("Y-m-d",strtotime($open_date)); ?></title>
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
        #last_row td {
            color: #ffffff !important;
        }
    </style>
</head>
<body dir="<?= LTR ?>">
<h3 id="logo" class="text-center"><br><img style="max-height:100px;" src='<?php $loc = location(0);
    echo FCPATH . 'userfiles/company/' . $loc['logo'];
    ?>' alt='Logo'></h3>
<div id='printbox'>
    <h2 style="margin-top:0" class="text-center"><?= $loc['cname'] ?></h2>
    <h2 style="margin-top:0;direction:rtl;" class="text-center">تقرير ضريبة القيمة المضافة</h2>
    <h2 style="margin-top:0;direction:rtl;" class="text-center"> 
    <?php echo "من   : ".date("Y-m-d",strtotime($open_date)); ?>
    <?php echo "إلى   : ".date("Y-m-d",strtotime($open_t_date)); ?>  
    </h2>
    <?php
        $tax_total = 0;
        $invoice_total = 0;
    ?>
    <table class="inv_info">
        <tbody>
                <tr style="background-color:#b2f4e5;">
            <td>رقم الفاتورة</td>
            <td>تاريخ الفاتورة</td>
            <td>مبلغ الفاتورة</td>
            <td>مبلغ الضريبة</td>
            </tr>
             <?php
                foreach ($invoices as $row) {

            echo "<tr>
            <td>" . $row['tid'] . "#</td>
            <td>" . $row['invoicedate'] . "</td>
            <td>" . ($row['total'] - $row['tax']) . "</td>
            <td>" . $row['tax'] . "</td>
            ";
        echo"</tr>";
            $tax_total += $row['tax'];
            $invoice_total += ($row['total'] - $row['tax']);
        }
        ?>
       
        <tr id="last_row" style="background-color:#000; color:#fff;">
            <td colspan="2">الإجمالى</td>
            <td>مبلغ الفاتورة : <?php echo $invoice_total; ?></td>
            <td>مبلغ الضريبة : <?php echo $tax_total; ?></td>
            </tr>
            
            </tbody>
       
    </table>



</div>

</body>
</html>
