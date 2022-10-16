<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Print BarCode</title>
    <style>  @page {
            margin: 0 auto;
            sheet-size: <?= $style['width'] ?>mm  <?= $style['height'] ?>mm;
        }

        .text-center {
            text-align: center;
        }
    </style>
</head>
<body>
<table cellpadding="<?= $style['padding'] ?>" style="width: 100%">
    <?php
    foreach ($products as $lab) {
        for ($i = 0; $i <= $style['total_rows']; $i++) { ?>
            <tr>
                <td style="border: 1px solid;" class="text-center"><strong><?= $lab['product_name'] ?></strong><br>
                    <?php if ($style['product_code']) echo '<br>' . $style['product_code'] . $lab['product_code'];
                    if ($style['warehouse_name']) echo '<br>' . $style['warehouse'] ?>
                    <br><br>
                    <barcode code="<?= $lab['barcode'] ?>" text="1" class="barcode"
                             height="<?= $style['bar_height'] ?>"/>
                    </barcode><br><br>
                    <br><?php if ($style['store_name']) echo $style['store'] . '<br><br>';
                    if ($lab['expiry']) echo $this->lang->line('Expiry Date') . ' ' . dateformat($lab['expiry']) . '<br><br>';
                    ?>
                    <h3><?php if ($style['product_price']) echo amountExchange($lab['product_price'], 0, $this->aauth->get_user()->loc) . '<br><br>'; ?></h3>
                </td>
                <?php
                if ($style['items_per_row'] == 2) {

                    ?>
                    <td style="border: 1px solid;" class="text-center"><strong><?= $lab['product_name'] ?></strong>


                        <?php if ($style['product_code']) echo '<br>' . $lab['product_code'] ?>
                        <?php if ($style['warehouse_name']) echo $style['warehouse_name'] . '<br>' . $style['warehouse'] ?>
                        <br><br>
                        <barcode code="<?= $lab['barcode'] ?>" text="1" class="barcode"
                                 height="<?= $style['bar_height'] ?>"/>
                        </barcode><br><br>
                        <br> <?php if ($style['store_name']) echo $style['store'] . '<br><br>'; ?>
                        <?php
                        if ($lab['expiry']) echo $this->lang->line('Expiry Date') . ' ' . dateformat($lab['expiry']) . '<br><br>';
                        ?>
                        <h3><?= amountExchange($lab['product_price'], 0, $this->aauth->get_user()->loc) ?></h3>
                    </td>

                    <?php

                }
                                if ($style['items_per_row'] > 2) {

                    ?>
                    <td style="border: 1px solid;" class="text-center"><strong><?= $lab['product_name'] ?></strong>


                        <?php if ($style['product_code']) echo '<br>' . $lab['product_code'] ?>
                        <?php if ($style['warehouse_name']) echo $style['warehouse_name'] . '<br>' . $style['warehouse'] ?>
                        <br><br>
                        <barcode code="<?= $lab['barcode'] ?>" text="1" class="barcode"
                                 height="<?= $style['bar_height'] ?>"/>
                        </barcode><br><br>
                        <br> <?php if ($style['store_name']) echo $style['store'] . '<br><br>'; ?>
                        <?php
                        if ($lab['expiry']) echo $this->lang->line('Expiry Date') . ' ' . dateformat($lab['expiry']) . '<br><br>';
                        ?>
                        <h3><?= amountExchange($lab['product_price'], 0, $this->aauth->get_user()->loc) ?></h3>
                    </td>
                    <td style="border: 1px solid;" class="text-center">
                        <strong><?= $lab['product_name'] ?></strong><br><?= $lab['product_code'] ?>
                        <br><?= $style['warehouse'] ?><br><br>
                        <barcode code="<?= $lab['barcode'] ?>" text="1" class="barcode"
                                 height="<?= $style['bar_height'] ?>"/>
                        </barcode><br><br>
                        <br><?= $style['store'] ?><br><br>
                        <?php
                        if ($lab['expiry']) echo $this->lang->line('Expiry Date') . ' ' . dateformat($lab['expiry']) . '<br><br>';
                        ?>
                        <h3><?= amountExchange($lab['product_price'], 0, $this->aauth->get_user()->loc) ?></h3>
                    </td>
                    <?php

                }
                ?>


            </tr>
        <?php }
    } ?>

</table>
</body>
</html>