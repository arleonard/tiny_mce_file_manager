<?
require_once('FileManagerHelper.php');

if( isset($_POST["submit"])) {
    $file_manager_helper = new FileManagerHelper($_FILES["fileToUpload"]["name"]);

    if (getimagesize($_FILES["fileToUpload"]["tmp_name"]) == false) {
        $alert = "File is not an image.";
    } elseif (file_exists($file_manager_helper->file_path())) {
        $alert = "Sorry, file already exists.";
    } elseif ($_FILES["fileToUpload"]["size"] > 500000) {
        $alert = "Sorry, your file is too large.";
    } elseif(!$file_manager_helper->file_type_allowed()) {
        $alert = "Sorry, only JPG, JPEG, PNG, GIF, and BMP files are allowed.";
    } else {
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $file_manager_helper->file_path())) {
            $cmd = "convert -thumbnail 200x200 " . $file_manager_helper->file_path() . " " . $file_manager_helper->thumb_path();
            exec($cmd);
            $alert = "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
        } else {
            $alert = "Sorry, there was an error uploading your file.";
        }
    }

    $_POST['file_manager_alert'] = $alert;
    header( 'location:http://' . $_SERVER['HTTP_HOST'] . '/' .str_replace('upload.php', 'file_manager.php', substr($_SERVER['REQUEST_URI'],1)));
}