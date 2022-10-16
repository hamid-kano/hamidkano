<?php
include('../function/game.php');
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
                <div class="card">
                    <?php if (isset($_SESSION['msg'])) { ?>
                        <div class="alert alert-<?php echo $_SESSION['type'] ?>" role="alert">
                            <?php echo  $_SESSION['msg'];
                            unset($_SESSION['msg']) ?>
                        </div>
                    <?php } ?>
                    <div class="card-header">
                        <h4>Add Game</h4>
                    </div>
                    <!-- game_id	title	developer	score	image	description	 -->
                    <form action="" method="post" enctype="multipart/form-data">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="title">title</label>
                                <input required type="text" name="title" id="title" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="developer">developer</label>
                                <input required type="text" name="developer" id="developer" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="score">score</label>
                                <input required type="text" name="score" id="score" class="form-control">
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="image">image</label>
                                <input required onchange="validation_img(this);" class="form-control" type="file" name="image" id="image">
                            </div>
                            <div style="padding: 15px;">
                                <img width="350px" id="uploadPreview" src="" alt="">
                            </div>
                            <div class="form-group">
                                <label for="score"> </label>
                                <textarea class="form-control" name="description" id="description" cols="30" rows="10"></textarea>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="file_game">Game's File .zip </label>
                                <input required class="form-control" type="file" name="file_game" id="file_game">
                            </div>
                            <div class="form-group">
                                <br>
                                <button type="submit" name="create" class="btn btn-success">Add</button>
                                <a href="./index.php" class="btn btn-info">Return<i class="fas fa-arrow-left"></i></a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        var ext_img = [".jpg", ".png", ".jpeg"];

        function validation_img(oinput) {
            var result = false;
            if (oinput.type = "file") {
                var img_file_name = oinput.value;
                if (img_file_name.length > 0) {
                    for (var index = 0; index < ext_img.length; index++) {
                        var cur_extention = ext_img[index];
                        var cu_exte = ext_img[index].length;
                        if (img_file_name.substr(img_file_name.length - cu_exte, cu_exte).toLowerCase() == cur_extention
                            .toLowerCase()) {
                            // hamid.PNG ==> 9 - 4 ,4  ==> 5 , 4 ===> .png != .jpg
                            result = true;
                            break;
                        }
                    }

                }

                // للتأكد من صيغة الملف
                if (result != true) {
                    alert("يجب ان يكون الملف من صيغة " + ext_img.join(" , "));
                    oinput.value = "";
                }
                // للتأكد من حجم الملف
                const fileSize = Math.round(oinput.files[0].size / 1024);
                // if (fileSize > 200) {
                //     alert("يجب أن لا يتجاوز حجم الصورة فوق 200 كيلو بايت");
                //     oinput.value = "";
                //     document.getElementById("uploadPreview").src = "";
                //     result = false;
                // }

            }

            // لعرض الصورة بعد عمليات التحقق السابقة
            if (result == true) {
                PreviewImage();
            }
            return result;
        }

        function PreviewImage() {

            var img = document.getElementById("image").files[0];

            var oFReader = new FileReader();
            oFReader.readAsDataURL(img);

            oFReader.onload = function(oFREvent) {
                document.getElementById("uploadPreview").src = oFREvent.target.result;
            }

        }
    </script>
</body>

</html>