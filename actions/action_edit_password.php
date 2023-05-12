<?php
    declare(strict_types = 1);

    require_once(__DIR__ . '/../utils/session.php');
    $session = new Session();

    if (!$session->isLoggedIn()) {
        header('Location: ../pages/index.php');
        die();
    }

    require_once(__DIR__ . '/../database/connection.php');
    $db = getDatabaseConnection();

    require_once(__DIR__ . '/../database/class_user.php');
    $user = User::getUser($db, $session->getId());

    if ($user && $_POST['new'] === $_POST['confirm'] && $user->editPassword($db, $_POST['current'], $_POST['new']))
        header('Location: ../pages/profile.php');
    else
        header('Location: ../pages/password.php');
?>
