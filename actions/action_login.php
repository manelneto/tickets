<?php
    declare(strict_types = 1);

    require_once(__DIR__ . '/../utils/session.php');
    $session = new Session();

    if ($session->isLoggedIn()) {
        header('Location: ../pages/index.php');
        die();
    }

    require_once(__DIR__ . '/../database/connection.php');
    $db = getDatabaseConnection();

    require_once(__DIR__ . '/../database/class_user.php');
    $user = User::loginUser($db, strtolower(trim($_POST['username'])), $_POST['password']);

    if ($user) {
        $session->setId($user->getId());
        $session->setUsername($user->getUsername());
        $session->setName($user->getName());
        $session->setAgent($user->isAgent());
        $session->setAdmin($user->isAdmin());
        header('Location: ../pages/dashboard.php');
    } else {
        header('Location: ../pages/login.php');
    }
?>
