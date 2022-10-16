<table>
    <tr>
        <td class="myco">
            <img src="<?php $loc = location($invoice['loc']);
            echo base_url('userfiles/company/' . $loc['logo']) ?>"
                 style="max-height:180px;max-width:250px;">
        </td>
        <td>

        </td>
        <td class="myw">
            <table class="top_sum">
                <tr>
                    <td colspan="1" class="t_center"><h2><?php echo $this->lang->line('Credit Note') ?></h2><br><br>
                    </td>
                </tr>
                <tr>
                    <td><?php echo $this->lang->line('Note') ?></td>
                    <td><?php echo prefix(4) . $invoice['tid'] ?></td>
                </tr>
                <tr>
                    <td><?php echo $this->lang->line('Date') ?></td>
                    <td><?php echo $invoice['invoicedate'] ?></td>
                </tr>

                <?php if ($invoice['refer']) { ?>
                    <tr>
                        <td><?php echo $this->lang->line('Reference') ?></td>
                        <td><?php echo $invoice['refer'] ?></td>
                    </tr>
                <?php } ?>
            </table>


        </td>
    </tr>
</table>
