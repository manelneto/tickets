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

    if ($user && $user->update($db, trim($_POST['firstName']), trim($_POST['lastName']), strtolower(trim($_POST['username'])), strolower(trim($_POST['email'])))) {
        $session->setUsername($user->getUsername());
        $session->setName($user->getName());
    }

    header('Location: ../pages/profile.php');
?>
