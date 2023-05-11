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
    $dateDue = date('Y-m-d', strtotime($dateOpened . ' + 10 days'));

    $departmentId = (int) $_POST['department'];
    $tagsInput = explode(',', $_POST['tags']);

    $tags = array();

    foreach ($tagsInput as $tagInput)
        $tags[] = Tag::getTagByName($db, $tagInput);

    if (Ticket::addTicket($db, $session->getId(), trim($_POST['title']), trim($_POST['content']), $dateOpened, $dateDue, $departmentId, $tags))
        header('Location: ../pages/tickets.php');
    else
        header('Location: ../pages/new_ticket.php');

?>
