<?php
include('../function/user.php');

if (isset($_GET["user_id"])) {
    $user = get_user_by_id($_GET["user_id"]);
    if ($user) {
        $user_row = mysqli_fetch_assoc($user);
    } else {
        echo "user Not found";
        exit();
    }
} else {
    echo "user Not found";
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>user</title>
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
</head>

<body>

    <div class="container">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="card mt-5">
                    <?php if (isset($_SESSION['msg'])) { ?>
                        <div class="alert alert-<?php echo $_SESSION['type'] ?>" role="alert">
                            <?php echo  $_SESSION['msg'];
                            unset($_SESSION['msg']) ?>
                        </div>
                    <?php } ?>
                    <div class="card-header">
                        <h4>Update user's version</h4>
                    </div>
                    <!-- user_id	title	developer	score	image	description	 -->
                    <form action="" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="user_id" value="<?= $user_row['user_id'] ?>">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="username">username</label>
                                <input required type="text" value="<?= $user_row['username'] ?>" name="username" id="username" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="password">password</label>
                                <input required type="password" value="<?= $user_row['password'] ?>" name="password" id="password" class="form-control">
                            </div>
                            <div class="form-group">
                                <br>
                                <button type="submit" name="update" class="btn btn-success">Update</button>
                                <a href="./index.php" class="btn btn-info">Cancel<i class="fas fa-arrow-left"></i></a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>