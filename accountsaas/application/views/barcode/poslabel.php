<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Print BarCode</title>
    <style>  @page {
            margin: 0 auto;
            sheet-size: 300px 250mm;
        }
    </style>
</head>
<body>
<table cellpadding="20" style="width: 100%">

    <tr>
        <td style="border: 1px solid;"><strong><?= $lab['product_name'] ?></strong><br><?= $lab['product_code'] ?>
            <br><br>
            <barcode code="<?= $lab['barcode'] ?>" text="1" class="barcode" height=".6"/>
            </barcode><br><br>

            <?php
            if ($lab['expiry']) echo $this->lang->line('Expiry Date') . ' ' . dateformat($lab['expiry']) . '<br><br>';
            ?>
            <h3> &nbsp; &nbsp;
                &nbsp; <?= amountExchange($lab['product_price'], 0, $this->aauth->get_user()->loc) ?></h3>
        </td>


    </tr>
    <tr>
        <td style="border: 1px solid;"><strong><?= $lab['product_name'] ?></strong><br><?= $lab['product_code'] ?>
            <br><br>
            <barcode code="<?= $lab['barcode'] ?>" text="1" class="barcode" height=".6"/>
            </barcode><br><br>

            <?php
            if ($lab['expiry']) echo $this->lang->line('Expiry Date') . ' ' . dateformat($lab['expiry']) . '<br><br>';
            ?>
            <h3> &nbsp; &nbsp;
                &nbsp; <?= amountExchange($lab['product_price'], 0, $this->aauth->get_user()->loc) ?></h3>
        </td>


    </tr>
    <tr>
        <td style="border: 1px solid;"><strong><?= $lab['product_name'] ?></strong><br><?= $lab['product_code'] ?>
            <br><br>
            <barcode code="<?= $lab['barcode'] ?>" text="1" class="barcode" height=".6"/>
            </barcode><br><br>

            <?php
            if ($lab['expiry']) echo $this->lang->line('Expiry Date') . ' ' . dateformat($lab['expiry']) . '<br><br>';
            ?>
            <h3> &nbsp; &nbsp;
                &nbsp; <?= amountExchange($lab['product_price'], 0, $this->aauth->get_user()->loc) ?></h3>
        </td>


    </tr>
    <tr>
        <td style="border: 1px solid;"><strong><?= $lab['product_name'] ?></strong><br><?= $lab['product_code'] ?>
            <br><br>
            <barcode code="<?= $lab['barcode'] ?>" text="1" class="barcode" height=".6"/>
            </barcode><br><br>

            <?php
            if ($lab['expiry']) echo $this->lang->line('Expiry Date') . ' ' . dateformat($lab['expiry']) . '<br><br>';
            ?>
            <h3> &nbsp; &nbsp;
                &nbsp; <?= amountExchange($lab['product_price'], 0, $this->aauth->get_user()->loc) ?></h3>
        </td>


    </tr>
    <tr>
        <td style="border: 1px solid;"><strong><?= $lab['product_name'] ?></strong><br><?= $lab['product_code'] ?>
            <br><br>
            <barcode code="<?= $lab['barcode'] ?>" text="1" class="barcode" height=".6"/>
            </barcode><br><br>

            <?php
            if ($lab['expiry']) echo $this->lang->line('Expiry Date') . ' ' . dateformat($lab['expiry']) . '<br><br>';
            ?>
            <h3> &nbsp; &nbsp;
                &nbsp; <?= amountExchange($lab['product_price'], 0, $this->aauth->get_user()->loc) ?></h3>
        </td>


    </tr>
    <tr>
        <td style="border: 1px solid;"><strong><?= $lab['product_name'] ?></strong><br><?= $lab['product_code'] ?>
            <br><br>
            <barcode code="<?= $lab['barcode'] ?>" text="1" class="barcode" height=".6"/>
            </barcode><br><br>

            <?php
            if ($lab['expiry']) echo $this->lang->line('Expiry Date') . ' ' . dateformat($lab['expiry']) . '<br><br>';
            ?>
            <h3> &nbsp; &nbsp;
                &nbsp; <?= amountExchange($lab['product_price'], 0, $this->aauth->get_user()->loc) ?></h3>
        </td>


    </tr>
    <tr>
        <td style="border: 1px solid;"><strong><?= $lab['product_name'] ?></strong><br><?= $lab['product_code'] ?>
            <br><br>
            <barcode code="<?= $lab['barcode'] ?>" text="1" class="barcode" height=".6"/>
            </barcode><br><br>

            <?php
            if ($lab['expiry']) echo $this->lang->line('Expiry Date') . ' ' . dateformat($lab['expiry']) . '<br><br>';
            ?>
            <h3> &nbsp; &nbsp;
                &nbsp; <?= amountExchange($lab['product_price'], 0, $this->aauth->get_user()->loc) ?></h3>
        </td>


    </tr>
    <tr>
        <td style="border: 1px solid;"><strong><?= $lab['product_name'] ?></strong><br><?= $lab['product_code'] ?>
            <br><br>
            <barcode code="<?= $lab['barcode'] ?>" text="1" class="barcode" height=".6"/>
            </barcode><br><br>

            <?php
            if ($lab['expiry']) echo $this->lang->line('Expiry Date') . ' ' . dateformat($lab['expiry']) . '<br><br>';
            ?>
            <h3> &nbsp; &nbsp;
                &nbsp; <?= amountExchange($lab['product_price'], 0, $this->aauth->get_user()->loc) ?></h3>
        </td>


    </tr>
</table>
</body>
</html>