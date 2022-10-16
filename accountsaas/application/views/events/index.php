<style>


    td {
        width: 14rem !important;
        height: 6rem;
        text-align: center;
        border: 1px solid #e2e0e0;
        font-size: 18px;

    }

    th {
        height: 50px;
        padding-bottom: 8px;
        background: #25BAE4;
        font-size: 20px;
        text-align: center;
        color: #fff;
    }

    th a {
        color: #fff;
    }

    td a {
        color: white;
        background-color: #3BAFDA;
        padding: 6px;
        border-radius: 6px;
    }

    .prev_sign a, .next_sign a {
        color: white;
        text-decoration: none;
    }

</style>
<div class="app-content content container-fluid">
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="card card-block">
                <div id="notify" class="alert alert-success" style="display:none;">
                    <a href="#" class="close" data-dismiss="alert">&times;</a>

                    <div class="message"></div>
                </div>
                <div class="row">


                    <div class="col-sm-12 cmp-pnl"><?php
                        echo $cal;
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
