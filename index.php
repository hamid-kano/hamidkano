<?php
include('fun.php');
include('header.php');


if (isset($_GET['search'])) {
    $all_game = get_game_by_search($_GET['search']);
} elseif (isset($_GET['desc'])) {
    $all_game = getgame_desc();
} else if (isset($_GET['asc'])) {
    $all_game = getgame();
} else if (isset($_GET['alphapitlacy'])) {
    $all_game = getgame_alphapitlacy();
} else if (isset($_GET['recently'])) {
    $all_game = getgame_recently();
} else {
    $all_game = getgame();
}
if ($all_game) {

    $count_game = mysqli_num_rows($all_game);
?>


    <div class="container justify-content-center">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="row pt-5 mb-4">
                    <div class="col-md-4">
                        <h3><?= $count_game ?> Games Available</h3>
                    </div>
                    <div class="col-md-8">
                        <form style="display:inline ;" action="" method="get"> <input type="submit" name="popularity" class="btn btn-secondary" value="Popularity" /></form>
                        <form style="display:inline ;" action="" method="get"> <input type="submit" name="recently" class="btn btn-secondary" value="Recently Updated" /></form>
                        <form style="display:inline ;" action="" method="get"> <input type="submit" name="alphapitlacy" class="btn btn-secondary" value="alphapitlacy" /></form>
                        <form style="display:inline ;" action="" method="get"> <input type="submit" name="asc" class="btn btn-secondary" value="ASC" /></form>
                        <form style="display:inline ;" action="" method="get"> <input type="submit" value="DESC" name="desc" class="btn btn-secondary" /></form>
                    </div>
                </div>

                <?php
                while ($game_row = mysqli_fetch_assoc($all_game)) { ?>
                    <div class="card p-4 mb-4">
                        <div class="row">
                            <div class="col-md-6">
                                <h3 style="display:inline ;"><?= $game_row['title'] ?></h3> <span>by Dev <?= $game_row['developer'] ?></span>
                            </div>
                            <div class="col-md-6">
                                <span>#score submitted: <?= $game_row['score'] ?></span>
                            </div>
                        </div>
                        <div class="row pt-4">
                            <div class="col-md-4">
                                <img src="./image/<?= $game_row['image'] ?>" width="100%" height="250px" alt="">
                            </div>
                            <div class="col-md-8">
                                <p><?= $game_row['description'] ?></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 offset-md-4 mt-4">
                                <?php
                                if (isset($_SESSION['login']) && $_SESSION['login'] == true) { ?>
                                    <a href="./files/<?= substr($game_row['image'], 0, 13); ?>" class="btn btn-primary">Play Game</a>
                                <?php }  ?>
                            </div>
                        </div>
                    </div>

                <?php }
                ?>
            </div>
        </div>
    </div>
<?php }
?>
<?php include('footer.php'); ?>