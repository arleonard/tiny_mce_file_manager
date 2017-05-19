<?php

require_once('FileManagerHelper.php');

$file_manager_helper = new FileManagerHelper($_GET['filename']);

if (!$file_manager_helper->file_type_allowed()) {
    die;
}

header($file_manager_helper->get_mime_type());
readfile($_GET['thumb']?$file_manager_helper->thumb_path():$file_manager_helper->file_path());