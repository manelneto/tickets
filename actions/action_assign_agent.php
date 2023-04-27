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
    $agent = User::getUser($db, (int) $_POST['agent']);

    if ($agent && $agent->isAgent($db) && $agent->assignToDepartment($db, (int) $_POST['department']))
        header('Location: ../pages/dashboard.php');
    else
        header('Location: ../pages/management.php');
?>
