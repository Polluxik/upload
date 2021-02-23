<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <title>Document</title>
</head>
<body>
<?php
var_dump($_POST);
var_dump($_FILES);


if ($_FILES) {
    $targetDir = "uploads/";
    $targetFile = $targetDir . basename($_FILES['uploadedName']['name']);
    $fileType = strtolower( pathinfo( $targetFile, PATHINFO_EXTENSION ) );

    $uploadSuccess = true;

    if ($_FILES['uploadedName']['error'] != 0) {
        echo "Critical Error | Server Side";
        $uploadSuccess = false;

    }

    //kontrola existence
    elseif (file_exists($targetFile)) {
        echo "Critical Error | File exists";
        $uploadSuccess = false;
    }

    //kontrola velikosti
    elseif ($_FILES['uploadedName']['size'] > 8000000) {
        echo "Critical Error | Big file size";
        $uploadSuccess = false;
    }


    //kontrola typu
    elseif ($fileType !== "jpg" && $fileType !== "png" && $fileType !== "mp3" && $fileType !== "mp4") {
        echo "Critical Error | Wrong file type";
        $uploadSuccess = false;
    }


    if ( !$uploadSuccess) {
        echo "Critical Error";
    } else {
        //vše je OK
        //přesun souboru
        if (move_uploaded_file($_FILES['uploadedName']['tmp_name'], $targetFile)) {

            echo "File '". basename($_FILES['uploadedName']['name']) . "' has been saved.";

            if($fileType == "jpg" || $fileType == "png")
            {
                echo "<img src='uploads/{$_FILES["uploadedName"]["name"]}' alt='image'>";
            }
            if($fileType == "mp3" || $fileType == "mp4"){
                if($fileType == "mp3"){
                    echo "<audio controls><source src='uploads/{$_FILES["uploadedName"]["name"]}'></audio>";
                }
                if($fileType == "mp4"){ 
                    echo "<video controls><source src='uploads/{$_FILES["uploadedName"]["name"]}'></video>";
                }
            }
        } 
    }

}

?>
<form method='post' action='' enctype='multipart/form-data'><div>
        Select image to upload:
        <input type="file" name="uploadedName" accept="image/*"/>
        <input type="submit" value="Upload" name="submit" />
    </div></form>
</body>
</html>