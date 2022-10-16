<table>
    <tr>
        <td class="myco">
            <img src="<?php $loc = location($invoice['loc']);
            echo FCPATH . 'userfiles/company/' . $loc['logo'] ?>"
                 class="top_logo">
        </td>
        <td>

        </td>
        <td class="myw">
            <table class="top_sum">
                <tr>
                    <td colspan="1" class="t_center"><h2><?= $general['title'] ?></h2><br><br></td>
                </tr>
                <tr>
                    <td><?= $general['title'] ?></td>
                    <td><?= $general['prefix'] . ' ' . $invoice['tid'] ?></td>
                </tr>
                <tr>
                    <td><?= $general['title'] . ' ' . $this->lang->line('Date') ?></td>
                    <td><?php echo dateformat($invoice['invoicedate']) ?></td>
                </tr>
                <tr>
                    <td><?php echo $this->lang->line('Due Date') ?></td>
                    <td><?php echo dateformat($invoice['invoiceduedate']) ?></td>
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
<br>