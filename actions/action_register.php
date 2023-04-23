<?php
    declare(strict_types = 1);

    require_once(__DIR__ . '/../utils/session.php');
    $session = new Session();

    require_once(__DIR__ . '/../database/connection.php');
    $db = getDatabaseConnection();

    require_once(__DIR__ . '/../database/user.php');
    $user = User::registerUser($db, $_POST['firstName'], $_POST['lastName'], $_POST['username'], $_POST['email'], $_POST['password']);

    if ($user) {
        $session->setId($user->getId());
        $session->setUsername($user->getUsername());
        $session->addMessage('success', 'Register successfull!');
        header('Location: ../pages/dashboard.php');
    } else {
        $session->addMessage('error', 'Register unsuccessfull!');
        header('Location: ../pages/register.php');
    }
?>
