<?php include('../header.php'); ?>
<?php
session_start(); //to ensure you are using same session
session_destroy(); //destroy the session

?>

<div class="container">
    <div class="row">
        <div class="col-md-4 offset-md-4">
            <div class="card mt-4 p-3" style="height: 300px;">
                <?php if (isset($_SESSION['msg'])) { ?>
                    <div class="alert alert-<?php echo $_SESSION['type'] ?>" role="alert">
                        <?php echo  $_SESSION['msg'];
                        unset($_SESSION['msg']) ?>
                    </div>
                <?php } ?>
                <div class="">
                    <h4>Sign Out</h4>
                </div>
                <p class="pt-5">
                    You Have been successfuly signed out
                </p>
            </div>
        </div>
    </div>
</div>
</body>

</html>