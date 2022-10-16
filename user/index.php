<?php
include('../function/user.php');

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
            <div class="col-md-12">
                <div class="card mt-5">
                    <div class="card-header">
                        <h3 style="display: inline;"> users</h3>
                        <a href="./add.php" class="btn btn-success" style="float: right;">Add user</i>
                        </a>
                    </div>
                    <?php if (isset($_SESSION['msg'])) { ?>
                        <div class="alert alert-<?php echo $_SESSION['type'] ?>" role="alert">
                            <?php echo  $_SESSION['msg'];
                            unset($_SESSION['msg']) ?>
                        </div>
                    <?php } ?>
                    <hr>
                    <div class="card-body">
                        <table class="table table-hover">
                            <!-- user_id	title	password -->
                            <thead>
                                <tr>
                                    <td>number</td>
                                    <td>username</td>
                                    <td>password</td>
                                    <td>action</td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $user =  getuser();
                                if ($user) {
                                    while ($row = mysqli_fetch_assoc($user)) { ?>
                                        <tr>
                                            <td><?= $row["user_id"] ?></td>
                                            <td><?php echo $row['username']; ?></td>
                                            <td><?php echo $row['password']; ?></td>
                                            <td>
                                                <form onsubmit='return deleteuser("form_<?php echo $row["user_id"] ?>")' id="form_<?php echo $row['user_id']; ?>" action="" method="post">
                                                    <a href="./update.php?user_id=<?php echo $row['user_id']; ?>" class="btn btn-primary">
                                                        Edit</a>
                                                    <input type="hidden" name="user_id" value="<?php echo $row['user_id']; ?>">
                                                    <button name="delete" href="#" class="btn btn-danger">
                                                        Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                <?php
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function submitForm() {
            document.getElementById("genderForm").submit();
        }

        function deleteuser(id_form) {
            var result = confirm("هل تريد الحذف بالتأكيد");
            //alert(result);
            // return false;
            //document.getElementById(id_form).submit();
            return result;
        }
    </script>
</body>

</html>