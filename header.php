<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Game</title>
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
</head>

<body class="p-3">
    <div class="container card p-4 ">
        <div class="row">
            <div class="col-md-9 p-2 px-4">
                <form action="" method="get">
                    <div class="form-group border border-secondary p-1 px-3" style="width:fit-content ;border-radius: 5px;">
                        <input style="display:inline ;width: 150px;" onkeypress="checkSubmit(e)" class="form-control" type="text" name="search" id="">
                        <label style="display:inline ;" for="search"> Games</label>
                    </div>
                </form>
            </div>
            <div class="col-md-3">
                <?php
                if (isset($_SESSION['login']) && $_SESSION['login'] == true) { ?>
                    <span>Active Player: <?= $_SESSION['username'] ?></span>
                    <a href="./user/signout.php">sign out</a>

                <?php  } else { ?>
                    <a href="./user/add.php">sing up</a>
                    <a href="./user/login.php">sing in</a>
                <?php  }
                ?>

            </div>
        </div>
    </div>
    </div>
    <script>
        function checkSubmit(e) {
            if (e && e.keyCode == 13) {
                document.forms[0].submit();
            }
        }
    </script>