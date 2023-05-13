<?php
    declare(strict_types = 1);

    require_once(__DIR__ . '/../utils/session.php');
    $session = new Session();

    if (!$session->isLoggedIn()) {
        header('Location: ../pages/index.php');
        die();
    }

    $new = $_POST['new'];

    if ($new !== $_POST['confirm']) {
        $session->addMessage(false, 'The introduced passwords do not match');
        header('Location: ../pages/password.php');
        die();
    }

    require_once(__DIR__ . '/../database/connection.php');
    $db = getDatabaseConnection();

    require_once(__DIR__ . '/../database/class_user.php');
    $user = User::getUser($db, $session->getId());

    if ($user && $user->editPassword($db, $_POST['current'], $_POST['new']))
        $session->addMessage(true, 'Password successfully edited');
    else
        $session->addMessage(false, 'The current password does not match');

    header('Location: ../pages/password.php');
?>
