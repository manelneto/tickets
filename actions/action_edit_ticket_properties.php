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

    require_once(__DIR__ . '/../database/class_ticket.php');

    $names = (strpos($_POST['tags'], ',') !== false) ? explode(',', $_POST['tags']) : array(trim($_POST['tags']));

    $tags = array();

    foreach ($names as $name) {
        $tag = Tag::getTagId($db, $name);
        if ($tag) $tags[] = $tag;
    }

    $ticket = Ticket::getTicket($db, $id);

    if ($ticket && $ticket->editProperties($db, $status, $priority === 0 ? null : $priority, $department === 0 ? null : $department, $agent === 0 ? null : $agent, $tags))
        $session->addMessage(true, 'Ticket properties successfully edited');
    else
        $session->addMessage(false, 'Some ticket properties could not be edited');

    header("Location: ../pages/ticket.php?id=$id");
?>
