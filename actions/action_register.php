<?php
    declare(strict_types = 1);

    require_once(__DIR__ . '/../utils/session.php');
    $session = new Session();
    $session->checkCSRF();

    if ($session->isLoggedIn()) {
        header('Location: ../pages/index.php');
        die();
    }

    $firstName = trim($_POST['first-name']);
    $lastName = trim($_POST['last-name']);
    $username = strtolower(trim($_POST['username']));
    $email = strtolower(trim($_POST['email']));
    $password = $_POST['password'];

    if ($firstName === '' || $lastName === '' || $username === '' || $email === '' || $password === '') {
        $session->addMessage(false, 'Register fields cannot be empty');
        header('Location: ../pages/register.php');
        die();
    }

    require_once(__DIR__ . '/../database/connection.php');
    $db = getDatabaseConnection();

    require_once(__DIR__ . '/../database/class_user.php');
    $user = User::registerUser($db, $firstName, $lastName, $username, $email, $password);

    if ($user) {
        $session->setId($user->getId());
        $session->setName($user->getName());
        $session->setAgent($user->isAgent($db));
        $session->setAdmin($user->isAdmin($db));
        header('Location: ../pages/dashboard.php');
    } else {
        $session->addMessage(false, 'Register unsuccessful: username/email already exists');
        header('Location: ../pages/register.php');
    }
?>
