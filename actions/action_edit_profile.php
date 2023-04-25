<?php
    declare(strict_types = 1);

    require_once(__DIR__ . '/../utils/session.php');
    $session = new Session();

    if (!$session->isLoggedIn()) die(header('Location :/'));

    require_once(__DIR__ . '/../database/connection.php');
    $db = getDatabaseConnection();

    require_once(__DIR__ . '/../database/user.php');
    $user = User::getUser($db, $session->getId());

    if ($user) {
        $user->setFirstName(trim($_POST['firstName']));
        $user->setLastName(trim($_POST['lastName']));
        $user->setUsername(strtolower(trim($_POST['username'])));
        $user->setEmail(strtolower(trim($_POST['email'])));
        
        $user->save($db);

        $session->setUsername($user->getUsername());
        $session->setName($user->getName());
        $session->addMessage('success', 'Edit profile successfull!');
    } else {
        $session->addMessage('error', 'Edit profile unsuccessfull!');
    }

    header('Location: ../pages/profile.php');
?>
