<?php
    declare(strict_types = 1);

    require_once(__DIR__ . '/../utils/session.php');
    $session = new Session();

    if ($session->isLoggedIn()) {
        header('Location: ../pages/index.php');
        die();
    }

    $username = strtolower(trim($_POST['username']));
    $password = $_POST['password'];

    if ($username === '') {
        $session->addMessage(false, 'Username cannot be empty');
        header('Location: ../pages/login.php');
        die();
    }

    require_once(__DIR__ . '/../database/connection.php');
    $db = getDatabaseConnection();

    require_once(__DIR__ . '/../database/class_user.php');
    $user = User::loginUser($db, $username, $password);

    if ($user) {
        $session->setId($user->getId());
        $session->setName($user->getName());
        $session->setAgent($user->isAgent($db));
        $session->setAdmin($user->isAdmin($db));
        $session->addMessage(true, 'Login successful');
        header('Location: ../pages/dashboard.php');
    } else {
        header('Location: ../pages/login.php');
        $session->addMessage(false, 'Login unsuccessful');
    }
?>
