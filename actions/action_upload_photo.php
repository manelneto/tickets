<?php
  
    declare(strict_types = 1);

    require_once(__DIR__ . '/../utils/session.php');

    $session = new Session();
    $session->checkCSRF();

    if (!$session->isLoggedIn()) {
        $this->addMessage(false, 'You cannot perform that action');
        header('Location: ../pages/index.php');
        die();
    }

    require_once(__DIR__ . '/../database/connection.php');
    $db = getDatabaseConnection();

    require_once(__DIR__ . '/../database/class_user.php');
    $user = User::getUser($db, $session->getId());
    
    $save_dir = "../profile_photos/";
    $original_name = basename($_FILES["file-upload"]["name"]);
    $photo_type = pathinfo($original_name, PATHINFO_EXTENSION);

    $save_file = $save_dir . $session->getId() . "." . $photo_type ;
    
    if($photo_type != "jpg" && $photo_type != "png" && $photo_type != "jpeg") {
        $session->addMessage(false, 'Only JPG, PNG, JPEG files are allowed');
        die();
    }

    if (file_exists($save_file)) {
        unlink($save_file);
    }

    if (move_uploaded_file($_FILES["file-upload"]["tmp_name"], $save_file) && $user->updatePhoto($db, $photo_type))
        $session->addMessage(false, 'Success uploading profile photo');
    else
        $session->addMessage(false, 'Error uploading profile photo');

    header('Location: ../pages/profile.php');
?>