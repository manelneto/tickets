<?php
    declare(strict_types = 1);

    require_once(__DIR__ . '/../utils/session.php');
    $session = new Session();

    if (!$session->isAgent()) {
        header('Location: ../pages/index.php');
        die();
    }

    $id = (int) $_POST['id'];

    $status = (int) $_POST['status'];
    $priority = (int) $_POST['priority'];
    $department = (int) $_POST['department'];
    $agent = (int) $_POST['agent'];

    require_once(__DIR__ . '/../database/connection.php');
    $db = getDatabaseConnection();


    $names = (strpos($_POST['tags'], ',') !== false) ? explode(',', $_POST['tags']) : array(trim($_POST['tags']));

    $tags = array();

    foreach ($names as $name) {
        $tag = Tag::getTagByName($db, $name);
        if ($tag) $tags[] = $tag;
    }

    require_once(__DIR__ . '/../database/class_ticket.php');
    $ticket = Ticket::getTicket($db, $id);

    if ($ticket && $ticket->editProperties($db, $status, $priority, $department, $agent, $tags))
        $session->addMessage(true, 'Ticket properties successfully edited');
    else
        $session->addMessage(false, 'Ticket properties could not be edited');

    header("Location: ../pages/ticket.php?id=$id");
?>
