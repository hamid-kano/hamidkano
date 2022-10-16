<?php
include('../function/game.php');

if (isset($_GET["game_id"])) {
    $game = get_game_by_id($_GET["game_id"]);
    if ($game) {
        $game_row = mysqli_fetch_assoc($game);
    } else {
        echo "Game Not found";
        exit();
    }
} else {
    echo "Game Not found";
    exit();
}
?>
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
                        <h4>Update Game's version</h4>
                    </div>
                    <!-- game_id	title	developer	score	image	description	 -->
                    <form action="" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="game_id" value="<?= $game_row['game_id'] ?>">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="title">title</label>
                                <input readonly required type="text" value="<?= $game_row['title'] ?>" name="title" id="title" class="form-control">
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="file_game">Game's File .zip New version </label>
                                <input required class="form-control" type="file" name="file_game" id="file_game">
                            </div>
                            <div class="form-group">
                                <br>
                                <button type="submit" name="update" class="btn btn-success">Update</button>
                                <a href="./index.php" class="btn btn-info">Return<i class="fas fa-arrow-left"></i></a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>