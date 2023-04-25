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
    $user = User::registerUser($db, strtolower(trim($_POST['firstName'])), strtolower(trim($_POST['lastName'])), strtolower(trim($_POST['username'])), strtolower(trim($_POST['email'])), $_POST['password']);

    if ($user) {
        $session->setId($user->getId());
        $session->setUsername($user->getUsername());
        $session->setName($user->getName());
        $session->addMessage('success', 'Register successfull!');
        header('Location: ../pages/dashboard.php');
    } else {
        $session->addMessage('error', 'Register unsuccessfull!');
        header('Location: ../pages/register.php');
    }
?>
