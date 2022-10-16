<?php include('../header.php'); ?>
<?php
include('../function/user.php');
?>

<div class="container">
    <div class="row">
        <div class="col-md-4 offset-md-4">
            <div class="card mt-4 p-3">
                <?php if (isset($_SESSION['msg'])) { ?>
                    <div class="alert alert-<?php echo $_SESSION['type'] ?>" role="alert">
                        <?php echo  $_SESSION['msg'];
                        unset($_SESSION['msg']) ?>
                    </div>
                <?php } ?>
                <div class="">
                    <h4>Login</h4>
                </div>
                <!-- User_id	username	developer	score	image	description	 -->
                <form action="" method="post" enctype="multipart/form-data">
                    <div class="card-body">
                        <div class="input-group mb-3">
                            <span style="width: 75px;" class="input-group-text" id="basic-addon1">@</span>
                            <input type="text" class="form-control" style="width:100px ;" name="username" id="username" placeholder="Username" aria-label="Username" aria-describedby="basic-addon1">
                        </div>
                        <div class="input-group mb-3">
                            <span style="width: 75px;" class="input-group-text" id="basic-addon1">#123</span>
                            <input type="password" class="form-control" style="width:100px ;" name="password" id="password" placeholder="password" aria-label="Username" aria-describedby="basic-addon1">
                        </div>
                        <div class="form-group">
                            <br>
                            <button type="submit" name="login" class="btn btn-primary">login</button>
                            <a href="./index.php" style="float: right;" class="">Cancel<i class="fas fa-arrow-left"></i></a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</body>

</html>