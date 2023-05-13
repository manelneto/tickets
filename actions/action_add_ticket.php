<?php
    declare(strict_types = 1);

    require_once(__DIR__ . '/../utils/session.php');
    $session = new Session();

    if (!$session->isLoggedIn()) {
        header('Location: ../pages/index.php');
        die();
    }

    require_once(__DIR__ . '/../database/connection.php');
    $db = getDatabaseConnection();
    
    require_once(__DIR__ . '/../database/class_ticket.php');
    $dateOpened = date('Y-m-d');

    $departmentId = (int) $_POST['department'];

    $names = (strpos($_POST['tags'], ',') !== false) ? explode(',', $_POST['tags']) : array(trim($_POST['tags']));

    $tags = array();

    foreach ($names as $name) {
        $tag = Tag::getTagByName($db, $name);
        if ($tag)
            $tags[] = $tag;
    }

    if (Ticket::addTicket($db, $session->getId(), trim($_POST['title'] ?? ''), trim($_POST['description'] ?? ''), $dateOpened, $departmentId, $tags)) {
        $session->addMessage(true, 'Ticket successfully added');
        header('Location: ../pages/tickets.php');
    }
    else {
        $session->addMessage(false, 'Action unsuccessful');
        header('Location: ../pages/new_ticket.php');
    }

?>
