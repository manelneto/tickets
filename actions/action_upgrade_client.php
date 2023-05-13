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
    $client = User::getUser($db, (int) $_POST['client']);

    switch ($_POST['role']) {
        case 'agent':
            if ($client && $client->upgradeToAgent($db))
                $session->addMessage(true, 'Client successfully upgraded to agent');
            else
                $session->addMessage(false, 'Client is already an agent');
            break;
        case 'admin':
            if ($client && $client->upgradeToAdmin($db))
                $session->addMessage(true, 'Client successfully upgraded to admin');
            else
                $session->addMessage(false, 'Client is already an admin');
            break;
        default:
            $session->addMessage(false, 'Client could not be upgraded');
            break;
    }

    header('Location: ../pages/management.php');
?>
