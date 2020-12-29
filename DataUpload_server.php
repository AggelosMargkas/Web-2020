<?php


//what does php receives?
var_dump($_FILES);


// Moves uploaded files to a directory
foreach ($_FILES["MyFile"]["tmp_name"] as $key => $value) {

    $targetPath = "uploads/" . basename($_FILES["MyFile"]["name"][$key]);
    move_uploaded_file($value, $targetPath);
}
