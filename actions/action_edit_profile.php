<?php
    declare(strict_types = 1);

    require_once(__DIR__ . '/../utils/session.php');
    $session = new Session();

    if (!$session->isLoggedIn()) {
        header('Location: ../pages/index.php');
        die();
    }

    $firstName = trim($_POST['first-name']);
    $lastName = trim($_POST['last-name']);
    $username = strtolower(trim($_POST['username']));
    $email = strtolower(trim($_POST['email']));

    if ($firstName === '' || $lastName === '' || $username === '' || $email == '') {
        $session->addMessage(false, 'Profile fields cannot be empty');
        header('Location: ../pages/profile.php');
        die();
    }

    require_once(__DIR__ . '/../database/connection.php');
    $db = getDatabaseConnection();

    require_once(__DIR__ . '/../database/class_user.php');
    $user = User::getUser($db, $session->getId());

    if ($user && $user->edit($db, $firstName, $lastName, $username, $email)) {
        $session->setName($user->getName());
        $session->addMessage(true, 'Profile successfully edited');
    } else
        $session->addMessage(false, 'Username/Email already exists');

    header('Location: ../pages/profile.php');
?>
