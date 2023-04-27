<?php
    declare(strict_types = 1);

    require_once(__DIR__ . '/../utils/session.php');
    $session = new Session();

    if (!$session->isAdmin()) {
        header('Location: ../pages/index.php');
        die();
    }

    require_once(__DIR__ . '/../database/connection.php');
    $db = getDatabaseConnection();

    require_once(__DIR__ . '/../database/class_user.php');
    $client = User::getUser($db, $_POST['client']);

    if ($client && $_POST['role'] === 'agent' && $client->upgradeToAgent())
        header('Location: ../pages/dashboard.php');
    else if ($client && $_POST['role'] === 'admin' $client->upgradeToAdmin())
        header('Location: ../pages/dashboard.php');
    else
        header('Location: ../pages/management.php');
?>
